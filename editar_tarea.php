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
if ($_SESSION['rol'] == 2) {
    echo '
     <script>
         alert("Debes iniciar sesión con un rol diferente");
         window.location = "inicio.php";
     </script>';
}
?>

<?php
if (empty($_GET['id'])) {
    echo '
    <script>
        alert("Id de tarea no existe");
    </script>';
    header('location: inicio.php');
}
$id_tarea = $_GET['id'];
if ($_SESSION['rol'] == 1) {

    $sql = mysqli_query($conexion, "SELECT t.id_tareas, t.id_funcionario, l.id_usuario, t.titulo_tarea, t.descripcion, t.estado, t.fecha_inicio, t.fecha_termino, t.plazo 
    FROM tareas t 
    INNER JOIN login l 
    ON t.id_funcionario = l.id_usuario
    WHERE id_tareas=$id_tarea");

    $result_sql = mysqli_num_rows($sql);

    if ($result_sql == 0) {
        echo '
        <script>
            alert("Tarea no existe");
            window.location = "inicio.php";
        </script>
        ';
        header('location: inicio.php');
    } else {
        while ($data = mysqli_fetch_array($sql)) {
            $id_tareas = $data['id_tareas'];
            $id_funcionario = $data['id_usuario'];
            $titulo_tarea = $data['titulo_tarea'];
            $descripcion = $data['descripcion'];
            $estado_actual = $data['estado'];
            $fecha_inicio = $data['fecha_inicio'];
            $fecha_termino = $data['fecha_termino'];
            $plazo = $data['plazo'];
        }
    }
}
?>
<?php
if (!empty($_POST)) {
    $titulo_tarea = $_POST['titulo_tarea'];
    $descripcion = $_POST['descripcion'];
    $estado = $_POST['estado'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_termino = $_POST['fecha_termino'];

    date("Y-m-d");

    $date1 = strtotime($_REQUEST['fecha_inicio']);
    $date2 = strtotime($_REQUEST['fecha_termino']);

    $plazo = round((((($date2 - $date1) / 60) / 60) / 24), 2);

    if (empty($descripcion)) {
        echo '<script>alert("Campo Descripción Vacío");
        window.location = "editar_tarea.php?id=' . $id_tarea . '";</script>';
        mysqli_close($conexion);
    }
    if (empty($titulo_tarea)) {
        echo '<script>alert("Campo titulo Vacío");
        window.location = "editar_tarea.php?id=' . $id_tarea . '";</script>';
        mysqli_close($conexion);
    }

    if ($plazo < 0) {
        echo '<script>alert("Plazo tiene un valor Negativo, Revisar las fechas");
        window.location = "editar_tarea.php?id=' . $id_tarea . '";</script>';
        mysqli_close($conexion);
    }
    if ($plazo == 0 || $plazo == '') {
        echo '<script>alert("Plazo tiene un valor invalido, Revisar las fechas");
        window.location = "editar_tarea.php?id=' . $id_tarea . '";</script>';
        mysqli_close($conexion);
    }

    date("Y-m-d");

    $sql_update = mysqli_query($conexion, "UPDATE tareas SET titulo_tarea='$titulo_tarea', descripcion='$descripcion', estado='$estado', fecha_inicio='$fecha_inicio', fecha_termino='$fecha_termino' WHERE id_tareas='$id_tarea'");

    if ($sql_update) {
        echo '
                <script>
                    alert("Tarea Actualizada Correctamente");
                    window.location = "inicio_general.php";
                </script>';
    } else {
        echo '
                <script>
                    alert("Error al actualizar tarea");
                    window.location = "inicio_general.php";
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
                <input type="hidden" name="idTareas" value="<?php echo $id_tarea ?>">
                <label>Titulo Tarea</label>
                <input type="text" placeholder="Titulo" name="titulo_tarea" value="<?php echo $titulo_tarea ?>">
                <label>Descripcion</label>
                <input type="text" placeholder="Descripcion" name="descripcion" value="<?php echo $descripcion ?>">
                <label>Estado</label>
                <select name="estado" class="sexo">
                    <?php
                    if ($estado_actual == 'Terminado') {
                        echo '<option type="text" placeholder="estado" name="estado">Terminado</option>';
                    } 
                    if ($estado_actual == 'En Progreso'){
                        echo '<option type="text" placeholder="estado" name="estado">En Progreso</option>';
                    }
                    ?>
                </select>
                <label><br><?php echo 'La fecha inicio anterior era: '.'<span style="color: red;">'.$fecha_inicio.'</span>'.' y la Fecha Termino anterior era: '.'<span style="color: red;">'.$fecha_termino.'</span>'  ?></label>
                <br>
                <br>
                <div class="row">
                    <div class="col">
                        <label style="padding-right: 30px;">Fecha Inicio</label>
                        <input type="date" name="fecha_inicio">
                    </div>
                    <div class="col">
                        <label style="padding-right: 15px;">Fecha Termino</label>
                        <input type="date" name="fecha_termino">
                    </div>
                </div>
                <br>
                <button class="btn" type="submit">Actualizar</button>
            </form>
        </div>
    </div>

    <?php
    include "footer.php";
    ?>
</body>

</html>