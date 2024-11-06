<?php
session_start();
include("admin/funciones.php");

aumentarVisita();

// Obtener categorías
$categorias = obtenerCategoriasjuego();

if(isset($_GET['idCategoria'])){
    if (!isset($_SESSION['usuario'])) {
        $_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
        header("Location: login.php");
        exit();
    }
    $_SESSION['idCategoria'] = $_GET['idCategoria'];
    header("Location: jugar.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="estilo.css">
    <title>QUIZ GAME</title>
</head>
<body>
    <div class="container" id="cantainer">
        <div class="left">
            
            <div class="logo">QUIZ GAME</div>
            
            <h2><?php if (!isset($_SESSION['usuario'])): ?>
               
            <?php else: ?>
                <div class="welcome-message">
                    Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!
                   
                </div>
            <?php endif; ?>PON A PRUEBA TUS CONOCIMIENTOS!!</h2>
            <?php if (!isset($_SESSION['usuario'])): ?>
                <div class="auth-links">
                    <a href="login.php" class="btn">Iniciar sesión</a>
                    <a href="registro.php" class="btn">Registrarse</a>

                </div>
            <?php else: ?>
                <a href="logout.php" class="btn">Cerrar sesión</a>
            <?php endif; ?>
            
        </div>
        <div class="right">
            <h3>Elige un tema</h3>
            <div class="categorias">
                <?php if ($categorias): ?>
                    <?php while ($cat = mysqli_fetch_assoc($categorias)): ?>
                    <div class="categoria">
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" id="<?php echo $cat['tema']; ?>">
                            <input type="hidden" name="idCategoria" value="<?php echo $cat['tema']; ?>">
                            <a href="javascript:{}" onclick="document.getElementById('<?php echo $cat['tema']; ?>').submit(); return false;">
                                <?php echo obtenerNombreTema($cat['tema']); ?>
                            </a>
                        </form>
                    </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No hay categorías disponibles.</p>
                <?php endif; ?>
            </div>
        </div>
        <footer>

        <?php if (!isset($_SESSION['usuario'])): ?>
                <div class="auth-links">
                <a href="admin/login.php" class="btn" id="btn1">Admin/Profesor</a>
                <a href="site/index.html" class="btn" id="btn1">Inicio</a>
                </div>
            <?php else: ?>
                
            <?php endif; ?>
        
        </footer>
    </div>
</body>
</html>
