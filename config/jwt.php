<?php
namespace Config;

class JwtConfig {

    public static function getKey(){
        return "your_secret_key_change_this_in_production"; // Cambiar en producción
    }

    public static function getAlgorithm(){
        return "HS256";
    }

    public static function getExpiration(){
        return 3600; // 1 hora en segundos
    }

    public static function getRefreshExpiration(){
        return 604800; // 7 días en segundos
    }
}
