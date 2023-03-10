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
        alert("Id de usuario no existe");
    </script>';
    header('location: inicio.php');
}
$id_tarea_actual = $_GET['id'];

$sql = mysqli_query($conexion, "SELECT l.id_usuario, t.id_tareas
    FROM login l
    INNER JOIN tareas t
    ON id_usuario=id_funcionario
    WHERE id_tareas='$id_tarea_actual'");

$result_sql = mysqli_num_rows($sql);

if ($result_sql == 0) {
    echo '
        <script>
            alert("Usuario no existe");
            window.location = "usuarios.php";
        </script>
        ';
    header('location: inicio_general.php');
} else {
    while ($data = mysqli_fetch_array($sql)) {
        $id_usuario = $data['id_usuario'];
        $id_tareas = $data['id_tareas'];
    }
}

?>
<?php
if (!empty($_POST)) {
    $idTareas = $_POST['idTareas'];
    $idUsuario = $_POST['id_usuario'];

    $sql_update = mysqli_query($conexion, "UPDATE tareas SET id_funcionario='$idUsuario' WHERE id_tareas='$idTareas'");

    if ($sql_update) {
        echo '
                <script>
                    alert("Responsable Actualizado Correctamente");
                    window.location = "inicio_general.php";
                </script>';
    } else {
        echo '
                <script>
                    alert("Error al actualizar responsable");
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
        <h2>Reasignar Funcionario</h2>
        <h3>Usted está Editando Estado de tarea</h3>

        <br>
        <br>
        <br>
        <br>
        <br>

        <div class="Registro_Usuario">
            <form action="" method="POST" class="formulario_registro">
                <input type="hidden" name="idTareas" value="<?php echo $id_tarea_actual ?>">
                <select name="id_usuario">
                    <?php
                    $query = mysqli_query($conexion, "SELECT id_usuario, nombreusuario FROM login");
                    $funcionarios = mysqli_num_rows($query);
                    if ($funcionarios > 0) {
                        while ($responsable = mysqli_fetch_array($query)) {
                    ?>
                            <option value="<?php echo $responsable["id_usuario"]; ?>"><?php echo $responsable["nombreusuario"]; ?></option>
                    <?php
                        }
                    }
                    ?>
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