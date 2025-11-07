<?php
namespace app\controllers;

use app\core\Controller;
use app\models\Songs as SongsModel;

class Songs extends Controller
{
    public function index()
    {
        $songs = SongsModel::getAllSongs();
        $this->view('songs/index', ['songs' => $songs]);
    }
}
?>
