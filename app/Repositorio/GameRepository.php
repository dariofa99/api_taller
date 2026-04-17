<?php
 namespace App\Repositorio;

use App\Models\Game;
use Config\Database;
use Exception;
use PDO;

class GameRepository {

    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getAll(){

        $sql = "SELECT * FROM games";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id){
        $sql = "SELECT * FROM games WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(Game $game){

    try {
         $sql = "INSERT INTO games (name, genre, platform)
                VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $game->getName(),
            $game->getGenre(),
            $game->getPlatform()
        ]);
    } catch (\Throwable $th) {
        throw new Exception("Error al crear juego: " . $th->getMessage());
    }
       
    }

    public function update($id, Game $game){

        $sql = "UPDATE games
                SET name = ?, genre = ?, platform = ?
                WHERE id = ?";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $game->getName(),
            $game->getGenre(),
            $game->getPlatform(),
            $id
        ]);
    }

    public function delete($id){

        $sql = "DELETE FROM games WHERE id = ?";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$id]);
    }
}