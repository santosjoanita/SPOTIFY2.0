<?php
namespace app\controllers;

use app\core\Controller;
use app\models\Genres as GenresModel;

class Genres extends Controller
{
    // Página para o pimeiro género com mais músicas do mesmo género
    public function onegenre($name = null)
    {
        $genreName = !empty($name) ? urldecode($name) : 'Old School';
        $items = GenresModel::getSongsByGenreName($genreName);
        $this->view('genres/1genre', ['items' => $items, 'genre' => $genreName]);
    }

    // Página para o 2º género com mais músicas do mesmo género
    public function twogenre($name = null)
    {
        $genreName = !empty($name) ? urldecode($name) : 'House';
        $items = GenresModel::getSongsByGenreName($genreName);
        $this->view('genres/2genre', ['items' => $items, 'genre' => $genreName]);
    }

    // Página para o 3º género com mais músicas do mesmo género
    public function threegenre($name = null)
    {
        $genreName = !empty($name) ? urldecode($name) : 'Techno';
        $items = GenresModel::getSongsByGenreName($genreName);
        $this->view('genres/3genre', ['items' => $items, 'genre' => $genreName]);
    }
}