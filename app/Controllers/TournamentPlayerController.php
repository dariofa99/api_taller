<?php
namespace App\Controllers;

use App\Models\TournamentPlayer;
use App\Repositorio\TournamentPlayerRepository;

class TournamentPlayerController
{

    private $repository;

    public function __construct()
    {
        $this->repository = new TournamentPlayerRepository();
    }

    public function index()
    {
        $tournamentPlayers = $this->repository->getAll();       
        echo json_encode($tournamentPlayers);
    }

    public function findById($id)
    {
        $tournamentPlayer = $this->repository->findById($id);
        if (!$tournamentPlayer) {
            http_response_code(404);
            echo json_encode([
                "message" => "Registro torneo-jugador no encontrado"
            ]);
            return;
        }
        echo json_encode($tournamentPlayer);
    }

    public function findByTournamentId($tournament_id)
    {
        $tournamentPlayers = $this->repository->findByTournamentId($tournament_id);
        if (empty($tournamentPlayers)) {
            http_response_code(404);
            echo json_encode([
                "message" => "No hay jugadores en este torneo"
            ]);
            return;
        }
        echo json_encode($tournamentPlayers);
    }

    public function findByPlayerId($player_id)
    {
        $tournamentPlayers = $this->repository->findByPlayerId($player_id);
        if (empty($tournamentPlayers)) {
            http_response_code(404);
            echo json_encode([
                "message" => "Este jugador no está en ningún torneo"
            ]);
            return;
        }
        echo json_encode($tournamentPlayers);
    }

    public function store($data)
    {
        if (
            empty($data['tournament_id']) ||
            empty($data['player_id'])            
        ) {
            http_response_code(400);
            echo json_encode([
                "message" => "Todos los campos son obligatorios"
            ]);
            return;
        }

        try {
            $data['registration_date'] = date('Y-m-d H:i:s');
            $tournamentPlayer = new TournamentPlayer($data);
            $result = $this->repository->create($tournamentPlayer);
            if ($result) {
                http_response_code(201);
                echo json_encode([
                    "message" => "Jugador registrado al torneo correctamente"
                ]);
            }
        } catch (\Throwable $th) {
            http_response_code(500);
            echo json_encode([
                "message" => $th->getMessage()
            ]);
        }
    }

    public function update($data)
    {
        if (
            empty($data['id']) ||
            empty($data['tournament_id']) ||
            empty($data['player_id']) ||
            empty($data['registration_date'])
        ) {
            http_response_code(400);
            echo json_encode([
                "message" => "Todos los campos son obligatorios"
            ]);
            return;
        }

        try {
            $tournamentPlayer = new TournamentPlayer($data);
            $result = $this->repository->update($data['id'], $tournamentPlayer);

            if ($result) {
                echo json_encode([
                    "message" => "Registro torneo-jugador actualizado correctamente"
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    "message" => "Error al actualizar registro"
                ]);
            }
        } catch (\Throwable $th) {
            http_response_code(500);
            echo json_encode([
                "message" => $th->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        try {
            $result = $this->repository->delete($id);

            if ($result) {
                echo json_encode([
                    "message" => "Registro torneo-jugador eliminado correctamente"
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    "message" => "Error al eliminar registro"
                ]);
            }
        } catch (\Throwable $th) {
            http_response_code(500);
            echo json_encode([
                "message" => $th->getMessage()
            ]);
        }
    }
}
