# Documentación de la API - TallerAPI

## 📋 Descripción General

TallerAPI es una API REST desarrollada en PHP que proporciona un sistema completo de gestión de torneos, juegos, usuarios y roles con autenticación JWT.

## 🚀 Requisitos

- PHP 7.4 o superior
- Composer
- SQLite / MySQL
- Firebase PHP-JWT

## 📦 Instalación

1. **Clonar el repositorio**
```bash
git clone <repository-url>
cd tallerapi
```

2. **Instalar dependencias**
```bash
composer install
```

3. **Configurar base de datos**
Editar `config/database.php` con tus credenciales

4. **Configurar JWT**
Editar `config/jwt.php` con tu clave secreta

5. **Ejecutar el servidor**
```bash
php -S localhost:8000 -t public
```

---

## 🔐 Autenticación

La API utiliza **JWT (JSON Web Tokens)** para proteger los endpoints. Los tokens tienen las siguientes características:

- **Token de acceso**: Válido por 1 hora
- **Refresh token**: Válido por 7 días
- **Header requerido**: `Authorization: Bearer <token>`

### Estructura de Autenticación
- **Servicio**: `app/Services/JwtService.php`
- **Middleware**: `app/Middleware/AuthMiddleware.php`
- **Controlador**: `app/Controllers/AuthController.php`

---

## 🔑 Endpoints de Autenticación

### 1. Registro de Usuario
```http
POST /auth/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123"
}
```

**Respuesta (201)**
```json
{
  "message": "Usuario registrado correctamente",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  }
}
```

---

### 2. Login
```http
POST /auth/login
Content-Type: application/json

{
  "email": "john@example.com",
  "password": "password123"
}
```

**Respuesta (200)**
```json
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

---

### 3. Obtener Usuario Actual
```http
GET /auth/me
Authorization: Bearer <token>
```

**Respuesta (200)**
```json
{
  "id": 1,
  "name": "John Doe",
  "email": "john@example.com",
  "role_id": 2
}
```

---

## 🎮 Endpoints de Juegos

### Listar todos los juegos
```http
GET /games
Authorization: Bearer <token>
```

**Respuesta (200)**
```json
[
  {
    "id": 1,
    "name": "The Legend of Zelda",
    "genre": "Adventure",
    "platform": "Nintendo Switch"
  }
]
```

---

### Obtener juego por ID
```http
GET /games/find
Authorization: Bearer <token>
Content-Type: application/json

{
  "id": 1
}
```

---

### Crear nuevo juego
```http
POST /games/store
Authorization: Bearer <token>
Content-Type: application/json

{
  "name": "Elden Ring",
  "genre": "RPG",
  "platform": "PlayStation 5"
}
```

**Respuesta (201)**
```json
{
  "message": "Juego creado correctamente"
}
```

---

### Actualizar juego
```http
PUT /games/update
Authorization: Bearer <token>
Content-Type: application/json

{
  "id": 1,
  "name": "Elden Ring",
  "genre": "Action RPG",
  "platform": "PlayStation 5"
}
```

---

### Eliminar juego
```http
DELETE /games/delete
Authorization: Bearer <token>
Content-Type: application/json

{
  "id": 1
}
```

---

## 🏆 Endpoints de Torneos

### Listar todos los torneos
```http
GET /tournaments
Authorization: Bearer <token>
```

**Respuesta (200)**
```json
[
  {
    "id": 1,
    "name": "Torneo Nacional 2026",
    "start_date": "2026-04-20",
    "end_date": "2026-04-25"
  }
]
```

---

### Obtener torneo por ID
```http
GET /tournaments/find
Authorization: Bearer <token>
Content-Type: application/json

{
  "id": 1
}
```

---

### Crear nuevo torneo
```http
POST /tournaments/store
Authorization: Bearer <token>
Content-Type: application/json

{
  "name": "Torneo Nacional 2026",
  "start_date": "2026-04-20",
  "end_date": "2026-04-25"
}
```

---

### Actualizar torneo
```http
PUT /tournaments/update
Authorization: Bearer <token>
Content-Type: application/json

{
  "id": 1,
  "name": "Torneo Nacional 2026 - Actualizado",
  "start_date": "2026-04-20",
  "end_date": "2026-04-25"
}
```

---

### Eliminar torneo
```http
DELETE /tournaments/delete
Authorization: Bearer <token>
Content-Type: application/json

{
  "id": 1
}
```

---

## 👥 Endpoints de Usuarios

### Listar todos los usuarios
```http
GET /users
Authorization: Bearer <token>
```

**Respuesta (200)**
```json
[
  {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "role_id": 2
  }
]
```

---

### Obtener usuario por ID
```http
GET /users/find
Authorization: Bearer <token>
Content-Type: application/json

{
  "id": 1
}
```

---

### Crear nuevo usuario
```http
POST /users/store
Authorization: Bearer <token>
Content-Type: application/json

{
  "name": "Jane Doe",
  "email": "jane@example.com",
  "role_id": 2,
  "password": "password123"
}
```

---

### Actualizar usuario
```http
PUT /users/update
Authorization: Bearer <token>
Content-Type: application/json

{
  "id": 1,
  "name": "Jane Doe Updated",
  "email": "jane@example.com",
  "role_id": 2,
  "password": "newpassword123"
}
```

---

### Eliminar usuario
```http
DELETE /users/delete
Authorization: Bearer <token>
Content-Type: application/json

{
  "id": 1
}
```

---

## 🔖 Endpoints de Roles

### Listar todos los roles
```http
GET /roles
Authorization: Bearer <token>
```

**Respuesta (200)**
```json
[
  {
    "id": 1,
    "name": "Admin"
  },
  {
    "id": 2,
    "name": "User"
  }
]
```

---

### Obtener rol por ID
```http
GET /roles/find
Authorization: Bearer <token>
Content-Type: application/json

{
  "id": 1
}
```

---

### Crear nuevo rol
```http
POST /roles/store
Authorization: Bearer <token>
Content-Type: application/json

{
  "name": "Moderator"
}
```

---

### Actualizar rol
```http
PUT /roles/update
Authorization: Bearer <token>
Content-Type: application/json

{
  "id": 1,
  "name": "Super Admin"
}
```

---

### Eliminar rol
```http
DELETE /roles/delete
Authorization: Bearer <token>
Content-Type: application/json

{
  "id": 1
}
```

---

## 📋 Endpoints de Permisos

### Listar todos los permisos
```http
GET /permisos
Authorization: Bearer <token>
```

**Respuesta (200)**
```json
[
  {
    "id": 1,
    "name": "crear_usuario"
  },
  {
    "id": 2,
    "name": "editar_usuario"
  }
]
```

---

### Obtener permiso por ID
```http
GET /permisos/find
Authorization: Bearer <token>
Content-Type: application/json

{
  "id": 1
}
```

---

### Crear nuevo permiso
```http
POST /permisos/store
Authorization: Bearer <token>
Content-Type: application/json

{
  "name": "eliminar_usuario"
}
```

---

### Actualizar permiso
```http
PUT /permisos/update
Authorization: Bearer <token>
Content-Type: application/json

{
  "id": 1,
  "name": "crear_usuario_premium"
}
```

---

### Eliminar permiso
```http
DELETE /permisos/delete
Authorization: Bearer <token>
Content-Type: application/json

{
  "id": 1
}
```

---

## 🔐 Endpoints de Rol-Permiso

### Listar todas las asignaciones rol-permiso
```http
GET /role/permisos
Authorization: Bearer <token>
```

---

### Obtener permisos de un rol
```http
GET /role/permisos/by/role
Authorization: Bearer <token>
Content-Type: application/json

{
  "role_id": 1
}
```

---

### Obtener roles con un permiso
```http
GET /role/by/permission
Authorization: Bearer <token>
Content-Type: application/json

{
  "permiso_id": 1
}
```

---

### Asignar permiso a rol
```http
POST /role/permisos/assign
Authorization: Bearer <token>
Content-Type: application/json

{
  "role_id": 1,
  "permission_id": 2
}
```

---

### Revocar permiso de rol
```http
DELETE /role/permisos/revoke
Authorization: Bearer <token>
Content-Type: application/json

{
  "role_id": 1,
  "permission_id": 2
}
```

---

## 🎮 Endpoints de Jugadores de Torneo

### Listar todos los jugadores de torneos
```http
GET /tournament/players
Authorization: Bearer <token>
```

---

### Obtener jugador de torneo por ID
```http
GET /tournament/players/find
Authorization: Bearer <token>
Content-Type: application/json

{
  "id": 1
}
```

---

### Agregar jugador a torneo
```http
POST /tournament/players/store
Authorization: Bearer <token>
Content-Type: application/json

{
  "tournament_id": 1,
  "user_id": 1,
  "status": "active"
}
```

---

### Actualizar jugador de torneo
```http
PUT /tournament/players/update
Authorization: Bearer <token>
Content-Type: application/json

{
  "id": 1,
  "status": "completed"
}
```

---

### Eliminar jugador de torneo
```http
DELETE /tournament/players/delete
Authorization: Bearer <token>
Content-Type: application/json

{
  "id": 1
}
```

---

## ⚠️ Códigos de Respuesta HTTP

| Código | Descripción |
|--------|-------------|
| 200 | Solicitud exitosa |
| 201 | Recurso creado exitosamente |
| 400 | Solicitud inválida (datos faltantes o incorrectos) |
| 401 | No autorizado (token inválido o expirado) |
| 404 | Recurso no encontrado |
| 500 | Error del servidor |

---

## 📝 Notas Importantes

1. **Autenticación requerida**: Todos los endpoints excepto `/auth/register` y `/auth/login` requieren un token JWT válido
2. **Headers obligatorios**: Las solicitudes deben incluir `Content-Type: application/json`
3. **Token expirado**: Si recibe un error 401, genere un nuevo token usando `/auth/login`
4. **Validación**: Todos los campos son validados en el servidor

---

## 📚 Estructura del Proyecto

```
app/
├── Controllers/        # Controladores de la API
├── Middleware/         # Middleware (autenticación)
├── Models/            # Modelos de datos
├── Repositorio/       # Acceso a datos
└── Services/          # Servicios (JWT)
config/               # Configuración
public/              # Punto de entrada (index.php)
vendor/              # Dependencias
```

---

## 🤝 Contribuir

Para reportar bugs o sugerir mejoras, por favor abre un issue o envía un pull request.

---

## 📄 Licencia

Este proyecto está bajo licencia MIT.
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
