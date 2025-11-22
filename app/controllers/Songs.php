<?php
namespace app\controllers;

use app\core\Controller;
use app\models\Songs as SongsModel;

class Songs extends Controller
{
    // Página Principal (Todas as músicas)
    public function index()
    {
        $songs = SongsModel::getAllSongs();
        $genres = SongsModel::getGenres();
        $this->view('songs/index', ['songs' => $songs, 'genres' => $genres, 'title' => 'All Songs']);
    }

    // Filtro Dinâmico por Género
    // Chamado quando clicas num dos cards da Home Page
    public function genre($name) {
        $name = urldecode($name); // Decodifica %20 para espaços
        $songs = SongsModel::getSongsByGenreName($name);
        $genres = SongsModel::getGenres();
        $this->view('songs/index', ['songs' => $songs, 'genres' => $genres, 'title' => $name]);
    }

    // Filtro por Álbuns
    public function albuns() {
        $songs = SongsModel::getSongsWithAlbum();
        $genres = SongsModel::getGenres();
        $this->view('songs/index', ['songs' => $songs, 'genres' => $genres, 'title' => 'Álbuns']);
    }

    // Adicionar Música (Create)
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = isset($_POST['title']) ? trim($_POST['title']) : '';
            $artist = isset($_POST['artist']) ? trim($_POST['artist']) : '';

            if ($title === '' || $artist === '') {
                header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs?error=missing');
                exit;
            }

            // --- LÓGICA DE UPLOAD ---
            $url_alias = '/pw/tab1_pw/SPOTIFY2.0';
            $coverPath = $url_alias . '/assets/img/records_albums.jpg'; // Default

            if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === 0) {
                // Sobe 2 níveis para encontrar a pasta assets na raiz
                $targetDir = dirname(__DIR__, 2) . '/assets/img/uploads/';
                if (!is_dir($targetDir)) { mkdir($targetDir, 0777, true); }

                $extension = pathinfo($_FILES['cover_image']['name'], PATHINFO_EXTENSION);
                $newFileName = uniqid('cover_', true) . '.' . $extension;
                
                if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $targetDir . $newFileName)) {
                    $coverPath = $url_alias . '/assets/img/uploads/' . $newFileName;
                }
            }
            // ------------------------

            $data = [
                'title' => $title,
                'artist' => $artist,
                'album' => $_POST['album'] ?? null,
                'genre_id' => $_POST['genre_id'] ?? null,
                'year' => $_POST['year'] ?? null,
                'cover_url' => $coverPath
            ];

            SongsModel::createSong($data);
        }

        header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs');
        exit;
    }

    // Apagar Música
    public function delete($id = null)
    {
        if (!empty($id)) {
            SongsModel::deleteSong((int)$id);
        }
        header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs');
        exit;
    }
}
?>