<?php
namespace Config;

use PDO;
use PDOException;

class Database {

    public static function connect(){

        $host = "localhost";
        $db = "api_clase";
        $user = "root";
        $pass = "";

        try {

            $pdo = new PDO(
                "mysql:host=$host;dbname=$db;charset=utf8",
                $user,
                $pass
            );

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $pdo;

        } catch(PDOException $e){
            die($e->getMessage());
        }
    }
}