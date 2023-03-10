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
if ($_SESSION['rol'] == 3) {
    echo '
     <script>
         alert("Debes iniciar sesión con un rol diferente");
         window.location = "inicio.php";
     </script>';
}
?>
<?php
if (empty($_GET['id_flujo'])) {
    echo '
    <script>
        alert("Id de Flujo no existe");
    </script>';
    header('location: Flujos_tarea.php');
}
$id_flujo_actual = $_GET['id_flujo'];

$sql = mysqli_query($conexion, "SELECT ft.*
    FROM flujos_tarea ft 
    INNER JOIN login l 
    ON ft.id_funcionario_flujo = l.id_usuario
    WHERE id_flujo=$id_flujo_actual");

$result_sql = mysqli_num_rows($sql);

if ($result_sql == 0) {
    echo '
        <script>
            alert("Flujo no existe");
            window.location = "Flujos_tarea.php";
        </script>
        ';
    header('location: Flujos_tarea.php');
} else {
    while ($data = mysqli_fetch_array($sql)) {
        $id_flujo = $data['id_flujo'];
        $id_funcionario_flujo = $data['id_funcionario_flujo'];
        $titulo_flujo = $data['titulo_flujo'];
        $desc_flujo = $data['desc_flujo'];
        $tareas_sin_f = $data['tareas_sin_f'];
        $estatus = $data['estatus'];
    }
}

?>
<?php
if (!empty($_POST)) {
    $idFlujo = $_POST['idFlujo'];
    $titulo_flujo = $_POST['titulo_flujo'];
    $desc_flujo = $_POST['desc_flujo'];
    $tareas_sin_f = $_POST['tarea'];
    if (!empty($tareas_sin_f)) {
        $t = implode(', ', $tareas_sin_f);
    } else {
        echo '<script>alert("No Hay tareas seleccionadas");
        window.location = "../flujosdetareas.php";</script>';
        mysqli_close($conexion);
    }

    if (empty($titulo_flujo)) {
        echo '<script>alert("Campo titulo Vacío");
        window.location = "editar_flujo.php?id_flujo=' . $id_flujo_actual . '";</script>';
        mysqli_close($conexion);
    }
    if (empty($desc_flujo)) {
        echo '<script>alert("Campo Descripción Vacío");
        window.location = "editar_flujo.php?id_flujo=' . $id_flujo_actual . '";</script>';
        mysqli_close($conexion);
    }

    $sql_update = mysqli_query($conexion, "UPDATE flujos_tarea SET titulo_flujo='$titulo_flujo', desc_flujo='$desc_flujo', tareas_sin_f='$t' WHERE id_flujo='$idFlujo'");

    if ($sql_update) {
        echo '
                <script>
                    alert("Flujo Actualizado Correctamente");
                    window.location = "Flujos_tarea.php";
                </script>';
    } else {
        echo '
                <script>
                    alert("Error al actualizar Flujo");
                    window.location = "Flujos_tarea.php";
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
        <h2>Editar Flujos</h2>
        <h3>Usted está Editando Flujos</h3>
        <div class="Registro_Usuario">
            <form action="" method="POST" class="formulario_registro">
                <input type="hidden" name="idFlujo" value="<?php echo $id_flujo ?>">
                <label>Titulo Flujo</label>
                <input type="text" placeholder="Titulo" name="titulo_flujo" value="<?php echo $titulo_flujo ?>">
                <label>Descripcion</label>
                <input type="text" placeholder="Descripcion" name="desc_flujo" value="<?php echo $desc_flujo ?>">
                <br>
                <label><?php
                        echo 'Tareas seleccionadas previamente: <br>';
                        foreach (explode(', ', $tareas_sin_f) as $tareas_sin) {
                            $query_titulo = mysqli_query($conexion, "SELECT titulo_tarea_r FROM tareas_sin WHERE id_tarea_sin=$tareas_sin");
                            while ($row = $query_titulo->fetch_assoc()) {
                                $titulo = $row['titulo_tarea_r'];
                            }
                            echo 'Titulo: <span style="color: red;">' . $titulo . '</span> / ';
                        } ?>
                </label>
                <br>
                <br>
                <label>Seleccione tareas</label>
                <br>
                <?php
                $query_checkbox = mysqli_query($conexion, "SELECT * FROM tareas_sin");
                $result_checkbox = mysqli_num_rows($query_checkbox);
                if ($result_checkbox > 0) {
                    while ($data_checkbox = mysqli_fetch_array($query_checkbox)) {
                        echo '
                        <label class="checkbox-inline" style="padding-right: 7px; padding-left: 7px;border-right:1px solid gray;">
                            <input type="checkbox" value="' . $data_checkbox['id_tarea_sin'] . '" name="tarea[]">' . $data_checkbox['titulo_tarea_r'] . '
                        </label>
                        ';
                    }
                } else {
                    echo '<br> No hay tareas creadas para seleccionar <br> <br>';
                }
                ?>
                <br>
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