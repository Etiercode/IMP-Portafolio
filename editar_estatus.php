<?php 

include "php/conexion_back.php";

$id_flujo = $_GET['id_flujo'];
$estatus = $_GET['estatus'];

$q="UPDATE flujos_tarea SET estatus=$estatus WHERE id_flujo=$id_flujo";

mysqli_query($conexion, $q);

header('location: Flujos_tarea.php');

?>