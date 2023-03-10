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
if (empty($_GET['id_flujo'])) {
    echo '
    <script>
        alert("Url Invalida");
    </script>';
    header('location: inicio.php');
}
if (empty($_GET['id_flujo'])) {
    echo '
    <script>
        alert("Url Invalida");
    </script>';
    header('location: inicio.php');
}
if (empty($_GET['id_funcionario_flujo'])) {
    echo '
    <script>
        alert("Url Invalida");
    </script>';
    header('location: inicio.php');
}
if (empty($_GET['id_creador_flujo'])) {
    echo '
    <script>
        alert("Url Invalida");
    </script>';
    header('location: inicio.php');
}

$id_flujo_actual = $_GET['id_flujo'];
$id_funcionario_flujo = $_GET['id_funcionario_flujo'];
$id_creador_flujo = $_GET['id_creador_flujo'];

$sql = mysqli_query($conexion, "SELECT f.id_flujo, f.id_funcionario_flujo, f.id_creador_flujo
FROM flujos_tarea f
INNER JOIN login l
ON id_usuario=id_funcionario_flujo
WHERE id_flujo='$id_flujo_actual'");

$result_sql = mysqli_num_rows($sql);

if ($result_sql == 0) {
    echo '
        <script>
            alert("Flujo no existe");
            window.location = "inicio.php";
        </script>
        ';
    header('location: Inicio.php');
} else {
    while ($data = mysqli_fetch_array($sql)) {
        $id_funcionario = $data['id_funcionario_flujo'];
        $id_flujo = $data['id_flujo'];
        $id_creador_flujo = $data['id_creador_flujo'];
    }
}

?>
<?php

if (!empty($_POST)) {
    $idFlujo = $_POST['idFlujo'];
    $idResponsable = $_POST['idResponsable'];
    $idAsignadorTarea = $_POST['idAsignadorTarea'];
    $mensaje = $_POST['mensaje'];

    $sql_reportes = mysqli_query($conexion, "INSERT INTO reportes_f (id_funcionario_f,id_flujo_f,id_asignador_f,mensaje_f)
    VALUES ('$idResponsable','$idFlujo','$idAsignadorTarea','$mensaje')");

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
        <h2>Reportar Flujo</h2>
        <h3>Usted está Reportanto una Flujo</h3>

        <br>
        <br>
        <br>
        <br>
        <br>

        <div class="Registro_Usuario">
            <form action="" method="POST" class="formulario_registro">
                <input type="hidden" name="idFlujo" value="<?php echo $id_flujo_actual ?>">
                <input type="hidden" name="idResponsable" value="<?php echo $id_funcionario_flujo ?>">
                <input type="hidden" name="idAsignadorTarea" value="<?php echo $id_creador_flujo ?>">
                <input type="text" name="mensaje" placeholder="Ingresa Mensaje" value="" style="margin: auto; margin-bottom: 15px;">
                <button class="btn" type="submit" style="margin-left: 25%;">Reportar Flujo</button>
            </form>
        </div>
    </div>

    <?php
    include "footer.php";
    ?>
</body>

</html>