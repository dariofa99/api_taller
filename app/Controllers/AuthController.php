<?php
namespace App\Controllers;

use App\Models\User;
use App\Repositorio\RolePermissionRepository;
use App\Repositorio\UserRepository;
use App\Services\JwtService;
use Exception;

class AuthController
{

    private $userRepository;
    private $rolePermissionRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->rolePermissionRepository = new RolePermissionRepository();
    }

    public function register($data)
    {
        try {
            if (
                empty($data['name']) ||
                empty($data['email']) ||
                empty($data['password'])
            ) {
                http_response_code(400);
                echo json_encode([
                    "message" => "Nombre, email y contraseña son obligatorios"
                ]);
                return;
            }

            // Validar que el email no exista
            $existingUser = $this->userRepository->findByEmail($data['email']);
            if ($existingUser) {
                http_response_code(409);
                echo json_encode([
                    "message" => "El email ya está registrado"
                ]);
                return;
            }

            // Crear usuario con rol por defecto (asumiendo que 2 es usuario regular)
            $data['role_id'] = $data['role_id'] ?? 1;

            $user = new User($data);
            $result = $this->userRepository->create($user);
    
            if ($result) {
                http_response_code(201);
                echo json_encode([
                    "message" => "Usuario registrado exitosamente"
                ]);
            }
        } catch (Exception $th) {
            http_response_code(500);
            echo json_encode([
                "message" => "Error al registrar usuario: " . $th->getMessage()
            ]);
        }
    }

    public function login($data)
    {
        try {
            if (empty($data['email']) || empty($data['password'])) {
                http_response_code(400);
                echo json_encode([
                    "message" => "Email y contraseña son requeridos"
                ]);
                return;
            }

            $user = $this->userRepository->findByEmail($data['email']);

            if (!$user) {
                http_response_code(401);
                echo json_encode([
                    "message" => "Credenciales inválidas"
                ]);
                return;
            }

            // Verificar contraseña
            if (!password_verify($data['password'], $user['password'])) {
                http_response_code(401);
                echo json_encode([
                    "message" => "Credenciales inválidas"
                ]);
                return;
            }

            // Generar tokens
            $token = JwtService::generateToken($user['id'], $user['email'], $user['role_id']);           

            http_response_code(200);
            echo json_encode([
                "message" => "Login exitoso",
                "token" => $token,                
                "user" => [
                    "id" => $user['id'],
                    "name" => $user['name'],
                    "email" => $user['email'],
                    "role_id" => $user['role_id'],
                    "permissions" => $this->rolePermissionRepository->getPermissionsByRole($user['role_id']) ?? []
                ]
            ]);
        } catch (Exception $th) {
            http_response_code(500);
            echo json_encode([
                "message" => "Error al iniciar sesión: " . $th->getMessage()
            ]);
        }
    }

    public function refreshToken($data)
    {
        try {
            if (empty($data['refreshToken'])) {
                http_response_code(400);
                echo json_encode([
                    "message" => "refreshToken es requerido"
                ]);
                return;
            }

            $decoded = JwtService::validateToken($data['refreshToken']);

            if ($decoded->type !== 'refresh') {
                http_response_code(401);
                echo json_encode([
                    "message" => "Refresh token inválido"
                ]);
                return;
            }

            $user = $this->userRepository->findById($decoded->userId);

            if (!$user) {
                http_response_code(404);
                echo json_encode([
                    "message" => "Usuario no encontrado"
                ]);
                return;
            }

            $newToken = JwtService::generateToken($user['id'], $user['email'], $user['role_id']);

            echo json_encode([
                "token" => $newToken
            ]);
        } catch (Exception $th) {
            http_response_code(401);
            echo json_encode([
                "message" => "Error al renovar token: " . $th->getMessage()
            ]);
        }
    }

    public function me()
    {
        try {
            $token = JwtService::getTokenFromHeader();
            $user = JwtService::validateToken($token);

            echo json_encode([
                "user" => $user
            ]);
        } catch (Exception $th) {
            http_response_code(401);
            echo json_encode([
                "message" => "No autorizado: " . $th->getMessage()
            ]);
        }
    }
}
