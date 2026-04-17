# ESTRUCTURA DE AUTENTICACIÓN

Se ha creado una estructura de autenticación completa usando JWT (JSON Web Tokens) con Firebase PHP-JWT.

## Archivos creados:

### 1. **Configuración JWT**
- Archivo: `config/jwt.php`
- Define la clave secreta, algoritmo y tiempos de expiración

### 2. **Servicio JWT**
- Archivo: `app/Services/JwtService.php`
- Métodos:
  - `generateToken()` - Genera token de acceso (1 hora)
  - `generateRefreshToken()` - Genera token de refresco (7 días)
  - `validateToken()` - Valida un token
  - `getTokenFromHeader()` - Extrae el token del header Authorization

### 3. **Middleware de Autenticación**
- Archivo: `app/Middleware/AuthMiddleware.php`
- Métodos:
  - `authenticate()` - Valida que el usuario esté autenticado
  - `checkRole()` - Valida que el usuario tenga el rol requerido

### 4. **Controlador de Autenticación**
- Archivo: `app/Controllers/AuthController.php`
- Métodos:
  - `register()` - Registra un nuevo usuario
  - `login()` - Autentica un usuario y devuelve tokens
  - `refreshToken()` - Genera un nuevo token usando el refresh token
  - `me()` - Devuelve la información del usuario autenticado

### 5. **Actualizaciones**
- Actualizado: `app/Repositorio/UserRepository.php`
  - Nuevo método: `findByEmail()` - Busca usuario por email

## Rutas de Autenticación:

### Registro
```
POST /auth/register
Body:
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123"
}
```

### Login
```
POST /auth/login
Body:
{
  "email": "john@example.com",
  "password": "password123"
}
Response:
{
  "message": "Login exitoso",
  "token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "refreshToken": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "role_id": 2
  }
}
```

### Refrescar Token
```
POST /auth/refresh
Body:
{
  "refreshToken": "eyJ0eXAiOiJKV1QiLCJhbGc..."
}
Response:
{
  "token": "eyJ0eXAiOiJKV1QiLCJhbGc..."
}
```

### Obtener Usuario Actual
```
GET /auth/me
Headers:
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGc...
```

## Cómo usar en otros controladores:

### Proteger una ruta con autenticación:
```php
// En el controlador
use App\Middleware\AuthMiddleware;

public function protectedMethod()
{
    $user = AuthMiddleware::authenticate();
    // Usar $user->userId, $user->email, etc.
}
```

### Proteger una ruta con roles:
```php
public function adminOnlyMethod()
{
    $user = AuthMiddleware::checkRole(1); // 1 = admin
}
```

## Configuración:

⚠️ **IMPORTANTE**: En producción, cambiar la clave secreta en `config/jwt.php`:
```php
public static function getKey(){
    return "your_secret_key_change_this_in_production"; 
}
```

Generar una clave segura con:
```bash
php -r "echo base64_encode(random_bytes(32));"
```

## Próximos pasos:
- Implementar validación de email
- Agregar CORS headers si es necesario
- Agregar rate limiting
- Implementar logout/token blacklist (opcional)
