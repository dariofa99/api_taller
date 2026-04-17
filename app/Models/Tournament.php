<?php

class Tournament {

    private $id;
    private $name;
    private $gameId;
    private $organizerId;
    private $startDate;
    private $endDate;
    private $prize;

    public function __construct($data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->gameId = $data['game_id'] ?? null;
        $this->organizerId = $data['organizer_id'] ?? null;
        $this->startDate = $data['start_date'] ?? null;
        $this->endDate = $data['end_date'] ?? null;
        $this->prize = $data['prize'] ?? null;
    }

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getGameId(){
        return $this->gameId;
    }

    public function getOrganizerId(){
        return $this->organizerId;
    }

    public function getStartDate(){
        return $this->startDate;
    }

    public function getEndDate(){
        return $this->endDate;
    }

    public function getPrize(){
        return $this->prize;
    }
}