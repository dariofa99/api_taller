<?php
namespace App\Repositorio;

use App\Models\RolePermission;
use Config\Database;
use Exception;
use PDO;

class RolePermissionRepository {

    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getAll(){
        $sql = "SELECT * FROM role_permissions";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPermissionsByRole($role_id){
        $sql = "SELECT p.* FROM permissions p
                INNER JOIN role_permissions rp ON p.id = rp.permission_id
                WHERE rp.role_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$role_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRolesByPermission($permiso_id){
        $sql = "SELECT r.* FROM roles r
                INNER JOIN role_permissions rp ON r.id = rp.role_id
                WHERE rp.permission_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$permiso_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function assign(RolePermission $rolePermission){
        try {
            $sql = "INSERT INTO role_permissions (role_id, permission_id)
                   VALUES (?, ?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $rolePermission->getRoleId(),
                $rolePermission->getPermissionId()
            ]);
        } catch (\Throwable $th) {
            throw new Exception("Error al asignar permiso al rol: " . $th->getMessage());
        }
    }

    public function revoke($role_id, $permiso_id){
        $sql = "DELETE FROM role_permissions 
                WHERE role_id = ? AND permission_id = ?";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$role_id, $permiso_id]);
    }

    public function revokeAllByRole($role_id){
        $sql = "DELETE FROM role_permissions WHERE role_id = ?";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$role_id]);
    }

    public function revokeAllByPermission($permiso_id){
        $sql = "DELETE FROM role_permissions WHERE permission_id = ?";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$permiso_id]);
    }
}
