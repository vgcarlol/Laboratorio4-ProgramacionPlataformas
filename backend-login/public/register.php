<?php
require_once('../config/connection.php');

// Obtener datos POST
$json = file_get_contents('php://input');
$data = json_decode($json, true);

$usuario = $data['username'];
$contrasena = $data['password'];

// Chequear si el usuario ya existe
$sql_check = "SELECT id FROM user WHERE username = '$usuario'";
$resultado_check = $conexion->query($sql_check);

if ($resultado_check->num_rows > 0) {
    echo "error_user_exists";
    exit;
}

// Si no existe, agregarlo
$sql = "INSERT INTO user (username, password) VALUES ('$usuario', MD5('$contrasena'))";
if ($conexion->query($sql) === TRUE) {
    echo "success";
} else {
    echo "error_registration_failed";
}
?>
