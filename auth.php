<?php
require_once 'config.php';
require_once 'database.php';
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;

// Registro de usuario
function register($username, $password) {
    $db = getDB();
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $db->prepare("INSERT INTO usuarios(username, password_hash) VALUES(:username, :passwordHash)");
    $stmt->bindParam("username", $username);
    $stmt->bindParam("passwordHash", $passwordHash);
    $stmt->execute();
}

// Inicio de sesión
function login($username, $password) {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM usuarios WHERE username=:username");
    $stmt->bindParam("username", $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {
        $jwt = JWT::encode([
            'id' => $user['id'],
            'username' => $user['username'],
            'exp' => time() + (60 * 60) // Token válido por 1 hora
        ], JWT_SECRET);

        $stmt = $db->prepare("UPDATE usuarios SET jwt_token=:jwt, token_expiry=FROM_UNIXTIME(:expiry) WHERE id=:id");
        $stmt->bindParam("jwt", $jwt);
        $stmt->bindParam("expiry", time() + (60 * 60));
        $stmt->bindParam("id", $user['id']);
        $stmt->execute();

        return $jwt;
    }

    return null;
}
?>
