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
    $idFlujo = $_POST['idFlujo'];

    $query_delete = mysqli_query($conexion, "DELETE FROM flujos_tarea WHERE id_flujo='$idFlujo'");
    if ($query_delete) {
        echo '
        <script>
            alert("Flujo Eliminado");
            header("location: Flujos_tarea.php");
        </script>';
        header("location: Flujos_tarea.php");
    } else {
        echo '
        <script>
            alert("Error al eliminar Flujo");
            header("location: Flujos_tarea.php");
        </script>';
    }
}

if (empty($_REQUEST['id_flujo'])) {
    echo '
    <script>
        alert("Flujo No existe");
        header("location: Flujos_tarea.php");
    </script>';
} else {

    include "php/conexion_back.php";

    $id_flujo = $_REQUEST['id_flujo'];
    $titulo_flujo = $_REQUEST['titulo_flujo'];

    $sql = mysqli_query($conexion, "SELECT * FROM flujos_tarea 
    WHERE id_flujo=$id_flujo");

    $result = mysqli_num_rows($sql);

    if ($result > 0) {
        while ($data = mysqli_fetch_array($sql)) {
            $id_flujo = $data['id_flujo'];
        }
    } else {
        header("location: Flujos_tarea.php");
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
        <h2>Eliminar Flujo</h2>
        <h3>¿Estás seguro que quieres eliminar este Flujo?</h3>
        <br>
        <br>
        <p style="font-size: 25px;">Id Flujo: <span style="font-weight: bold; color: #4f72d4; font-size: 20px;"><?php echo $id_flujo ?></span></p>
        <p style="font-size: 25px;">Titulo: <span style="font-weight: bold; color: #4f72d4; font-size: 20px;"><?php echo $titulo_flujo ?></span></p>

        <form method="POST" action="">
            <input type="hidden" name="idFlujo" value="<?php echo $id_flujo ?>">
            <a href="Flujos_tarea.php" class="btn_cancel" style="width: 124px;background: rgb(177, 68, 68);color: white;display: inline-block;padding: 9px;border-radius: 5px;cursor: pointer;">Cancelar</a>
            <input type="submit" value="Aceptar" class="btn_ok" style="width: 124px;background: rgb(51, 151, 89);color: white;display: inline-block;border-radius: 5px;cursor: pointer;">
        </form>
    </div>

    <?php
    include "footer.php";
    ?>
</body>

</html>