
<?php
$host = "localhost";
$basededatos = "farmacia_db";
$usuario = "root";
$contrasena = "";
$puerto = "3306";

// Crear conexión
$conexion = new mysqli($host, $usuario, $contrasena, $basededatos, $puerto);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Recibir los datos del formulario
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT); // Encriptar la contraseña
$Producto_comprado = isset($_POST['Producto_comprado']) ? $_POST['Producto_comprado'] : null;

if ($Producto_comprado === null) {
    echo "Error: Debes ingresar un producto comprado.";
} else {
    // Verificar si el correo ya existe
    $sql_verificar = "SELECT * FROM usuarios WHERE correo = '$correo'";
    $resultado = $conexion->query($sql_verificar);

    if ($resultado->num_rows > 0) {
        echo "Error: El correo ya está registrado.";
    } else {
        // Insertar los datos en la base de datos
        $sql_insertar = "INSERT INTO usuarios (nombre, correo, contrasena, Producto_comprado) VALUES ('$nombre', '$correo', '$contrasena', '$Producto_comprado')";
        
        if ($conexion->query($sql_insertar) === TRUE) {
            echo "Registro exitoso";
        } else {
            echo "Error: " . $sql_insertar . "<br>" . $conexion->error;
        }
    }
}

// Cerrar la conexión
$conexion->close();
?>
