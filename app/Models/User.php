<?php
namespace App\Models;

class User {

    private $id;
    private $name;
    private $email;
    private $password;
    private $role_id;

    public function __construct($data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->password = $data['password'] ?? null;
        $this->role_id = $data['role_id'] ?? null;
    }

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getRole(){
        return $this->role_id;
    }
    

   
}