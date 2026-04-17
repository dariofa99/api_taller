<?php
 namespace App\Repositorio;


use App\Models\User;
use Config\Database;
use Exception;
use PDO;

class UserRepository {

    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getAll(){

        $sql = "SELECT * FROM users";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id){
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByEmail($email){
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(User $user){

    try {
         $sql = "INSERT INTO users (name, email, password, role_id)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $user->getName(),
            $user->getEmail(),
            password_hash($user->getPassword(), PASSWORD_BCRYPT),
            $user->getRole()
        ]);
    } catch (\Throwable $th) {
        throw new Exception("Error al crear usuario: " . $th->getMessage());
    }
       
    }

    public function update($id, User $user){

        $sql = "UPDATE users
                SET name = ?, email = ?, password = ?, role_id = ?
                WHERE id = ?";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $user->getName(),
            $user->getEmail(),
            password_hash($user->getPassword(), PASSWORD_BCRYPT),
            $user->getRole(),
            $id
        ]);
    }

    public function delete($id){

        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([$id]);
    }
}