<?php
include "../IMP/php/conexion_back.php";
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
if (empty($_GET['id_tarea_sin'])) {
    echo '
    <script>
        alert("Id de tarea no existe");
    </script>';
    header('location: inicio.php');
}

$id_tarea_sin_ = $_GET['id_tarea_sin'];

$sql = mysqli_query($conexion, "SELECT * FROM tareas_sin WHERE id_tarea_sin=$id_tarea_sin_");

$result_sql = mysqli_num_rows($sql);

if ($result_sql == 0) {
    echo '
        <script>
            alert("Tarea no existe");
            window.location = "usuarios.php";
        </script>
        ';
    header('location: inicio.php');
} else {
    while ($data = mysqli_fetch_array($sql)) {
        $id_tarea_sin = $data['id_tarea_sin'];
        $id_asignador_r = $data['id_asignador_r'];
        $titulo_tarea_r = $data['titulo_tarea_r'];
        $descripcion_r = $data['descripcion_r'];
        $fecha_creacion = $data['fecha_creacion'];
        $duracion_tarea = $data['duracion_tarea'];
    }
}

?>
<?php
if (!empty($_POST)) {
    $titulo_tarea = $_POST['titulo_tarea_r'];
    $descripcion = $_POST['descripcion_r'];
    $duracion_tarea = $_POST['duracion_tarea'];
    $idTareas = $_POST['idTareas'];

    if (empty($descripcion)) {
        echo '<script>alert("Campo Descripción Vacío");
            window.location = "editar_tarea_sin.php?id_tarea_sin=' . $id_tarea_sin_ . '";</script>';
        mysqli_close($conexion);
    }
    if (empty($titulo_tarea)) {
        echo '<script>alert("Campo Titulo Vacío");
        window.location = "editar_tarea_sin.php?id_tarea_sin=' . $id_tarea_sin_ . '";</script>';
        mysqli_close($conexion);
    }

    $sql_update = mysqli_query($conexion, "UPDATE tareas_sin SET titulo_tarea_r='$titulo_tarea', descripcion_r='$descripcion', duracion_tarea='$duracion_tarea' WHERE id_tarea_sin='$idTareas'");

    if ($sql_update) {
        echo '
                <script>
                    alert("Tarea Actualizada Correctamente");
                    window.location = "inicio.php";
                </script>';
    } else {
        echo '
                <script>
                    alert("Error al actualizar tarea");
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
    <title>IMP | Editar Usuarios</title>
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
        <h2>Editar Tareas</h2>
        <h3>Usted está Editando Tareas</h3>
        <div class="Registro_Usuario">
            <form action="" method="POST" class="formulario_registro">
                <input type="hidden" name="idTareas" value="<?php echo $id_tarea_sin_ ?>">
                <label>Titulo Tarea</label>
                <input type="text" placeholder="Titulo" name="titulo_tarea_r" value="<?php echo $titulo_tarea_r ?>">
                <label>Descripcion</label>
                <input type="text" placeholder="Descripcion" name="descripcion_r" value="<?php echo $descripcion_r ?>">
                <label for="">Duración Tarea <?php echo '<span style="color: red;">Duracion Anterior: ' . $duracion_tarea, 'dia(s)' . '</span>' ?></label>
                <select name="duracion_tarea">
                    <option value='01'>01</option>
                    <option value='02'>02</option>
                    <option value='03'>03</option>
                    <option value='04'>04</option>
                    <option value='05'>05</option>
                    <option value='06'>06</option>
                    <option value='07'>07</option>
                    <option value='08'>08</option>
                    <option value='09'>09</option>
                    <option value='10'>10</option>
                    <option value='11'>11</option>
                    <option value='12'>12</option>
                    <option value='13'>13</option>
                    <option value='14'>14</option>
                    <option value='15'>15</option>
                    <option value='16'>16</option>
                    <option value='17'>17</option>
                    <option value='18'>18</option>
                    <option value='19'>19</option>
                    <option value='20'>20</option>
                    <option value='21'>21</option>
                    <option value='22'>22</option>
                    <option value='23'>23</option>
                    <option value='24'>24</option>
                    <option value='25'>25</option>
                    <option value='26'>26</option>
                    <option value='27'>27</option>
                    <option value='28'>28</option>
                    <option value='29'>29</option>
                    <option value='30'>30</option>
                    <option value='31'>31</option>
                </select>
                <button class="btn" type="submit">Actualizar</button>
            </form>
        </div>
    </div>

    <?php
    include "footer.php";
    ?>
</body>

</html>