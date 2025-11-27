<?php

class Album {
    public $id;
    public $name;
    public $cover;
    public $created_at;

    // Método para buscar TODOS os álbuns
    public static function getAll() {
        $db = Db::getInstance(); // Conexão
        $req = $db->query('SELECT * FROM albums ORDER BY name ASC');
        
       
        return $req->fetchAll(PDO::FETCH_CLASS, 'Album');
    }

    // Método para buscar UM álbum pelo ID
    public static function getById($id) {
        $db = Db::getInstance();
        $id = intval($id); // Garante que é um inteiro
        
        $req = $db->prepare('SELECT * FROM albums WHERE id = :id');
        $req->execute(['id' => $id]);
        
      
        $req->setFetchMode(PDO::FETCH_CLASS, 'Album');
        
        return $req->fetch();
    }

    // Método para buscar as músicas deste álbum

    public function getSongs() {
        $db = Db::getInstance();
        $req = $db->prepare('SELECT * FROM songs WHERE album_id = :id');
        $req->execute(['id' => $this->id]);
        
        return $req->fetchAll(PDO::FETCH_CLASS, 'Song'); 

    // Método para criar um novo álbum (caso precises no futuro)
    public static function create($name, $cover) {
        $db = Db::getInstance();
        $req = $db->prepare('INSERT INTO albums (name, cover, created_at) VALUES (:name, :cover, NOW())');
        return $req->execute([
            'name' => $name,
            'cover' => $cover
        ]);
    }
}