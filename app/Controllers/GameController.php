<?php
namespace App\Controllers;

use App\Models\Game;
use App\Repositorio\GameRepository;

class GameController
{

    private $repository;

    public function __construct()
    {
        $this->repository = new GameRepository();
    }

    public function index()
    {

        $games = $this->repository->getAll();       
        echo json_encode($games);
    }

    public function findById($id)
    {

        $game = $this->repository->findById($id);
        if (!$game) {
            http_response_code(404);
            echo json_encode([
                "message" => "Juego no encontrado"
            ]);
            return;
        }
        echo json_encode($game);
    }

    public function store()
    {

        $data = json_decode(file_get_contents("php://input"), true);

        if (
            empty($data['name']) ||
            empty($data['genre']) ||
            empty($data['platform'])
        ) {
            http_response_code(400);

            echo json_encode([
                "message" => "Todos los campos son obligatorios"
            ]);
            return;
        }

        try {
            $game = new Game($data);
            $result = $this->repository->create($game);
            if ($result) {
                http_response_code(201);
                echo json_encode([
                    "message" => "Juego creado correctamente"
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

  
        $game = new Game($data);
        $result = $this->repository->update($data['id'], $game);

        if ($result) {
            echo json_encode([
                "message" => "Juego actualizado correctamente"
            ]);
        } else {
            http_response_code(500);

            echo json_encode([
                "message" => "Error al actualizar juego"
            ]);
        }
    }

    public function delete($data)
    {

        $result = $this->repository->delete($data['id']);

        if ($result) {
            echo json_encode([
                "message" => "Juego eliminado correctamente"
            ]);
        } else {
            http_response_code(500);

            echo json_encode([
                "message" => "Error al eliminar juego"
            ]);
        }
    }
}
