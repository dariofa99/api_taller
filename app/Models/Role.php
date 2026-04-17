<?php
namespace App\Models;

class Role {

    private $id;
    private $name;

    public function __construct($data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? null;
    }

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }
}