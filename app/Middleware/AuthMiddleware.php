<?php
namespace App\Middleware;

use App\Services\JwtService;
use Exception;

class AuthMiddleware {

    public static function authenticate(){

        try {
            $token = JwtService::getTokenFromHeader();
            $decoded = JwtService::validateToken($token);
            return $decoded;
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode([
                "message" => "No autorizado: " . $e->getMessage()
            ]);
            exit;
        }
    }

    public static function checkRole($requiredRole){

        $user = self::authenticate();

        if ($user->role_id !== $requiredRole) {
            http_response_code(403);
            echo json_encode([
                "message" => "Acceso denegado: rol insuficiente"
            ]);
            exit;
        }

        return $user;
    }
}
