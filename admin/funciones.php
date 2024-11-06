<?php
include("conexion.php");

//Función para obtener el registro de la configuración del sitio
function obtenerConfiguracion()
{
    include("conexion.php");
    //Comprobamos si existe el registro 1 que mantiene la configuraciòn
    //Añadimos un alias AS total para identificar mas facil
    $query = "SELECT COUNT(*) AS total FROM config";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);


    if ($row['total'] == '0') {
        //No existe el registro 1 - DEBO INSERTAR el registro por primera vez
        $query = "INSERT INTO config (id,usuario,password,totalPreguntas)
        VALUES (NULL, 'admin', 'admin','3')";

        if (mysqli_query($conn, $query)) { //Se insertó correctamente

        } else {
            echo "No se pudo insertar en la BD" .mysqli_errno($conn);
        }
    }

    //Selecciono el registro dela configuración
    $query = "SELECT * FROM config  WHERE id='1'";
    $result = mysqli_query($conn, $query);
    $config = mysqli_fetch_assoc($result);
    return $config;
}

//funcion para agrear un nuevo tema a la BD
function agregarNuevoTema($tema){
    include("conexion.php");
    //armamos el query para insertar en la tabla temas
    $query = "INSERT INTO temas (id, nombre)
    VALUES (NULL, '$tema')";

    //insertamos en la tabla temas
    if (mysqli_query($conn, $query)) { //Se insertó correctamente
        $mensaje = "El fue agregado correctamente";
        header("Location: index.php");
    } else {
        $mensaje = "No se pudo insertar en la BD" . mysqli_errno($conn);
    }
    return $mensaje;
}


function obetenerTodosLosTemas()
{
    include("conexion.php");
    $query = "SELECT * FROM temas";
    $result = mysqli_query($conn, $query);
    return $result;
}
function obtenerNombreTema($id){
    include("conexion.php");
    $query = "SELECT * FROM temas WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $tema = mysqli_fetch_array($result);
    
    return $tema['nombre'];
}

function obetenerTodasLasPreguntas()
{
    include("conexion.php");
    $query = "SELECT * FROM preguntas";
    $result = mysqli_query($conn, $query);
    return $result;
}

function obtenerPreguntaPorId($id){
    include("conexion.php");
    $query = "SELECT * FROM preguntas WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $pregunta = mysqli_fetch_array($result);
    return $pregunta;
}

function obtenerTotalPreguntas(){
    include("conexion.php");
    //Añadimos un alias AS total para identificar mas facil
    $query = "SELECT COUNT(*) AS total FROM preguntas";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);  
    return $row['total'];
}

function totalPreguntasPorCategoria($tema){
    include("conexion.php");
    $query = "SELECT COUNT(*) AS total FROM preguntas WHERE tema = '$tema'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);  
    return $row['total'];
}

function obtenerCategorias(){
    include("conexion.php");
    //ACOntamos la cantidad de cada categoria
    $query = "SELECT tema, COUNT(DISTINCT tema) FROM preguntas GROUP BY tema";
    $result = mysqli_query($conn, $query);
    return $result;
}

function obtenerCategoriasjuego(){
    include("conexion.php");
    
    // Consultamos el total de preguntas de la configuración más reciente
    $result = $conn->query("SELECT totalPreguntas FROM config ORDER BY ultimaModificacion DESC LIMIT 1");
    
    // Comprobamos si se obtuvo un resultado
    if ($result && $result->num_rows > 0) {
        $fila = $result->fetch_assoc();
        $totalPreguntas = $fila['totalPreguntas'];

        // Consultar los temas que tienen un número de preguntas mayor o igual al total obtenido
        $query = "SELECT tema, COUNT(*) AS total_preguntas FROM preguntas GROUP BY tema HAVING total_preguntas >= $totalPreguntas";

        $result = mysqli_query($conn, $query);
        
        // Puedes optar por retornar el resultado o procesarlo aquí
        return $result; // Devuelve el resultado de la consulta de temas
    } else {
        return null; // No se encontró la configuración
    }
}




function obtenerIdsPreguntasPorCategoria($tema){
    include("conexion.php");
    $query = "SELECT id FROM preguntas WHERE tema = $tema";
    $result = mysqli_query($conn, $query);
    return $result;
}
function aumentarVisita(){
    include("conexion.php");
    //Selecciono el registro de la estadistica
    $query = "SELECT * FROM estadisticas  WHERE id='1'";
    $result = mysqli_query($conn, $query);
    $estadistica = mysqli_fetch_assoc($result);
    $visitas = $estadistica['visitas'];
    $visitas = $visitas + 1;

    $query = "UPDATE estadisticas SET visitas = '$visitas' WHERE id='1'";
    $result = mysqli_query($conn, $query);
}
function aumentarRespondidas(){
    include("conexion.php");
    //Selecciono el registro de la estadistica
    $query = "SELECT * FROM estadisticas  WHERE id='1'";
    $result = mysqli_query($conn, $query);
    $estadistica = mysqli_fetch_assoc($result);
    $respondidas = $estadistica['respondidas'];
    $respondidas = $respondidas + 1;

    $query = "UPDATE estadisticas SET respondidas = '$respondidas' WHERE id='1'";
    $result = mysqli_query($conn, $query);
}
function aumentarCompletados(){
    include("conexion.php");
    //Selecciono el registro de la estadistica
    $query = "SELECT * FROM estadisticas  WHERE id='1'";
    $result = mysqli_query($conn, $query);
    $estadistica = mysqli_fetch_assoc($result);
    $completados = $estadistica['completados'];
    $completados = $completados + 1;

    $query = "UPDATE estadisticas SET completados = '$completados' WHERE id='1'";
    $result = mysqli_query($conn, $query);
}

function registrarUsuario($nombre, $email, $password) {
    global $conn;
    
    if (!$conn) {
        include("conexion.php");
    }
    
    // Verificar si el email ya existe
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return "El email ya está registrado.";
    }
    
    // Hash de la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insertar nuevo usuario
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $email, $hashed_password);
    
    if ($stmt->execute()) {
        return true;
    } else {
        return "Error al registrar el usuario: " . $conn->error;
    }
}

function verificarCredenciales($email, $password) {
    global $conn;
    
    if (!$conn) {
        include("conexion.php");
    }
    
    $stmt = $conn->prepare("SELECT id, nombre, password FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();
        if (password_verify($password, $usuario['password'])) {
            return ['id' => $usuario['id'], 'nombre' => $usuario['nombre']];
        }
    }
    
    return false;
}

function obtenerUltimoTotalPreguntas() {
    global $conn;

    if (!$conn) {
        include("conexion.php");
    }
    $result = $conn->query("SELECT totalPreguntas FROM config ORDER BY ultimaModificacion DESC LIMIT 1"); 
    $fila = $result->fetch_assoc();
    return $fila['totalPreguntas'];
}

