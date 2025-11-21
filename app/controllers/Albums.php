<?php
namespace app\controllers;

use app\core\Controller;

class Albums extends Controller
{
    public function index()
    {
        // exemplo estático de álbuns — pode ser substituído por um model/consulta à BD
        $albums = [
            ['title' => 'Nome do album', 'artist' => 'Artista', 'year' => 'Ano', 'cover' => $this->getAssetPath('records_albums.jpg')],
            ['title' => 'Nome do album', 'artist' => 'Artista', 'year' => 'Ano', 'cover' => $this->getAssetPath('records_albums.jpg')],
            ['title' => 'Nome do album', 'artist' => 'Artista', 'year' => 'Ano', 'cover' => $this->getAssetPath('records_albums.jpg')],
            ['title' => 'Nome do album', 'artist' => 'Artista', 'year' => 'Ano', 'cover' => $this->getAssetPath('records_albums.jpg')]
        ];

        $this->view('albums/index', ['albums' => $albums]);
    }

    // utilitário para construir o caminho relativo para assets (mesma base usada nas views)
    private function getAssetPath($file)
    {
        return '/pw/tab1_pw/SPOTIFY2.0/assets/img/' . $file;
    }
}
