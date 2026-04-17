<?php
namespace App\Controllers;

use App\Models\Game;
use App\Models\User;
use App\Repositorio\UserRepository;

class UserController
{

    private $repository;

    public function __construct()
    {
        $this->repository = new UserRepository();
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
                "message" => "Usuario no encontrado"
            ]);
            return;
        }
        echo json_encode($game);
    }

    public function store($data)
    {

       // $data = json_decode(file_get_contents("php://input"), true);

        if (
            empty($data['name']) ||
            empty($data['email']) ||
            empty($data['role_id']) ||
            empty($data['password']) 
        ) {
            http_response_code(400);
            echo json_encode([
                "message" => "Todos los campos son obligatorios"
            ]);
            return;
        }

        try {
            $game = new User($data);
            $result = $this->repository->create($game);
            if ($result) {
                http_response_code(201);
                echo json_encode([
                    "message" => "Usuario creado correctamente"
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

  
        $game = new User($data);
        $result = $this->repository->update($data['id'], $game);

        if ($result) {
            echo json_encode([
                "message" => "Usuario actualizado correctamente"
            ]);
        } else {
            http_response_code(500);

            echo json_encode([
                "message" => "Error al actualizar usuario"
            ]);
        }
    }

    public function delete($id)
    {

        $result = $this->repository->delete($id);

        if ($result) {
            echo json_encode([
                "message" => "Usuario eliminado correctamente"
            ]);
        } else {
            http_response_code(500);

            echo json_encode([
                "message" => "Error al eliminar usuario"
            ]);
        }
    }
}
