<?php
namespace app\controllers;

use app\core\Controller;
use app\models\Songs as SongsModel; // Usa o model songs para obter os álbuns

class Albums extends Controller
{
    public function index()
    {
        // Busca os dados reais à Base de Dados
        $albums = SongsModel::getSongsWithAlbum();
        
        // Envia para a View
        $this->view('albums/index', ['albums' => $albums]);
    }
}