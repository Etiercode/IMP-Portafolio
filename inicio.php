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
    <?php if ($_SESSION['rol'] == 3) { ?>
        <a href="todas_t_funcionario.php" style="margin-left: 45%; Color: green">Ver Todas las Tareas</a>
    <?php } ?>
    <h3 class="HeaderLista"><i class="fa-solid fa-list-check"></i> Tareas Asignadas a usted</h3>
    <br>
    <div style="overflow-x:auto;overflow-y:auto;max-height: 400px;">
        <?php
        $query = mysqli_query($conexion, "SELECT t.id_tareas,t.titulo_tarea,t.descripcion,t.estado,t.progreso,t.fecha_inicio,t.fecha_termino,t.plazo,l.id_usuario,l.nombreusuario,t.id_asignador FROM tareas t INNER JOIN login l on t.id_funcionario = l.id_usuario WHERE $_SESSION[id_usuario_log]=id_usuario AND estado = 'En Progreso'");

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
                            <a class="link_edit" href="editar_estado.php?id=<?php echo $data["id_tareas"]; ?>&progreso_tarea=<?php echo $atrasado ?>">Terminar Tarea</a>
                            <br>
                            <a class="link_reasignar" href="reportar_t.php?id=<?php echo $data["id_tareas"]; ?>&id_usuario_r=<?php echo $data["id_usuario"]; ?>&id_asignador_t=<?php echo $data["id_asignador"]; ?>">Reportar Tarea</a>
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
    </div>
    <hr>
    <br>
    <br>
    <br>
    <h3 class="HeaderLista"><i class="fa-sharp fa-solid fa-bars-progress"></i> Flujos Asignadas a usted </h3>
    <div style="overflow-x:auto;overflow-y:auto;max-height: 400px;">
        <?php
        $query_flujo = mysqli_query($conexion, "SELECT 	
        f.id_flujo,	
        f.id_funcionario_flujo,	
        f.id_creador_flujo,	
        f.titulo_flujo,	
        f.desc_flujo,	
        f.tareas_sin_f,
        tsf.titulo_tarea_r,
        f.estatus,
        l.nombreusuario,
        f.duracion_flujo
        FROM flujos_tarea f
        INNER JOIN login l
        ON id_funcionario_flujo=id_usuario
        INNER JOIN tareas_sin tsf
        ON id_tarea_sin=tareas_sin_f
        WHERE $_SESSION[id_usuario_log]=id_funcionario_flujo
        AND estatus=1");

        $validacion_f = mysqli_num_rows($query_flujo);
        if ($validacion_f > 0) {

            while ($data_f = mysqli_fetch_array($query_flujo)) {
        ?>
                <table>
                    <tr>
                        <th>Titulo Flujo</th>
                        <th>Descripción Flujo</th>
                        <th>Estatus</th>
                        <th>Tareas Asignadas al Flujo</th>
                        <th>Duracion Flujo</th>
                        <th>Acciones</th>
                    </tr>
                    <tr>
                        <td data-titulo="Titulo Flujo"><?php echo $data_f["titulo_flujo"] ?></td>
                        <td data-titulo="Descripcion Flujo"><?php echo $data_f["desc_flujo"] ?></td>
                        <?php
                        if ($data_f['estatus'] == 0) {
                            echo '<td data-titulo="Estatus" style="color: red;">' . 'Desactivado' . '</td>';
                        }
                        if ($data_f['estatus'] == 1) {
                            echo '<td data-titulo="Estatus" style="color: green;">' . 'Activado' . '</td>';
                        }
                        ?>
                        <td data-titulo="Tareas Asignadas">
                            <ul>
                                <?php foreach (explode(', ', $data_f['tareas_sin_f']) as $tareas_sin) {
                                    $query_titulo = mysqli_query($conexion, "SELECT titulo_tarea_r FROM tareas_sin WHERE id_tarea_sin=$tareas_sin");
                                    while ($row = $query_titulo->fetch_assoc()) {
                                        $titulo = $row['titulo_tarea_r'];
                                    }
                                    echo '<ul>
                                    <li>
                                        ' . $titulo . '
                                    </li>
                                 </ul>';
                                } ?>
                            </ul>
                        </td>
                        <td data-titulo="Duración Flujo"><?php echo $data_f["duracion_flujo"] ?> Dias</td>
                        <td data-titulo="Acciones">
                            <a class="link_edit" href="editar_estado_f.php?id_flujo=<?php echo $data_f["id_flujo"]; ?>&id_funcionario_flujo=<?php echo $data_f["id_funcionario_flujo"]; ?>&id_creador_flujo=<?php echo $data_f["id_creador_flujo"]; ?>&titulo_flujo=<?php echo $data_f['titulo_flujo'] ?>&estatus=0">Terminar Flujo</a>
                            <br>
                            <a class="link_reasignar" href="reportar_f.php?id_flujo=<?php echo $data_f["id_flujo"]; ?>&id_funcionario_flujo=<?php echo $data_f["id_funcionario_flujo"]; ?>&id_creador_flujo=<?php echo $data_f["id_creador_flujo"]; ?>">Mensaje de Reporte</a>
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
                    margin: auto; margin-top: 135px; margin-bottom: 135px">No tienes Flujos Asignados</div>';
        }
            ?>
                </table>
    </div>
    <hr>
    <br>
    <br>
    <h3 class="HeaderLista"><i class="fa-solid fa-list-check"></i> Tareas Generales</h3>
    <br>
    <div style="overflow-x:auto;overflow-y:auto;max-height: 400px;">
        <?php
        $query_sin = mysqli_query($conexion, "SELECT * FROM tareas_sin");

        $result = mysqli_num_rows($query_sin);
        if ($result > 0) {
            while ($data_sin = mysqli_fetch_array($query_sin)) {

        ?>
                <table>
                    <tr>
                        <th>Id Tarea</th>
                        <th>Id Asignador</th>
                        <th>Titulo Tarea</th>
                        <th>Descripción Tarea</th>
                        <th>Fecha Creación Tarea</th>
                        <th>Duración</th>
                        <?php
                        if ($_SESSION['id_usuario_log'] == $data_sin['id_asignador_r']) {
                            echo '<th>Acciones</th>';
                        }
                        ?>
                    </tr>
                    <tr>
                        <td data-titulo="Id Tarea"><?php echo $data_sin["id_tarea_sin"] ?></td>
                        <td data-titulo="Id Asignador"><?php echo $data_sin["id_asignador_r"] ?></td>
                        <td data-titulo="Titulo"><?php echo $data_sin["titulo_tarea_r"] ?></td>
                        <td data-titulo="Descripción"><?php echo $data_sin["descripcion_r"] ?></td>
                        <td data-titulo="Fecha Creacion"><?php echo $data_sin["fecha_creacion"] ?></td>
                        <td data-titulo="Duracion"><?php echo $data_sin["duracion_tarea"] ?></td>
                        <td data-titulo="Acciones">
                            <?php
                            if ($_SESSION['id_usuario_log'] == $data_sin['id_asignador_r']) {
                                echo '<a class="link_edit" href="editar_tarea_sin.php?id_tarea_sin=' . $data_sin['id_tarea_sin'] . '">Editar</a> <br>';
                                echo '<a class="link_delete" href="eliminar_tarea_sin.php?id_tarea_sin=' . $data_sin['id_tarea_sin'] . '">Eliminar</a>';
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
                            margin: auto; margin-top: 135px; margin-bottom: 135px">No Hay tareas</div>';
        }
            ?>
                </table>
    </div>
    <?php
    include "footer.php";
    ?>
</body>

</html>