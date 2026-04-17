<?php
namespace App\Models;

class TournamentPlayer {

    private $id;
    private $tournament_id;
    private $player_id;
    private $registration_date;

    public function __construct($data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->tournament_id = $data['tournament_id'] ?? null;
        $this->player_id = $data['player_id'] ?? null;
        $this->registration_date = $data['registration_date'] ?? null;
    }

    public function getId(){
        return $this->id;
    }

    public function getTournamentId(){
        return $this->tournament_id;
    }

    public function getPlayerId(){
        return $this->player_id;
    }

    public function getRegistrationDate(){
        return $this->registration_date;
    }
}
