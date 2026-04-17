<?php

require_once "../vendor/autoload.php";
require_once "../config/database.php";
require_once "../config/jwt.php";
require_once "../app/Models/Tournament.php";
require_once "../app/Repositorio/TournamentRepository.php";
require_once "../app/Controllers/TournamentController.php";
/////
require_once "../app/Models/Game.php";
require_once "../app/Repositorio/GameRepository.php";
require_once "../app/Controllers/GameController.php";
/////
require_once "../app/Models/Role.php";
require_once "../app/Repositorio/RoleRepository.php";
require_once "../app/Controllers/RoleController.php";
/////
require_once "../app/Models/Permission.php";
require_once "../app/Repositorio/PermissionRepository.php";
require_once "../app/Controllers/PermissionController.php";
/////
require_once "../app/Models/RolePermission.php";
require_once "../app/Repositorio/RolePermissionRepository.php";
require_once "../app/Controllers/RolePermissionController.php";

/////
require_once "../app/Models/User.php";
require_once "../app/Repositorio/UserRepository.php";
require_once "../app/Controllers/UserController.php";
///

require_once "../app/Models/TournamentPlayer.php";
require_once "../app/Repositorio/TournamentPlayerRepository.php";
require_once "../app/Controllers/TournamentPlayerController.php";

/////
require_once "../app/Services/JwtService.php";
require_once "../app/Middleware/AuthMiddleware.php";
require_once "../app/Controllers/AuthController.php";


use App\Controllers\GameController;
use App\Controllers\RoleController;
use App\Controllers\TournamentController;
use App\Controllers\PermissionController;
use App\Controllers\RolePermissionController;
use App\Controllers\TournamentPlayerController;
use App\Controllers\UserController;
use App\Controllers\AuthController;
use App\Services\JwtService;
use App\Middleware\AuthMiddleware;

$url = $_SERVER['REQUEST_URI'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents("php://input"), true);


// ==================== AUTENTICACIÓN ====================
$authController = new AuthController();

if ($url === "/auth/register" && $method === "POST") {
    $authController->register($data);
    exit;
}

if ($url === "/auth/login" && $method === "POST") {
    $authController->login($data);
    exit;
}

if ($url === "/auth/me" && $method === "GET") {
    $authController->me();
    exit;
}

// ========================================================

AuthMiddleware::authenticate();
$tournament = new TournamentController();
if ($url === "/tournaments" && $method === "GET") {
    $tournament->index();
}

if ($url === "/tournaments/find" && $method === "GET") {
    $tournament->show($data['id']);
}

if ($url === "/tournaments/store" && $method === "POST") {
    $tournament->store($data);
}

if ($url === "/tournaments/update" && $method === "PUT") {
    $tournament->update($data, $data['id']);
}

if ($url === "/tournaments/delete" && $method === "DELETE") {
    $tournament->delete($data['id']);
}
//////////////////////////////////////////////////////////////////



$gameController = new GameController();

if ($url === "/games" && $method === "GET") {
    $gameController->index();
}

if ($url === "/games/find" && $method === "GET") {
    $gameController->findById($data['id']);
}

if ($url === "/games/store" && $method === "POST") {
    $gameController->store($data);
}

if ($url === "/games/update" && $method === "PUT") {
    $gameController->update($data);
}
if ($url === "/games/delete" && $method === "DELETE") {
    $gameController->delete($data);
}

//////////////////////////////////////////////////////////////////

$roleController = new RoleController();

if ($url === "/roles" && $method === "GET") {
    $roleController->index();
}

if ($url === "/roles/find" && $method === "GET") {
    $roleController->findById($data['id']);
}

if ($url === "/roles/store" && $method === "POST") {
    $roleController->store($data);
}

if ($url === "/roles/update" && $method === "PUT") {

    $roleController->update($data);
}
if ($url === "/roles/delete" && $method === "DELETE") {
    $roleController->delete($data['id']);
}

//////////////////////////////////////////////////////////////////
$permissionController = new PermissionController();

if ($url === "/permisos" && $method === "GET") {
    $permissionController->index();
}

if ($url === "/permisos/find" && $method === "GET") {
    $permissionController->findById($data['id']);
}

if ($url === "/permisos/store" && $method === "POST") {
    $permissionController->store($data);
}

if ($url === "/permisos/update" && $method === "PUT") {
    $permissionController->update($data);
}

if ($url === "/permisos/delete" && $method === "DELETE") {
    $permissionController->delete($data['id']);
}
//////////////////////////////////////////////////////////////////

$rolePermissionController = new RolePermissionController();

if ($url === "/role/permisos" && $method === "GET") {
    $rolePermissionController->index();
}

if ($url === "/role/permisos/by/role" && $method === "GET") {
    $rolePermissionController->getPermissionsByRole($data['role_id']);
}

if ($url === "/role/by/permission" && $method === "GET") {
    $rolePermissionController->getRolesByPermission($data['permiso_id']);
}

if ($url === "/role/permisos/assign" && $method === "POST") {
    $rolePermissionController->assign($data);
}

if ($url === "/role/permisos/revoke" && $method === "DELETE") {
    $rolePermissionController->revoke($data['role_id'], $data['permission_id']);
}
///
$userController = new UserController();

if ($url === "/users" && $method === "GET") {
    $userController->index();
}

if ($url === "/users/find" && $method === "GET") {
    $userController->findById($data['id']);
}

if ($url === "/users/store" && $method === "POST") {
    $userController->store($data);
}

if ($url === "/users/update" && $method === "PUT") {
    $userController->update($data);
}
if ($url === "/users/delete" && $method === "DELETE") {
    $userController->delete($data['id']);
}
/////////////////////////////////////////
$tournamentPlayerController = new TournamentPlayerController();

if ($url === "/tournament/players" && $method === "GET") {
    $tournamentPlayerController->index();
}

if ($url === "/tournament/players/find" && $method === "GET") {
    $tournamentPlayerController->findById($data['id']);
}

if ($url === "/tournament/players/store" && $method === "POST") {
    $tournamentPlayerController->store($data);
}

if ($url === "/tournament/players/update" && $method === "PUT") {
    $tournamentPlayerController->update($data);
}
if ($url === "/tournament/players/delete" && $method === "DELETE") {
    $tournamentPlayerController->delete($data['id']);
}
