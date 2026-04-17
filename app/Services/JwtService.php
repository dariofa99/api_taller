<?php
namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Config\JwtConfig;
use Exception;

class JwtService {

    public static function generateToken($userId, $email, $role_id){

        $key = JwtConfig::getKey();
        $algorithm = JwtConfig::getAlgorithm();
        $expiration = JwtConfig::getExpiration();

        $payload = [
            'iat' => time(),
            'exp' => time() + $expiration,
            'userId' => $userId,
            'email' => $email,
            'role_id' => $role_id
        ];

        return JWT::encode($payload, $key, $algorithm);
    }

    public static function generateRefreshToken($userId){

        $key = JwtConfig::getKey();
        $algorithm = JwtConfig::getAlgorithm();
        $expiration = JwtConfig::getRefreshExpiration();

        $payload = [
            'iat' => time(),
            'exp' => time() + $expiration,
            'userId' => $userId,
            'type' => 'refresh'
        ];

        return JWT::encode($payload, $key, $algorithm);
    }

    public static function validateToken($token){

        try {
            $key = JwtConfig::getKey();
            $algorithm = JwtConfig::getAlgorithm();

            $decoded = JWT::decode($token, new Key($key, $algorithm));
            return $decoded;
        } catch (\Exception $e) {
            throw new Exception("Token inválido: " . $e->getMessage());
        }
    }

    public static function getTokenFromHeader(){

        $headers = apache_request_headers();
        
        if (isset($headers['Authorization'])) {
            $authHeader = $headers['Authorization'];
            if (preg_match('/Bearer\s+(.*)$/i', $authHeader, $matches)) {
                return $matches[1];
            }
        }

        throw new Exception("Token no encontrado en el header");
    }
}
