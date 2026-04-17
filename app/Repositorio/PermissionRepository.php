<?php
namespace App\Repositorio;

use App\Models\Permission;
use Config\Database;
use Exception;
use PDO;

class PermissionRepository {

    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getAll(){
        $sql = "SELECT * FROM permissions";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id){
        $sql = "SELECT * FROM permissions WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(Permission $permission){
        try {
            $sql = "INSERT INTO permissions (name)
                   VALUES (?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $permission->getName()
            ]);
        } catch (\Throwable $th) {
            throw new Exception("Error al crear permiso: " . $th->getMessage());
        }
    }

    public function update($id, Permission $permission){
        $sql = "UPDATE permissions
                SET name = ?
                WHERE id = ?";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $permission->getName(),
            $id
        ]);
    }

    public function delete($id){
        $sql = "DELETE FROM permissions WHERE id = ?";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$id]);
    }
}
