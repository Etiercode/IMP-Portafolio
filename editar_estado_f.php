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
if (empty($_GET['id_flujo'])) {
    echo '
    <script>
        alert("Id de Flujo no existe");
    </script>';
    header('location: inicio.php');
}

$id_flujo = $_GET['id_flujo'];
$id_funcionario_flujo = $_GET['id_funcionario_flujo'];
$id_creador_flujo = $_GET['id_creador_flujo'];
$estatus = $_GET['estatus'];
$titulo_flujo = $_GET['titulo_flujo'];

if (empty($_GET['id_funcionario_flujo'] || $_GET['id_creador_flujo'] || $estatus = $_GET['estatus'])) {
    echo '
    <script>
        alert("Url Invalida");
    </script>';
    header('location: inicio.php');
}

$sql = mysqli_query($conexion, "SELECT ft.* 
    FROM flujos_tarea ft 
    INNER JOIN login l 
    ON ft.id_funcionario_flujo = l.id_usuario");

$result_sql = mysqli_num_rows($sql);

if ($result_sql == 0) {
    echo '
        <script>
            alert("Flujo no existe");
            window.location = "inicio.php";
        </script>
        ';
    header('location: inicio.php');
} else {
    while ($data = mysqli_fetch_array($sql)) {
        $id_flujo = $data['id_flujo'];
        $id_funcionario_flujo = $data['id_funcionario_flujo'];
        $id_creador_flujo = $data['id_creador_flujo'];
    }
}

?>
<?php
if (!empty($_POST)) {
    $estatus = $_POST['estatus'];
    $idFlujo = $_POST['idFlujo'];
    $idFuncionario_flujo = $_POST['idFuncionario_flujo'];
    $idCreador_flujo = $_POST['idCreador_flujo'];
    $mensaje_f = "El usuario ha terminado el Flujo asignado";

    $sql_update = mysqli_query($conexion, "UPDATE flujos_tarea SET estatus='$estatus' WHERE id_flujo='$idFlujo'");
    $sql_reporte = mysqli_query($conexion, "INSERT INTO reportes_f(id_funcionario_f, id_flujo_f, id_asignador_f, mensaje_f) 
    VALUES('$idFuncionario_flujo','$idFlujo','$idCreador_flujo','$mensaje_f')");

    if ($sql_update && $sql_reporte) {
        echo '
                <script>
                    alert("Flujo Terminado Correctamente");
                    window.location = "inicio.php";
                </script>';
    } else {
        echo '
                <script>
                    alert("Error al actualizar Flujo");
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
    <title>IMP | Terminar Flujo</title>
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
        <h3>Usted está Terminando un Flujo de Tarea</h3>
        <p style="color: red;">Recuerda que al Terminar el FLujo, esta se eliminarán de tu carga de trabajo</p>

        <br>
        <br>
        <br>

        <div class="Registro_Usuario">
            <form action="" method="POST" class="formulario_registro">
                <input type="hidden" name="estatus" value="<?php echo $estatus ?>">
                <input type="hidden" name="idFlujo" value="<?php echo $id_flujo ?>">
                <input type="hidden" name="idFuncionario_flujo" value="<?php echo $id_funcionario_flujo ?>">
                <input type="hidden" name="idCreador_flujo" value="<?php echo $id_creador_flujo ?>">
                <h2>Estás seguro de terminar el flujo:</h2>
                <p style="text-align: center;">Titulo Flujo: <span style="color: red;"><?php echo $titulo_flujo ?></span></p>
                <br>
                <br>
                <button class="btn" type="submit" style="margin-left: 25%;">Terminar Flujo</button>
            </form>
        </div>
    </div>

    <?php
    include "footer.php";
    ?>
</body>

</html>