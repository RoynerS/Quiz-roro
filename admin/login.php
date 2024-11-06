<?php
session_start();
include ("funciones.php");

//obtengo la configuración
//para comprobar el usuario y la contraseña
$config = obtenerConfiguracion();

//pregunto si se presionó el boton ingresar (login)
if (isset($_POST['login'])) {
    //tomo los datos que vienen del cliente
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    //Verifico a todos los usuarios en la base de datos
    $query = "SELECT * FROM config WHERE usuario='$usuario' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        //Si el usuario existe, inicio sesión
        $_SESSION['usuarioLogeado'] = $usuario;
        $_SESSION['passwordlogeado'] = $password;
        header("Location: index.php");
    } else {
        $mensaje = "* El nombre de usuario o la contraseña son incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="estilo.css">
    <title>Quiz Game</title>
</head>
<body>
    <div class="contenedor-login">
    <a href="../index.php" class="back-button">Atrás</a>
        <h1>QUIZ GAME</h1>
        <div class="contenedor-form">
            <h3>Administrador</h3>
            <hr>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <div class="fila">
                    <label for="">Usuario</label>
                    <div class="entrada">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="usuario">
                    </div>
                   
                </div>
                <div class="fila">
                    <label for="">Contraseña</label>
                    <div class="entrada">
                        <i class="fa-solid fa-key"></i>
                        <input type="password" name="password">
                    </div>
                </div>
                <hr>
                <input type="submit" name="login" value="Ingresar" class="btn">
            </form>
           

            

            <!-- Mensaje que se mostrará cuando se haya procesado la solicitud en el servidor -->
            <?php if (isset($_POST['login'])) : ?>
                <span class="msj-error-input"> <?php echo $mensaje ?></span>
            <?php endif ?>
        </div>

    </div>
</body>
</html>