<?php

namespace App\Repositorio;

use Config\Database;
use Exception;
use PDO;
use Tournament;

class TournamentRepository {

    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getAll(){

        $sql = "SELECT * FROM tournaments";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id){

        $sql = "SELECT * FROM tournaments WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(Tournament $tournament){


    try {
        $sql = "INSERT INTO tournaments 
        (name, game_id, organizer_id, start_date, end_date, prize)
        VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $tournament->getName(),
            $tournament->getGameId(),
            $tournament->getOrganizerId(),
            $tournament->getStartDate(),
            $tournament->getEndDate(),
            $tournament->getPrize()
        ]);
    } catch (\Throwable $th) {
        throw new Exception("Error al crear torneo: " . $th->getMessage());
    }
       
    }

    public function update($id, Tournament $tournament){

        $sql = "UPDATE tournaments SET 
        name = ?, game_id = ?, organizer_id = ?, start_date = ?, end_date = ?, prize = ?
        WHERE id = ?";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $tournament->getName(),
            $tournament->getGameId(),
            $tournament->getOrganizerId(),
            $tournament->getStartDate(),
            $tournament->getEndDate(),
            $tournament->getPrize(),
            $id
        ]);
    }

    public function delete($id){

        $sql = "DELETE FROM tournaments WHERE id = ?";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$id]);
    }
}