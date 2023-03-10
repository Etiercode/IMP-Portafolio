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
date_default_timezone_set("America/Santiago");
$fecha_actual = new DateTime(date("d-m-Y"));
?>
<?php
include "../IMP/php/conexion_back.php";
?>
<?php
$id = $_SESSION['id_usuario_log'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMP | Inicio</title>

    <!--Icono Pestaña-->
    <link rel="icon" href="img/IMPlogo.png" type="image" sizes="16x16">

    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!--FONT OSWALD-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">

    <!--CSS-->
    <link rel="stylesheet" href="css/inicio1.css">

</head>

<body>
    <div class="menu-btn">
        <i class="fas fa-bars fa-2x"></i>
    </div>
    <?php
    include "header.php";
    ?>
    <br>
    <h2 class="HeaderLista">Bienvenido <?php echo $_SESSION['usuario'] ?></h2>
    <?php if ($_SESSION['rol'] == 1) { ?>
        <a href="inicio_general.php" style="margin-left: 45%; Color: green">Ver Todas las Tareas</a>
    <?php } ?>
    <h3 class="HeaderLista"><i class="fa-solid fa-list-check"></i> Tareas que usted a asignado</h3>
    <br>
    <?php
    $query = mysqli_query($conexion, "SELECT t.id_tareas,t.titulo_tarea,t.descripcion,t.estado,t.progreso,t.fecha_inicio,t.fecha_termino,t.plazo,l.id_usuario,l.nombreusuario,t.id_asignador FROM tareas t INNER JOIN login l on t.id_funcionario = l.id_usuario WHERE $_SESSION[id_usuario_log]=id_asignador");

    $result = mysqli_num_rows($query);
    if ($result > 0) {

        while ($data = mysqli_fetch_array($query)) {
    ?>
            <table>
                <tr>
                    <th>Titulo Tarea</th>
                    <th>Descripción de la tarea</th>
                    <th>Estado de la tarea</th>
                    <th>Progreso</th>
                    <th>Fecha de inicio</th>
                    <th>Fecha de término</th>
                    <th>Plazo (Dias)</th>
                    <th>Acciones</th>
                </tr>
                <tr>
                    <?php
                    $fecha_termino_t = new DateTime($data['fecha_termino']);
                    $diff = date_diff($fecha_termino_t, $fecha_actual);
                    $meses = $diff->m;
                    $dias = $diff->d;
                    $anio = $diff->y;
                    $vencido = $diff->invert;
                    //INVERT 1 DENTRO DEL PLAZO Y 0 FUERA DEL PLAZO
                    if ($vencido == 0) {
                        $meses = $meses * (-1);
                        $dias = $dias * (-1);
                        $atrasado = 'Tarea_terminada_con_atraso';
                    } else {
                        if ($dias > 3) {
                            $atrasado = 'Tarea_terminada';
                        }
                        if ($dias <= 3) {
                            $atrasado = 'Tarea_terminada_';
                        }
                    }
                    ?>
                    <td data-titulo="Titulo"><?php echo $data["titulo_tarea"] ?></td>
                    <td data-titulo="Descripcion"><?php echo $data["descripcion"] ?></td>
                    <td data-titulo="Estado"><?php echo $data['estado'] ?></td>
                    <?php if ($data['estado'] == 'En Progreso') {
                        if ($atrasado == 'Tarea_terminada') {
                            echo '<td data-titulo="Progreso" style="color: green;">Queda(n) ', $meses, ' meses  y  ', $dias, ' dia(s)</td>';
                        }
                        if ($atrasado == 'Tarea_terminada_') {
                            echo '<td data-titulo="Progreso" style="color: yellow;">Queda(n) ', $meses, ' meses  y  ', $dias, ' dia(s)</td>';
                        }
                        if ($atrasado == 'Tarea_terminada_con_atraso') {
                            echo '<td data-titulo="Progreso" style="color: red;">Tarea Atrasada en Queda(n) ', $meses, ' meses  y  ', $dias, ' dia(s)</td>';
                        }
                    } ?>
                    <?php if ($data['estado'] == 'Terminado') {
                        echo '<td data-titulo="Estado">Terminado</td>';
                        echo '<td data-titulo="Progreso" style="color: green;">Tarea Terminada</td>';
                    } ?>
                    <td data-titulo="Fecha Inicio"><?php echo $data["fecha_inicio"] ?></td>
                    <td data-titulo="Fecha Termino"><?php echo $data["fecha_termino"] ?></td>
                    <td data-titulo="Plazo"><?php echo $data["plazo"] ?></td>
                    <td data-titulo="Acciones">
                        <a class="link_edit" href="editar_tarea.php?id=<?php echo $data["id_tareas"]; ?>">Editar</a>
                        <a class="link_delete" href="eliminar_tarea.php?id=<?php echo $data["id_tareas"]; ?>">Eliminar</a>
                        <br>
                        <?php if ($data['estado'] == 'En Progreso') {
                            echo '<a class="link_reasignar" href="reasignar_f.php?id=' . $data["id_tareas"] . '">Reasignar</a>';
                        }
                        ?>
                    </td>
                </tr>
        <?php
        }
    } else {
        echo '<div class="notasktext" style="display: block; 
            background-color: rgb(114, 114, 114);
            width: 300px;
            border: 15px solid rgb(94, 94, 94);
            padding: 50px;
            margin: auto; margin-top: 135px; margin-bottom: 135px">No tienes tareas asignadas</div>';
    }
        ?>
            </table>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <?php
            include "footer.php";
            ?>
</body>

</html>