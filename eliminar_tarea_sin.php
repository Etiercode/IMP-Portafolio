<?php 

include "php/conexion_back.php";

$id_tarea_sin = $_GET['id_tarea_sin'];


$q="DELETE FROM tareas_sin WHERE id_tarea_sin=$id_tarea_sin";

mysqli_query($conexion, $q);

header('location: inicio.php');

?>