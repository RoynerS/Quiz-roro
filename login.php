<?php
session_start();
include("admin/funciones.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = verificarCredenciales($email, $password);
    if ($result) {
        $_SESSION['usuario'] = $result['nombre'];
        if (isset($_SESSION['redirect'])) {
            $redirect = $_SESSION['redirect'];
            unset($_SESSION['redirect']);
            header("Location: $redirect");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        $error = "Email o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <link href="https://fonts.googleapis.com/css2?family=Alata&display=swap" rel="stylesheet">
    <title>Iniciar sesión - QUIZ GAME</title>
    
</head>
<body>

    <div class="container">
    <a href="index.php" class="back-button">Atrás</a>
        <div class="login-form">
            <h2>Iniciar sesión</h2>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <input type="submit" value="Iniciar sesión">
            </form>
            <!-- <a href="admin/login.php">Incia como profesor</a> -->
            <p>¿No tienes una cuenta? <a href="registro.php">Regístrate</a></p>
        </div>
    </div>
</body>
</html>