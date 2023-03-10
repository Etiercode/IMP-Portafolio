<?php
include "php/conexion_back.php";
?>
<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo '
            <script>
                alert("Debes iniciar sesión.");
                window.location = "login/login.php";
            </script>
        ';
    session_destroy();
    die();
}
?>

<?php
if (empty($_GET['id'])) {
    echo '
    <script>
        alert("Url Invalida");
    </script>';
    header('location: inicio.php');
}
if (empty($_GET['id_usuario_r'])) {
    echo '
    <script>
        alert("Url Invalida");
    </script>';
    header('location: inicio.php');
}
if (empty($_GET['id_asignador_t'])) {
    echo '
    <script>
        alert("Url Invalida");
    </script>';
    header('location: inicio.php');
}
$id_tarea_actual = $_GET['id'];
$id_usuario_r = $_GET['id_usuario_r'];
$id_asignador_t = $_GET['id_asignador_t'];

$sql = mysqli_query($conexion, "SELECT l.id_usuario, t.id_tareas, t.id_asignador
    FROM login l
    INNER JOIN tareas t
    ON id_usuario=id_funcionario
    WHERE id_tareas='$id_tarea_actual'");

$result_sql = mysqli_num_rows($sql);

if ($result_sql == 0) {
    echo '
        <script>
            alert("Tarea no existe");
            window.location = "inicio.php";
        </script>
        ';
    header('location: inicio_general.php');
} else {
    while ($data = mysqli_fetch_array($sql)) {
        $id_usuario = $data['id_usuario'];
        $id_tareas = $data['id_tareas'];
        $id_asignador = $data['id_asignador'];
    }
}

?>
<?php

if (!empty($_POST)) {
    $idTareas = $_POST['idTareas'];
    $idResponsable = $_POST['idResponsable'];
    $idAsignadorTarea = $_POST['idAsignadorTarea'];
    $mensaje = $_POST['mensaje'];

    $sql_reportes = mysqli_query($conexion, "INSERT INTO reportes (id_funcionario_r, id_tarea_r, id_asignador_t, mensaje)
    VALUES ('$idResponsable','$idTareas','$idAsignadorTarea','$mensaje')");

    if ($sql_reportes) {
        echo '
                <script>
                    alert("Reportes enviado Correctamente");
                    window.location = "inicio.php";
                </script>';
    } else {
        echo '
                <script>
                    alert("Error al enviar reporte");
                    window.location = "inicio.php";
                </script>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Icono Pestaña-->
    <link rel="icon" href="img/IMPlogo.png" type="image" sizes="16x16">

    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!--FONT OSWALD-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
    <!--CSS-->
    <link rel="stylesheet" href="css/editar_u.css">
    <title>IMP | Editar Estado</title>
</head>

<body>
    <div class="menu-btn">
        <i class="fas fa-bars fa-2x"></i>
    </div>
    <br>
    <?php
    include "header.php";
    ?>
    <div class="showcase">
        <h2>Reportar Tarea</h2>
        <h3>Usted está Reportanto una tarea</h3>

        <br>
        <br>
        <br>
        <br>
        <br>

        <div class="Registro_Usuario">
            <form action="" method="POST" class="formulario_registro">
                <input type="hidden" name="idTareas" value="<?php echo $id_tarea_actual ?>">
                <input type="hidden" name="idResponsable" value="<?php echo $id_usuario_r ?>">
                <input type="hidden" name="idAsignadorTarea" value="<?php echo $id_asignador_t ?>">
                <input type="text" name="mensaje" placeholder="Ingresa Mensaje" value="" style="margin: auto; margin-bottom: 15px;">
                <button class="btn" type="submit" style="margin-left: 25%;">Reportar Tarea</button>
            </form>
        </div>
    </div>

    <?php
    include "footer.php";
    ?>
</body>

</html>