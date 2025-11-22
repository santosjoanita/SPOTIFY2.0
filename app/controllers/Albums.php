<?php
namespace app\controllers;

use app\core\Controller;
use app\models\Songs as SongsModel;

class Albums extends Controller
{
    public function index()
    {
        // Busca à base de dados apenas as músicas que têm o campo 'album' preenchido
        // (Usando a função que já existe no teu Model Songs)
        $albums = SongsModel::getSongsWithAlbum();
        
        $this->view('albums/index', ['albums' => $albums]);
    }
}