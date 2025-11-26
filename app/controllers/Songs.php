<?php
namespace app\controllers;

// 1. Iniciar sessão para verificar se é admin
if (session_status() === PHP_SESSION_NONE) session_start();

use app\core\Controller;
use app\models\Songs as SongsModel;

class Songs extends Controller
{
    public function index()
    {
        $songs = SongsModel::getAllSongs();
        $genres = SongsModel::getGenres();
        $this->view('songs/index', ['songs' => $songs, 'genres' => $genres, 'title' => 'All Songs']);
    }

    // Filtro por URL (ex: clicar no card da Home)
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

    // Detalhes de uma música (Opcional, redireciona se não houver ID)
    public function show($id = null) {
        if (empty($id)) { header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs'); exit; }
        // Se quiseres implementar uma view de detalhes, seria aqui
    }

    // =========================================================
    // ÁREA PROTEGIDA (APENAS ADMIN)
    // =========================================================

    // Criar Música (Store)
    public function store()
    {
        // VERIFICAÇÃO DE SEGURANÇA
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

            // Lógica de Upload
            $url_alias = '/pw/tab1_pw/SPOTIFY2.0';
            $coverPath = $url_alias . '/assets/img/records_albums.jpg'; // Imagem default

            if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === 0) {
                // Sobe 2 níveis (sai de controllers, sai de app) para ir para assets
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

    // Apagar Música
    public function delete($id = null)
    {
        // VERIFICAÇÃO DE SEGURANÇA
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs'); exit;
        }

        if (!empty($id)) {
            SongsModel::deleteSong((int)$id);
        }
        header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs');
        exit;
    }
    
    // Editar Música (Mostrar Formulário)
    public function edit($id = null)
    {
        // VERIFICAÇÃO DE SEGURANÇA
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs'); exit;
        }

        if (empty($id)) { header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs'); exit; }
        
        // Busca a música específica
        $all = SongsModel::getAllSongs();
        $song = null;
        foreach ($all as $s) { if ($s['id'] == $id) { $song = $s; break; } }
        
        $genres = SongsModel::getGenres();
        $this->view('songs/update', ['song' => $song, 'genres' => $genres]);
    }
    
    // Atualizar Música (Processar Update)
    public function update($id)
    {
        // VERIFICAÇÃO DE SEGURANÇA
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs'); exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($id)) {
            
            // Buscar dados atuais para manter a imagem se não houver upload novo
            $allSongs = SongsModel::getAllSongs();
            $currentSong = null;
            foreach($allSongs as $s) {
                if ($s['id'] == $id) { $currentSong = $s; break; }
            }

            $url_alias = '/pw/tab1_pw/SPOTIFY2.0';
            $coverPath = $currentSong['cover_url'] ?? ($url_alias . '/assets/img/records_albums.jpg');

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