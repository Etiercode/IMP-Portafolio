<?php

include_once "conexion_back.php";

date_default_timezone_set("America/Santiago");
$fecha_actual = new DateTime(date("d-m-Y"));

$id_funcionario_flujo = $_POST['id_funcionario_flujo'];
$titulo_flujo = $_POST['titulo_flujo'];
$desc_flujo = $_POST['desc_flujo'];
$estatus = 0;
$usuario_log = $_POST['usuario_log'];
$tareas_sin_f = $_POST['tarea'];
if (!empty($tareas_sin_f)) {
    $t = implode(', ', $tareas_sin_f);
} else {
    echo '<script>alert("No Hay tareas seleccionadas");
    window.location = "../flujosdetareas.php";</script>';
    mysqli_close($conexion);
}

if (strlen($desc_flujo) > 200) {
    echo '<script>alert("Campo Descripcion supera lo permitido");
    window.location = "../tareas.php";</script>';
    mysqli_close($conexion);
}
if (strlen($titulo_flujo) > 30) {
    echo '<script>alert("Campo Titulo supera lo permitido");
    window.location = "../tareas.php";</script>';
    mysqli_close($conexion);
}

if (empty($titulo_flujo)) {
    echo '<script>alert("Campo Titulo del Flujo Vacio");
    window.location = "../flujosdetareas.php";</script>';
    mysqli_close($conexion);
}
if (empty($desc_flujo)) {
    echo '<script>alert("Campo Descripcion del Flujo Vacio");
    window.location = "../flujosdetareas.php";</script>';
    mysqli_close($conexion);
}

// if ($conexion->query($query_flujo) == true){
//     $id_flujo_last = $conexion->insert_id;
// }
$sum = 0;

foreach (explode(', ', $t) as $tareas_sin) {
    $query_duracion = mysqli_query($conexion, "SELECT duracion_tarea FROM tareas_sin WHERE id_tarea_sin=$tareas_sin");
    while ($row = $query_duracion->fetch_assoc()) {
        $duraciones = intval($row['duracion_tarea']);
    }
    $sum = $sum+$duraciones;
}

$query_flujo = "INSERT INTO flujos_tarea(id_funcionario_flujo, id_creador_flujo, titulo_flujo, desc_flujo, tareas_sin_f,duracion_flujo, estatus) 
VALUES('$id_funcionario_flujo', '$usuario_log', '$titulo_flujo', '$desc_flujo', '$t','$sum', '$estatus')";
$ejecutar_flujo = mysqli_query($conexion, $query_flujo);

if ($ejecutar_flujo) {
    echo '
        <script>
        alert("Flujo Creado");
        window.location = "../flujosdetareas.php";   
        </script>
        ';
} else {
    echo '
        <script>
        alert("Flujo de Tareas no Creado");
        window.location = "../flujosdetareas.php";
        </script>
        ';
}

mysqli_close($conexion);
