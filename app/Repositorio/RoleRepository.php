<?php
namespace App\Repositorio;

use App\Models\Role;
use Config\Database;
use Exception;
use PDO;

class RoleRepository {

    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getAll(){
        $sql = "SELECT * FROM roles";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id){
        $sql = "SELECT * FROM roles WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(Role $role){
        try {
            $sql = "INSERT INTO roles (name)
                   VALUES (?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $role->getName()
            ]);
        } catch (\Throwable $th) {
            throw new Exception("Error al crear rol: " . $th->getMessage());
        }
    }

    public function update($id, Role $role){
        $sql = "UPDATE roles
                SET name = ?
                WHERE id = ?";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $role->getName(),
            $id
        ]);
    }

    public function delete($id){
        $sql = "DELETE FROM roles WHERE id = ?";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$id]);
    }
}
