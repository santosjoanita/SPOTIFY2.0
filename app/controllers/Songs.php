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
        $genres = SongsModel::getGenres(); // Busca géneros para o dropdown
        $this->view('songs/index', ['songs' => $songs, 'genres' => $genres, 'title' => 'All Songs']);
    }

    // Filtro por Género (ex: /Songs/genre/House)
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

    // Processar formulário de criação (COM UPLOAD)
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = isset($_POST['title']) ? trim($_POST['title']) : '';
            $artist = isset($_POST['artist']) ? trim($_POST['artist']) : '';

            if ($title === '' || $artist === '') {
                header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs?error=missing');
                exit;
            }

            // --- LÓGICA DE UPLOAD DE IMAGEM ---
            $url_alias = '/pw/tab1_pw/SPOTIFY2.0';
            // Imagem Default
            $coverPath = $url_alias . '/assets/img/records_albums.jpg'; 

            if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === 0) {
                // Caminho físico no servidor (Sobe 2 níveis de app/controllers)
                $targetDir = dirname(__DIR__, 2) . '/assets/img/uploads/';
                
                // Cria pasta se não existir
                if (!is_dir($targetDir)) { mkdir($targetDir, 0777, true); }

                $extension = pathinfo($_FILES['cover_image']['name'], PATHINFO_EXTENSION);
                $newFileName = uniqid('cover_', true) . '.' . $extension;
                $targetFile = $targetDir . $newFileName;

                if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $targetFile)) {
                    // Caminho URL para guardar na BD
                    $coverPath = $url_alias . '/assets/img/uploads/' . $newFileName;
                }
            }
            // ----------------------------------

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

    // Detalhes de uma música
    public function show($id = null) {
        // ... (mantém a tua lógica de show se quiseres, ou usa a do index)
        // Para simplificar, vou omitir, pois o design principal é no index
    }

    // Apagar música
    public function delete($id = null)
    {
        if (!empty($id)) {
            SongsModel::deleteSong((int)$id);
        }
        header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs');
        exit;
    }
    
    // Editar música (Página de edição)
    public function edit($id = null)
    {
         if (empty($id)) { header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs'); exit; }
         
         // Nota: O model getAllSongs já retorna tudo, mas é ineficiente. 
         // O ideal seria ter um getSongById no model.
         $all = SongsModel::getAllSongs();
         $song = null;
         foreach ($all as $s) { if ($s['id'] == $id) { $song = $s; break; } }
         
         $genres = SongsModel::getGenres();
         $this->view('songs/update', ['song' => $song, 'genres' => $genres]);
    }
    
  // Processar a atualização (com upload de imagem)
    public function update($id)
    {
        // Verifica se há POST e ID
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($id)) {
            
            // 1. Ir buscar a música atual para saber qual é a imagem antiga
            $allSongs = SongsModel::getAllSongs();
            $currentSong = null;
            foreach($allSongs as $s) {
                if ($s['id'] == $id) { $currentSong = $s; break; }
            }

            $url_alias = '/pw/tab1_pw/SPOTIFY2.0';
            
            // Por defeito, mantemos a imagem que já lá estava
            $coverPath = $currentSong['cover_url'] ?? ($url_alias . '/assets/img/records_albums.jpg');

            // 2. Verificamos se o utilizador carregou UMA NOVA imagem
            if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === 0) {
                
                // Caminho da pasta uploads
                $targetDir = dirname(__DIR__, 2) . '/assets/img/uploads/';
                if (!is_dir($targetDir)) { mkdir($targetDir, 0777, true); }

                // Gerar novo nome e mover
                $extension = pathinfo($_FILES['cover_image']['name'], PATHINFO_EXTENSION);
                $newFileName = uniqid('cover_', true) . '.' . $extension;

                if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $targetDir . $newFileName)) {
                    // Se o upload correu bem, atualizamos o caminho
                    $coverPath = $url_alias . '/assets/img/uploads/' . $newFileName;
                }
            }

            // 3. Preparar dados para enviar para o Model
            $data = [
                'title' => $_POST['title'],
                'artist' => $_POST['artist'],
                'album' => $_POST['album'] ?? null,
                'genre_id' => $_POST['genre_id'] ?? null,
                'year' => $_POST['year'] ?? null,
                'cover_url' => $coverPath // <--- Aqui vai a nova imagem (ou a velha se não mudou)
            ];

            // Atualizar na BD
            SongsModel::updateSong($id, $data);
        }

        // Voltar para a lista
        header('Location: /pw/tab1_pw/SPOTIFY2.0/Songs');
        exit;
    }
}
?>