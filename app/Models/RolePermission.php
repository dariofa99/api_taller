<?php
namespace App\Models;

class RolePermission {

    private $role_id;
    private $permission_id;

    public function __construct($data = [])
    {
        $this->role_id = $data['role_id'] ?? null;
        $this->permission_id = $data['permission_id'] ?? null;
    }

    public function getRoleId(){
        return $this->role_id;
    }

    public function getPermissionId(){
        return $this->permission_id;
    }
}
