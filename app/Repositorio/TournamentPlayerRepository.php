<?php
namespace App\Repositorio;

use App\Models\TournamentPlayer;
use Config\Database;
use Exception;
use PDO;

class TournamentPlayerRepository {

    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getAll(){

        $sql = "SELECT * FROM tournament_players";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id){
        $sql = "SELECT * FROM tournament_players WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByTournamentId($tournament_id){
        $sql = "SELECT * FROM tournament_players WHERE tournament_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$tournament_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByPlayerId($player_id){
        $sql = "SELECT * FROM tournament_players WHERE player_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$player_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(TournamentPlayer $tournamentPlayer){

        try {
            $sql = "INSERT INTO tournament_players (tournament_id, player_id, registration_date)
                    VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $tournamentPlayer->getTournamentId(),
                $tournamentPlayer->getPlayerId(),
                $tournamentPlayer->getRegistrationDate()
            ]);
        } catch (\Throwable $th) {
            throw new Exception("Error al crear registro de torneo-jugador: " . $th->getMessage());
        }
    }

    public function update($id, TournamentPlayer $tournamentPlayer){

        $sql = "UPDATE tournament_players
                SET tournament_id = ?, player_id = ?, registration_date = ?
                WHERE id = ?";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $tournamentPlayer->getTournamentId(),
            $tournamentPlayer->getPlayerId(),
            $tournamentPlayer->getRegistrationDate(),
            $id
        ]);
    }

    public function delete($id){

        $sql = "DELETE FROM tournament_players WHERE id = ?";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$id]);
    }
}
