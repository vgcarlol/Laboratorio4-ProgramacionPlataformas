<?php

require_once 'auth.php';

// Registro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    register($_POST['username'], $_POST['password']);
}

// Inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $token = login($_POST['username'], $_POST['password']);
    if ($token) {
        echo "Token: " . $token;
    } else {
        echo "Credenciales incorrectas";
    }
}
?>