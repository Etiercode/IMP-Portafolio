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

include "php/conexion_back.php";

if (!empty($_POST)) {
    $idReporte = $_POST['idReporte'];

    $query_delete = mysqli_query($conexion, "DELETE FROM reportes WHERE id_reporte='$idReporte'");
    if ($query_delete) {
        echo '
        <script>
            alert("Reporte Eliminado");
            header("location: reportes.php");
        </script>';
        header("location: reportes.php");
    } else {
        echo '
        <script>
            alert("Error al eliminar Reporte");
            header("location: reportes.php");
        </script>';
    }
}

if (empty($_REQUEST['id'])) {
    echo '
    <script>
        alert("Reporte No existe");
        header("location: reportes.php");
    </script>';
} else {

    include "php/conexion_back.php";

    $id_reporte = $_REQUEST['id'];

    $sql = mysqli_query($conexion, "SELECT * FROM reportes 
    WHERE id_reporte=$id_reporte");

    $result = mysqli_num_rows($sql);

    if ($result > 0) {
        while ($data = mysqli_fetch_array($sql)) {
            $id_reporte = $data['id_reporte'];
            $mensaje = $data['mensaje'];
            $id_funcionario_r = $data['id_funcionario_r'];
        }
    } else {
        header("location: reportes.php");
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
    <title>IMP | Editar Usuarios</title>
</head>

<body>
    <div class="menu-btn">
        <i class="fas fa-bars fa-2x"></i>
    </div>
    <?php
    include "header.php";
    ?>
    <br>
    <br>
    <br>
    <br>
    <div class="showcase">
        <h2>Eliminar Reporte</h2>
        <h3>¿Estás seguro que quieres eliminar este reporte?</h3>
        <br>
        <br>
        <p style="font-size: 25px;">Id Reporte: <span style="font-weight: bold; color: #4f72d4; font-size: 20px;"><?php echo $id_reporte ?></span></p>
        <p style="font-size: 25px;">Id Funcionario Responsable: <span style="font-weight: bold; color: #4f72d4; font-size: 20px;"><?php echo $id_funcionario_r ?></span></p>
        <p style="font-size: 25px;">Mensaje: <span style="font-weight: bold; color: #4f72d4; font-size: 20px;"><?php echo $mensaje ?></span></p>

        <form method="POST" action="">
            <input type="hidden" name="idReporte" value="<?php echo $id_reporte ?>">
            <a href="reportes.php" class="btn_cancel" style="width: 124px;background: rgb(177, 68, 68);color: white;display: inline-block;padding: 9px;border-radius: 5px;cursor: pointer;">Cancelar</a>
            <input type="submit" value="Aceptar" class="btn_ok" style="width: 124px;background: rgb(51, 151, 89);color: white;display: inline-block;border-radius: 5px;cursor: pointer;">
        </form>
    </div>

    <?php
    include "footer.php";
    ?>
</body>

</html>