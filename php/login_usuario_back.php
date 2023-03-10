<?php

$nombreusuario = $_POST['nombreusuario'];
$clave = $_POST['clave'];

session_start();

include_once 'conexion_back.php';

$consulta = "SELECT * FROM login WHERE nombreusuario='$nombreusuario' AND clave='$clave'";
$resultado = mysqli_query($conexion, $consulta);

$filas = mysqli_fetch_array($resultado);

if ($filas['rol'] == 1) {
    $_SESSION['id_usuario_log'] = $filas['id_usuario'];
    $_SESSION['usuario'] = $filas['nombreusuario'];
    $_SESSION['rol'] = $filas['rol'];
    header("location: ../inicio.php");
}
if ($filas['rol'] == 2) {
    $_SESSION['id_usuario_log'] = $filas['id_usuario'];
    $_SESSION['usuario'] = $filas['nombreusuario'];
    $_SESSION['rol'] = $filas['rol'];
    header("location: ../inicio.php");
}
if ($filas['rol'] == 3) {
    $_SESSION['id_usuario_log'] = $filas['id_usuario'];
    $_SESSION['usuario'] = $filas['nombreusuario'];
    $_SESSION['rol'] = $filas['rol'];
    header("location: ../inicio.php");
} else {
    echo '<script>alert("Usuario no existe, verifique datos introducidos.");window.location = "../login/login.php";</script>';
    exit;
}
