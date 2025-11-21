<?php
namespace app\controllers;

use app\core\Controller;
use app\models\Songs as SongsModel;
use app\models\Genres as GenresModel;

class Songs extends Controller
{
    public function index()
    {
        $songs = SongsModel::getAllSongs();
        $genres = GenresModel::getAllGenres();
        $this->view('songs/index', ['songs' => $songs, 'genres' => $genres]);
    }

    // Show full-page create form (uses view songs/create)
    public function create()
    {
        $genres = GenresModel::getAllGenres();
        $this->view('songs/create', ['genres' => $genres]);
    }

    // Show single song details (uses view songs/get)
    public function show($id = null)
    {
        if (empty($id)) {
            header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs');
            exit;
        }
        $all = SongsModel::getAllSongs();
        $song = null;
        foreach ($all as $s) {
            if ((int)$s['id'] === (int)$id) { $song = $s; break; }
        }
        $genres = GenresModel::getAllGenres();
        if (!$song) {
            $this->view('songs/get', ['song' => null, 'genres' => $genres]);
            return;
        }
        $this->view('songs/get', ['song' => $song, 'genres' => $genres]);
    }

    // Recebe o POST do formulário para criar uma nova canção
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = isset($_POST['title']) ? trim($_POST['title']) : '';
            $artist = isset($_POST['artist']) ? trim($_POST['artist']) : '';

            // Title and artist are required
            if ($title === '' || $artist === '') {
                // redirect back with error flag
                header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs?error=missing');
                exit;
            }

            $data = [
                'title' => $title,
                'artist' => $artist,
                'album' => $_POST['album'] ?? null,
                'genre_id' => !empty($_POST['genre_id']) ? (int)$_POST['genre_id'] : null,
                'year' => $_POST['year'] ?? null,
                'cover_url' => $_POST['cover_url'] ?? null
            ];

            SongsModel::createSong($data);
        }

        header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs');
        exit;
    }

    // Apaga uma canção pelo id (rota: /Songs/delete/{id})
    public function delete($id = null)
    {
        if (empty($id)) {
            $this->view('songs/index', ['songs' => SongsModel::getAllSongs(), 'error' => 'ID inválido']);
            return;
        }

        SongsModel::deleteSong((int)$id);
        header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs');
        exit;
    }

    // Apaga múltiplas canções (recebe POST com ids[])
    public function deleteMultiple()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['ids']) && is_array($_POST['ids'])) {
            foreach ($_POST['ids'] as $id) {
                $id = (int)$id;
                if ($id > 0) {
                    SongsModel::deleteSong($id);
                }
            }
        }

        header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs');
        exit;
    }

    // Show edit form
    public function edit($id = null)
    {
        if (empty($id)) {
            header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs');
            exit;
        }
        $all = SongsModel::getAllSongs();
        $song = null;
        foreach ($all as $s) {
            if ((int)$s['id'] === (int)$id) { $song = $s; break; }
        }
        $genres = GenresModel::getAllGenres();
        $this->view('songs/update', ['song' => $song, 'genres' => $genres]);
    }

    // Handle update POST
    public function update($id = null)
    {
        if (empty($id) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs');
            exit;
        }
        $title = isset($_POST['title']) ? trim($_POST['title']) : '';
        $artist = isset($_POST['artist']) ? trim($_POST['artist']) : '';
        if ($title === '' || $artist === '') {
            header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs/edit/' . $id . '?error=missing');
            exit;
        }
        $data = [
            'title' => $title,
            'artist' => $artist,
            'album' => $_POST['album'] ?? null,
            'genre_id' => !empty($_POST['genre_id']) ? (int)$_POST['genre_id'] : null,
            'year' => $_POST['year'] ?? null,
            'cover_url' => $_POST['cover_url'] ?? null
        ];
        SongsModel::updateSong((int)$id, $data);
        header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs');
        exit;
    }
}
?>
