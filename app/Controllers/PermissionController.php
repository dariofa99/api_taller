<?php
namespace App\Controllers;

use App\Models\Permission;
use App\Repositorio\PermissionRepository;

class PermissionController
{

    private $repository;

    public function __construct()
    {
        $this->repository = new PermissionRepository();
    }

    public function index()
    {
        $permissions = $this->repository->getAll();       
        echo json_encode($permissions);
    }

    public function findById($id)
    {
        $permission = $this->repository->findById($id);
        if (!$permission) {
            http_response_code(404);
            echo json_encode([
                "message" => "Permiso no encontrado"
            ]);
            return;
        }
        echo json_encode($permission);
    }

    public function store($data)
    {
         if (empty($data['name'])) {
            http_response_code(400);

            echo json_encode([
                "message" => "El nombre del permiso es obligatorio"
            ]);
            return;
        }

        try {
            $permission = new Permission($data);
            $result = $this->repository->create($permission);
            if ($result) {
                http_response_code(201);
                echo json_encode([
                    "message" => "Permiso creado correctamente"
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
        $permission = new Permission($data);
        $result = $this->repository->update($data['id'], $permission);

        if ($result) {
            echo json_encode([
                "message" => "Permiso actualizado correctamente"
            ]);
        } else {
            http_response_code(400);
            echo json_encode([
                "message" => "Error al actualizar el permiso"
            ]);
        }
    }

    public function delete($id)
    {
        $result = $this->repository->delete($id);

        if ($result) {
            echo json_encode([
                "message" => "Permiso eliminado correctamente"
            ]);
        } else {
            http_response_code(400);
            echo json_encode([
                "message" => "Error al eliminar el permiso"
            ]);
        }
    }
}
