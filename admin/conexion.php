<?php
//datos del servidor
$server   = "localhost";
$username = "root";
$password = "";
$bd       = "bd_quiz";

// Crear conexión
$conn = new mysqli($server, $username, $password, $bd);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Hacer la conexión global
$GLOBALS['conn'] = $conn;
?>

