<?php
namespace App\Controllers;

use App\Models\RolePermission;
use App\Repositorio\RolePermissionRepository;

class RolePermissionController
{

    private $repository;

    public function __construct()
    {
        $this->repository = new RolePermissionRepository();
    }

    public function index()
    {
        $rolePermissions = $this->repository->getAll();       
        echo json_encode($rolePermissions);
    }

    public function getPermissionsByRole($role_id)
    {
        $permissions = $this->repository->getPermissionsByRole($role_id);
        echo json_encode($permissions);
    }

    public function getRolesByPermission($permiso_id)
    {
        $roles = $this->repository->getRolesByPermission($permiso_id);
        echo json_encode($roles);
    }

    public function assign($data)
    {
     
        if (empty($data['role_id']) || empty($data['permission_id'])) {
            http_response_code(400);

            echo json_encode([
                "message" => "El role_id y permiso_id son obligatorios"
            ]);
            return;
        }

        try {
            $rolePermission = new RolePermission($data);
            $result = $this->repository->assign($rolePermission);
            if ($result) {
                http_response_code(201);
                echo json_encode([
                    "message" => "Permiso asignado al rol correctamente"
                ]);
            } 
        } catch (\Throwable $th) {
            http_response_code(500);
            echo json_encode([
                "message" => $th->getMessage()
            ]);
        }
    }

    public function revoke($role_id, $permiso_id)
    {
        $result = $this->repository->revoke($role_id, $permiso_id);

        if ($result) {
            echo json_encode([
                "message" => "Permiso revocado del rol correctamente"
            ]);
        } else {
            http_response_code(400);
            echo json_encode([
                "message" => "Error al revocar el permiso"
            ]);
        }
    }
}
