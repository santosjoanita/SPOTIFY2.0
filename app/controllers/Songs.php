<?php
namespace app\controllers;
if(!isset($_SESSION)) { session_start(); } // <--- ADICIONA ESTA LINHA AQUI

use app\core\Controller;
use app\models\Songs as SongsModel;


class Songs extends Controller
{
    // =========================================================
    // ÁREA PÚBLICA (VISÍVEL PARA ADMIN E CONVIDADO)
    // =========================================================

    // Página Principal (Todas as músicas)
    public function index()
    {
        $songs = SongsModel::getAllSongs();
        $genres = SongsModel::getGenres();
        $this->view('songs/index', ['songs' => $songs, 'genres' => $genres, 'title' => 'All Songs']);
    }

    // Filtro por Género
    public function genre($name) {
        $name = urldecode($name);
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

    // Detalhes de uma música (opcional)
    public function show($id = null) {
        // Mantém a lógica se a tiveres, acessível a todos
    }

    // =========================================================
    // ÁREA PROTEGIDA (APENAS ADMIN)
    // =========================================================

    // Processar formulário de criação
    public function store()
    {
        // 1. SEGURANÇA: Só Admin pode entrar aqui
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs'); exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = isset($_POST['title']) ? trim($_POST['title']) : '';
            $artist = isset($_POST['artist']) ? trim($_POST['artist']) : '';

            if ($title === '' || $artist === '') {
                header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs?error=missing');
                exit;
            }

            // --- LÓGICA DE UPLOAD ---
            $url_alias = '/pw/tab1_pw/SPOTIFY2.0';
            $coverPath = $url_alias . '/assets/img/records_albums.jpg'; 

            if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === 0) {
                $targetDir = dirname(__DIR__, 2) . '/assets/img/uploads/';
                if (!is_dir($targetDir)) { mkdir($targetDir, 0777, true); }

                $extension = pathinfo($_FILES['cover_image']['name'], PATHINFO_EXTENSION);
                $newFileName = uniqid('cover_', true) . '.' . $extension;
                
                if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $targetDir . $newFileName)) {
                    $coverPath = $url_alias . '/assets/img/uploads/' . $newFileName;
                }
            }

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

<<<<<<< HEAD
    // Detalhes de uma música
    public function show($id = null) {
        if (empty($id)) { header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs'); exit; }
        
        // Busca a música pelo ID
        $song = SongsModel::getSongById((int)$id);
        if (!$song) {
            header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs');
            exit;
        }

        $genres = SongsModel::getGenres();
        $this->view('songs/show', ['song' => $song, 'genres' => $genres]);
    }

=======
>>>>>>> 6a7d35deaec35b41596748683b52ac7f05421c05
    // Apagar música
    public function delete($id = null)
    {
        // 1. SEGURANÇA: Só Admin pode entrar aqui
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs'); exit;
        }

        if (!empty($id)) {
            SongsModel::deleteSong((int)$id);
        }
        header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs');
        exit;
    }
    
    // Editar música (Mostrar formulário)
    public function edit($id = null)
    {
        // 1. SEGURANÇA: Só Admin pode entrar aqui
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs'); exit;
        }

        if (empty($id)) { header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs'); exit; }
        
        $all = SongsModel::getAllSongs();
        $song = null;
        foreach ($all as $s) { if ($s['id'] == $id) { $song = $s; break; } }
        
        $genres = SongsModel::getGenres();
        $this->view('songs/update', ['song' => $song, 'genres' => $genres]);
    }
    
    // Processar a atualização (Update)
    public function update($id)
    {
        // 1. SEGURANÇA: Só Admin pode entrar aqui
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs'); exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($id)) {
            
            // Buscar dados antigos
            $allSongs = SongsModel::getAllSongs();
            $currentSong = null;
            foreach($allSongs as $s) {
                if ($s['id'] == $id) { $currentSong = $s; break; }
            }

            $url_alias = '/pw/tab1_pw/SPOTIFY2.0';
            $coverPath = $currentSong['cover_url'] ?? ($url_alias . '/assets/img/records_albums.jpg');

            // Verifica se houve upload de nova imagem
            if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === 0) {
                $targetDir = dirname(__DIR__, 2) . '/assets/img/uploads/';
                if (!is_dir($targetDir)) { mkdir($targetDir, 0777, true); }

                $extension = pathinfo($_FILES['cover_image']['name'], PATHINFO_EXTENSION);
                $newFileName = uniqid('cover_', true) . '.' . $extension;

                if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $targetDir . $newFileName)) {
                    $coverPath = $url_alias . '/assets/img/uploads/' . $newFileName;
                }
            }

            $data = [
                'title' => $_POST['title'],
                'artist' => $_POST['artist'],
                'album' => $_POST['album'] ?? null,
                'genre_id' => $_POST['genre_id'] ?? null,
                'year' => $_POST['year'] ?? null,
                'cover_url' => $coverPath
            ];

            SongsModel::updateSong($id, $data);
        }

        header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs');
        exit;
    }
}
?>