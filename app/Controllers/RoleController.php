<?php
namespace App\Controllers;

use App\Models\Role;
use App\Repositorio\RoleRepository;

class RoleController
{

    private $repository;

    public function __construct()
    {
        $this->repository = new RoleRepository();
    }

    public function index()
    {
        $roles = $this->repository->getAll();       
        echo json_encode($roles);
    }

    public function findById($id)
    {
        $role = $this->repository->findById($id);
        if (!$role) {
            http_response_code(404);
            echo json_encode([
                "message" => "Rol no encontrado"
            ]);
            return;
        }
        echo json_encode($role);
    }

    public function store($data)
    {
        

        if (empty($data['name'])) {
            http_response_code(400);

            echo json_encode([
                "message" => "El nombre del rol es obligatorio"
            ]);
            return;
        }

        try {
            $role = new Role($data);
            $result = $this->repository->create($role);
            if ($result) {
                http_response_code(201);
                echo json_encode([
                    "message" => "Rol creado correctamente"
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
        $role = new Role($data);
        $result = $this->repository->update($data['id'], $role);

        if ($result) {
            echo json_encode([
                "message" => "Rol actualizado correctamente"
            ]);
        } else {
            http_response_code(400);
            echo json_encode([
                "message" => "Error al actualizar el rol"
            ]);
        }
    }

    public function delete($id)
    {
        $result = $this->repository->delete($id);

        if ($result) {
            echo json_encode([
                "message" => "Rol eliminado correctamente"
            ]);
        } else {
            http_response_code(400);
            echo json_encode([
                "message" => "Error al eliminar el rol"
            ]);
        }
    }
}
