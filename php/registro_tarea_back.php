<?php

include 'conexion_back.php';

date_default_timezone_set("America/Santiago");
$fecha_actual = new DateTime(date("d-m-Y"));

$date1 = strtotime($_REQUEST['fecha_inicio']);
$date2 = strtotime($_REQUEST['fecha_termino']);

$plazo = round((((($date2 - $date1) / 60) / 60) / 24), 2);

$id_usuario = $_POST['id_funcionario'];
$titulo_tarea = $_POST['titulo_tarea'];
$descripcion = $_POST['descripcion'];
$estado = $_POST['estado'];
$progreso = $_POST['progreso'];
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_termino = $_POST['fecha_termino'];
$id_asignador = $_POST['id_asignador'];

if (strlen($descripcion) > 200) {
    echo '<script>alert("Campo Descripcion supera lo permitido");
    window.location = "../Tareas.php";</script>';
    mysqli_close($conexion);
}
if (strlen($titulo_tarea) > 30) {
    echo '<script>alert("Campo Titulo supera lo permitido");
    window.location = "../Tareas.php";</script>';
    mysqli_close($conexion);
}
if (empty($titulo_tarea)) {
    echo '<script>alert("Campo Titulo Vacío");
        window.location = "../Tareas.php";</script>';
    mysqli_close($conexion);
}
if (empty($descripcion)) {
    echo '<script>alert("Campo Descripción Vacío");
        window.location = "../Tareas.php";</script>';
    mysqli_close($conexion);
}

if ($plazo <= 0) {
    echo '<script>alert("Fechas Introducidas son Invalidas");
    window.location = "../Tareas.php";</script>';
    mysqli_close($conexion);
}

$query = "INSERT INTO tareas(id_funcionario,id_asignador,titulo_tarea, descripcion, estado, progreso, fecha_inicio, fecha_termino, plazo) 
VALUES('$id_usuario','$id_asignador','$titulo_tarea','$descripcion', '$estado', '$progreso', '$fecha_inicio', '$fecha_termino', '$plazo')";

$ejecutar = mysqli_query($conexion, $query);

if ($ejecutar) {
    echo '

        <script>
        alert("Tarea Agregada");
        window.location = "../Tareas.php";
        </script>

        ';
} else {

    echo '

        <script>
        alert("Tarea no Agregada favor de revisar bien");
        window.location = "../Tareas.php";
        </script>

        ';
}

mysqli_close($conexion);
