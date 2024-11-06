<?php
session_start();
include("admin/funciones.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Las contraseñas no coinciden.";
    } else {
        $result = registrarUsuario($nombre, $email, $password);
        if ($result === true) {
            $_SESSION['usuario'] = $nombre;
            header("Location: index.php");
            exit();
        } else {
            $error = $result;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Registro - QUIZ GAME</title>
</head>
<body>
    <div class="container">
    <a href="index.php" class="back-button">Atrás</a>
        <div class="login-form">
            <h2>Registro</h2>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <input type="text" name="nombre" placeholder="Nombre" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <input type="password" name="confirm_password" placeholder="Confirmar contraseña" required>
                <input type="submit" value="Registrarse">
            </form>
            <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a></p>
        </div>
    </div>
</body>
</html>