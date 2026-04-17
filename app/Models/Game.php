<?php
namespace App\Models;

class Game {

    private $id;
    private $name;
    private $genre;
    private $platform;

    public function __construct($data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->genre = $data['genre'] ?? null;
        $this->platform = $data['platform'] ?? null;
    }

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getGenre(){
        return $this->genre;
    }

    public function getPlatform(){
        return $this->platform;
    }
}