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
    $idtareas = $_POST['idtareas'];

    $query_delete = mysqli_query($conexion, "DELETE FROM tareas WHERE id_tareas=$idtareas");

    if ($query_delete > 0) {
        echo '
        <script>
            alert("Tarea Eliminada");
            window.location = "inicio_general.php";
        </script>
        ';
    } else {
        '
        <script>
            alert("Error al eliminar tarea");
            window.location = "inicio_general.php";
        </script>
    ';
    }
}


if (empty($_REQUEST['id'])) {
    header("location: inicio_general.php");
} else {

    $idtareas = $_REQUEST['id'];

    $query_select = mysqli_query($conexion, "SELECT id_tareas, titulo_tarea, descripcion FROM tareas WHERE id_tareas=$idtareas");
    $resultado = mysqli_num_rows($query_select);
    if ($resultado > 0) {
        while ($data = mysqli_fetch_array($query_select)) {
            $titulo_tarea = $data['titulo_tarea'];
            $descripcion = $data['descripcion'];
            $id_tareas = $data['id_tareas'];
        }
    } else {
        echo '
        <script>
            alert("Tarea no Existente");
            window.location = "inicio_general.php";
        </script>
    ';
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
    <title>IMP | Eliminar Tarea</title>
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
        <h2>Eliminar Tareas</h2>
        <h3>¿Estás seguro que quieres eliminar esta tarea?</h3>
        <br>
        <br>
        <p style="font-size: 25px;">Titulo Tarea: <span style="font-weight: bold; color: #4f72d4; font-size: 20px;"><?php echo $titulo_tarea ?></span></p>
        <p style="font-size: 25px;">Descripcion Tarea: <span style="font-weight: bold; color: #4f72d4; font-size: 20px;"><?php echo $descripcion ?></span></p>
        <p style="font-size: 25px;">Id tarea: <span style="font-weight: bold; color: #4f72d4; font-size: 20px;"><?php echo $id_tareas ?></span></p>

        <form method="POST" action="">
            <input type="hidden" name="idtareas" value="<?php echo $idtareas ?>">
            <a href="inicio.php" class="btn_cancel" style="width: 124px;background: rgb(177, 68, 68);color: white;display: inline-block;padding: 9px;border-radius: 5px;cursor: pointer;">Cancelar</a>
            <input type="submit" value="Aceptar" class="btn_ok" style="width: 124px;background: rgb(51, 151, 89);color: white;display: inline-block;border-radius: 5px;cursor: pointer;">
        </form>
    </div>

    <?php
    include "footer.php";
    ?>
</body>

</html>