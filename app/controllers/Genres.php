<?php
namespace app\controllers;

use app\core\Controller;

class Genres extends Controller
{
    public function oldschool()
    {
        $items = $this->sampleItems('Old School');
        $this->view('genres/oldschool', ['items' => $items]);
    }

    public function house()
    {
        $items = $this->sampleItems('House');
        $this->view('genres/house', ['items' => $items]);
    }

    public function techno()
    {
        $items = $this->sampleItems('Tecno');
        $this->view('genres/techno', ['items' => $items]);
    }

    private function sampleItems($genre)
    {
        // Exemplo estático; substituir por consultas ao modelo se desejar
        $img = '/pw/tab1_pw/SPOTIFY2.0/assets/img/records_albums.jpg';
        return [
            ['title' => "$genre Track 1", 'artist' => 'Artista A', 'year' => '2020', 'cover' => $img],
            ['title' => "$genre Track 2", 'artist' => 'Artista B', 'year' => '2019', 'cover' => $img],
            ['title' => "$genre Track 3", 'artist' => 'Artista C', 'year' => '2018', 'cover' => $img],
            ['title' => "$genre Track 4", 'artist' => 'Artista D', 'year' => '2017', 'cover' => $img]
        ];
    }
}
