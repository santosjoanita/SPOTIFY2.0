<?php
namespace app\controllers;

use app\core\Controller;
use app\models\Genres as GenresModel;

class Genres extends Controller
{
    public function oldschool()
    {
        // Busca na BD todas as músicas onde o género é "Old School"
        $items = GenresModel::getSongsByGenreName('Old School');
        $this->view('genres/oldschool', ['items' => $items]);
    }

    public function house()
    {
        // Busca na BD todas as músicas onde o género é "House"
        $items = GenresModel::getSongsByGenreName('House');
        $this->view('genres/house', ['items' => $items]);
    }

    public function techno()
    {
        // ATENÇÃO: Verifica na tua BD se está escrito "Techno" ou "Tecno" (ID 3)
        // Vou usar "Techno" como padrão, se não der altera para "Tecno" aqui.
        $items = GenresModel::getSongsByGenreName('Techno'); 
        
        // Se na tua BD estiver "Tecno", usa a linha abaixo em vez da de cima:
        // $items = GenresModel::getSongsByGenreName('Tecno');
        
        $this->view('genres/techno', ['items' => $items]);
    }
}