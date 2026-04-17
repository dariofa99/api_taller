<?php
namespace App\Controllers;

use App\Repositorio\TournamentRepository;
use Tournament;

class TournamentController
{

    private $repository;

    public function __construct()
    {
        $this->repository = new TournamentRepository();
    }

    public function index()
    {

        $data = $this->repository->getAll();

        echo json_encode($data);
    }

    public function show($id)
    {

        $data = $this->repository->findById($id);

        if (!$data) {
            http_response_code(404);

            echo json_encode([
                "message" => "Torneo no encontrado"
            ]);
            return;
        }

        echo json_encode($data);
    }

    public function store($data)
    {


        try {
            $tournament = new Tournament($data);
            $result = $this->repository->create($tournament);
            if ($result) {
                echo json_encode([
                    "message" => "Torneo creado correctamente"
                ]);
            }
        } catch (\Throwable $th) {
            http_response_code(500);

            echo json_encode([
                "message" => $th->getMessage()
            ]);
        }
    }

    public function update($data, $id)
    {


        $tournament = new Tournament($data);
        $result = $this->repository->update($id, $tournament);
        if ($result) {
            echo json_encode([
                "message" => "Torneo actualizado correctamente"
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                "message" => "Error al actualizar torneo"
            ]);
        }
    }

    public function delete($id)
    {

        $result = $this->repository->delete($id);

        if ($result) {
            echo json_encode([
                "message" => "Torneo eliminado correctamente"
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                "message" => "Error al eliminar torneo"
            ]);
        }
    }
}
