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
include "../IMP/php/conexion_back.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMP | Flujos de Tarea</title>

    <!--Icono Pestaña-->
    <link rel="icon" href="img/IMPlogo.png" type="image" sizes="16x16">

    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!--FONT OSWALD-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">

    <!--CSS-->
    <link rel="stylesheet" href="css/flujos.css">

    <!--SweetAlert-->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>
    <script src="sweetalert2.min.js"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">

</head>

<body>
    <div class="menu-btn">
        <i class="fas fa-bars fa-2x"></i>
    </div>
    <style>
        /* Popup container */
        .popup {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }

        /* The actual popup (appears on top) */
        .popup .popuptext {
            visibility: hidden;
            width: 160px;
            background-color: #555;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 8px 0;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -80px;
        }

        /* Popup arrow */
        .popup .popuptext::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #555 transparent transparent transparent;
        }

        /* Toggle this class when clicking on the popup container (hide and show the popup) */
        .popup .show {
            visibility: visible;
            -webkit-animation: fadeIn 1s;
            animation: fadeIn 1s
        }

        /* Add animation (fade in the popup) */
        @-webkit-keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
    <?php
    include "header.php";
    ?>
    <br>
    <h2 class="HeaderLista">Bienvenido <?php echo $_SESSION['usuario'] ?></h2>
    <h2 class="HeaderLista">Todos los Flujos Creados</h2>
    <br>
    <?php
    $query = mysqli_query($conexion, "SELECT 	
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
    ON id_tarea_sin=tareas_sin_f");

    $result = mysqli_num_rows($query);
    if ($result > 0) {
        while ($data = mysqli_fetch_array($query)) {
    ?>
            <table>
                <tr>
                    <th>Id Flujo</th>
                    <th>Id Responsable</th>
                    <th>Responsable</th>
                    <th>Titulo</th>
                    <th>Descripcion</th>
                    <th>Estatus</th>
                    <th>Tareas Asignadas al Flujo</th>
                    <th>Duración</th>
                    <th>Acciones</th>
                </tr>
                <tr>
                    <td data-titulo="Id Flujo"><?php echo $data["id_flujo"] ?></td>
                    <td data-titulo="Id Funcionario"><?php echo $data["id_funcionario_flujo"] ?></td>
                    <td data-titulo="Nombre Usuario"><?php echo $data['nombreusuario'] ?></td>
                    <td data-titulo="Titulo Flujo"><?php echo $data["titulo_flujo"] ?></td>
                    <td data-titulo="Descripcion"><?php echo $data["desc_flujo"] ?></td>
                    <?php
                    if ($data['estatus'] == '1') {
                        echo '<td data-titulo="Estatus"><a style="color: green" href="editar_estatus.php?id_flujo=' . $data['id_flujo'] . '&estatus=0">Activado</a></td>';
                    }
                    if ($data['estatus'] == '0') {
                        echo '<td data-titulo="Estatus"><a style="color: red" href="editar_estatus.php?id_flujo=' . $data['id_flujo'] . '&estatus=1">Desactivado</a></td>';
                    }
                    ?></td>
                    <td data-titulo="Tareas Asignadas">
                        <?php foreach (explode(', ', $data['tareas_sin_f']) as $tareas_sin) {
                            $query_titulo = mysqli_query($conexion, "SELECT titulo_tarea_r FROM tareas_sin WHERE id_tarea_sin=$tareas_sin");
                            while ($row = $query_titulo->fetch_assoc()) {
                                $titulo = $row['titulo_tarea_r'];
                            }
                            echo '<ul>
                                    <li>
                                        '.$titulo.'
                                    </li>
                                 </ul>';
                        } ?>
                    </td>
                    <td data-titulo="Duración Flujo"><?php echo $data["duracion_flujo"] ?> Dias</td>
                    <td data-titulo="Acciones">
                        <a class="link_reasignar" href="reasignar_flujo.php?id_flujo=<?php echo $data["id_flujo"]; ?>&responsable_actual=<?php echo $data['nombreusuario'] ?>">Reasignar</a>
                        <br>
                        <a href="editar_flujo.php?id_flujo=<?php echo $data["id_flujo"]; ?>" style="color: rgb(4, 167, 4);">Editar</a>
                        <br>
                        <a class="link_delete" href="eliminar_flujo.php?id_flujo=<?php echo $data["id_flujo"]; ?>&titulo_flujo=<?php echo $data["titulo_flujo"]; ?>">Eliminar</a>
                        <br>
                        <a class="link_edit" href="reporte_f.php?id_flujo=<?php echo $data["id_flujo"]; ?>">Reporte</a>
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
        margin: auto; margin-top: 135px; margin-bottom: 135px">No hay flujos creados</div>';
    }
        ?>
            </table>
            <script>
                // When the user clicks on <div>, open the popup
                function myFunction() {
                    var popup = document.getElementById("myPopup");
                    popup.classList.toggle("show");
                }
            </script>
            <?php
            include "footer.php";
            ?>
</body>

</html>