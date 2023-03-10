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
include "../IMP/php/conexion_back.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMP | Usuarios</title>
    <!--Icono Pestaña-->
    <link rel="icon" href="img/IMPlogo.png" type="image" sizes="16x16">
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!--FONT OSWALD-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">

    <!--CSS-->
    <link rel="stylesheet" href="css/reportes.css">

</head>

<body>
    <div class="menu-btn">
        <i class="fas fa-bars fa-2x"></i>
    </div>
    <?php
    include "header.php";
    ?>
    <br>
    <h2 class="HeaderLista">Listado de Reportes</h2>
    <table>

        <?php
        $query = mysqli_query($conexion, "SELECT 	
        rf.id_reporte_f,
        rf.id_funcionario_f,
        rf.id_flujo_f,
        rf.id_asignador_f,
        rf.mensaje_f,
        l.nombreusuario,
        f.titulo_flujo
        FROM reportes_f rf 
        INNER JOIN flujos_tarea f
        ON id_flujo_f=id_flujo
        INNER JOIN login l
        ON id_funcionario_f=id_usuario
        WHERE $_SESSION[id_usuario_log]=id_asignador_f");

        $result = mysqli_num_rows($query);
        if ($result > 0) {
            while ($data = mysqli_fetch_array($query)) {

        ?>
                <tr>
                    <th>Nombre del Responsable</th>
                    <th>Id Flujo</th>
                    <th>Titulo Flujo</th>
                    <th>Mensaje</th>
                    <th>Acciones</th>
                </tr>
                <tr>
                    <td data-titulo="Id Usuario"><?php echo $data["nombreusuario"]; ?></td>
                    <td data-titulo="Id Flujo Asignada"><?php echo $data["id_flujo_f"]; ?></td>
                    <td data-titulo="Titulo Flujo"><?php echo $data["titulo_flujo"]; ?></td>
                    <td data-titulo="Nombre Usuario"><?php echo $data["mensaje_f"]; ?></td>
                    <td data-titulo="Acciones">
                        <a class="link_delete fa-solid fa-x" href="eliminar_rf.php?id=<?php echo $data["id_reporte_f"]; ?>"></a>
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
            margin: auto; margin-top: 135px; margin-bottom: 135px">No tienes reportes </div>';
        }
        ?>
    </table>


    <?php
    include "footer.php";
    ?>

</body>

</html>