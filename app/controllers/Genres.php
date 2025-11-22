<?php
namespace app\controllers;

use app\core\Controller;
use app\models\Genres as GenresModel;

class Genres extends Controller
{
    // Página para o género renomeado: 1genre (antigo Old School)
    public function onegenre($name = null)
    {
        $genreName = !empty($name) ? urldecode($name) : 'Old School';
        $items = GenresModel::getSongsByGenreName($genreName);
        $this->view('genres/1genre', ['items' => $items, 'genre' => $genreName]);
    }

    // Página para o género renomeado: 2genre (antigo House)
    public function twogenre($name = null)
    {
        $genreName = !empty($name) ? urldecode($name) : 'House';
        $items = GenresModel::getSongsByGenreName($genreName);
        $this->view('genres/2genre', ['items' => $items, 'genre' => $genreName]);
    }

    // Página para o género renomeado: 3genre (antigo Techno)
    public function threegenre($name = null)
    {
        $genreName = !empty($name) ? urldecode($name) : 'Techno';
        $items = GenresModel::getSongsByGenreName($genreName);
        $this->view('genres/3genre', ['items' => $items, 'genre' => $genreName]);
    }
}