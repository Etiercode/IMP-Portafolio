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
if (empty($_GET['id'])) {
    echo '
    <script>
        alert("Id de tarea no existe");
    </script>';
    header('location: inicio.php');
}

$id_tarea = $_GET['id'];
$progreso_tarea = $_GET['progreso_tarea'];

if (empty($_GET['progreso_tarea'])) {
    echo '
    <script>
        alert("Progreso de Tarea Invalido");
    </script>';
    header('location: inicio.php');
}

$sql = mysqli_query($conexion, "SELECT t.id_tareas, t.id_funcionario, l.id_usuario, t.titulo_tarea, t.descripcion, t.estado, t.fecha_inicio, t.fecha_termino, t.plazo 
    FROM tareas t 
    INNER JOIN login l 
    ON t.id_funcionario = l.id_usuario");

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
        $id_tareas = $data['id_tareas'];
        $id_funcionario = $data['id_usuario'];
        $estado = $data['estado'];
    }
}

?>
<?php
if (!empty($_POST)) {
    $estado = $_POST['estado'];
    $progreso = $_POST['progreso'];



    $sql_update = mysqli_query($conexion, "UPDATE tareas SET estado='$estado', progreso='$progreso' WHERE id_tareas='$id_tarea'");

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
        <h2>Editar Estado</h2>
        <h3>Usted está Editando Estado de tarea</h3>
        <p style="color: red;">Recuerda que al colocar la tarea en "Terminado", esta se eliminarán de tu carga de trabajo</p>

        <br>
        <br>
        <br>
        <br>
        <br>

        <div class="Registro_Usuario">
            <form action="" method="POST" class="formulario_registro">
                <input type="hidden" name="progreso" value="<?php echo $progreso_tarea ?>">
                <select name="estado" class="sexo">
                    <option type="text" placeholder="estado" name="estado">Terminado</option>
                </select>
                <button class="btn" type="submit" style="margin-left: 25%;">Actualizar</button>
            </form>
        </div>
    </div>

    <?php
    include "footer.php";
    ?>
</body>

</html>