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
    <link rel="stylesheet" href="css/usuarios.css">

</head>

<body>
    <div class="menu-btn">
        <i class="fas fa-bars fa-2x"></i>
    </div>
    <?php
    include "header.php";
    ?>
    <br>
    <h2 class="HeaderLista">Listado de Usuarios</h2>
    <table>
        <tr>
            <th>Id Usuario</th>
            <th>Usuario</th>
            <th>Nombre de Usuario</th>
            <th>Clave</th>
            <th>Rol</th>
            <th>Sexo</th>
            <th>Correo</th>
            <th>Número Telefónico</th>
            <th>Dirección</th>
            <th>Acciones</th>
        </tr>
        <?php
        $query = mysqli_query($conexion, "SELECT l.id_usuario, l.usuario, l.nombreusuario, l.clave, l.rol, l.correo, l.sexo,l.numero_telef,l.direccion
        FROM login l 
        INNER JOIN roles r on l.rol = r.id_rol");

        $result = mysqli_num_rows($query);
        if ($result > 0) {
            while ($data = mysqli_fetch_array($query)) {
        ?>
                <tr>
                    <td data-titulo="Id Usuario"><?php echo $data["id_usuario"]; ?></td>
                    <td data-titulo="Usuario"><?php echo $data["usuario"]; ?></td>
                    <td data-titulo="Nombre Usuario"><?php echo $data["nombreusuario"]; ?></td>
                    <td data-titulo="Clave"><?php echo $data["clave"]; ?></td>
                    <?php
                    if ($data["rol"] == 1) {
                        echo '<td data-titulo="Rol">Administrador</td>';
                    }
                    if ($data["rol"] == 2) {
                        echo '<td data-titulo="Rol">Diseñador de Procesos</td>';
                    }
                    if ($data["rol"] == 3) {
                        echo '<td data-titulo="Rol">Funcionario</td>';
                    }
                    ?>
                    <td data-titulo="Sexo"><?php echo $data["sexo"]; ?></td>
                    <td data-titulo="Correo"><?php echo $data["correo"]; ?></td>
                    <td data-titulo="Numero Telefonico"><?php echo $data["numero_telef"]; ?></td>
                    <td data-titulo="Dirección"><?php echo $data["direccion"]; ?></td>
                    <td data-titulo="Acciones">
                        <a class="link_edit" href="editar_u.php?id=<?php echo $data["id_usuario"]; ?>">Editar</a>
                        <a class="link_delete" href="eliminar_usuarios.php?id=<?php echo $data["id_usuario"]; ?>">Eliminar</a>
                    </td>
                </tr>
        <?php
            }
        } else {
            
        }
        ?>
    </table>
    <?php
    include "footer.php";
    ?>
</body>

</html>