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
if ($_SESSION['rol'] == 3) {
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
        alert("Id de usuario no existe");
    </script>';
    header('location: Usuarios.php');
}
$id_usuario = $_GET['id'];

$sql = mysqli_query($conexion, "SELECT l.id_usuario, l.usuario, l.nombreusuario, l.clave, l.rol, l.correo, l.sexo,l.numero_telef,l.direccion,r.id_rol, r.rol 
FROM login l 
INNER JOIN roles r on l.rol = r.id_rol 
WHERE id_usuario=$id_usuario");

$result_sql = mysqli_num_rows($sql);

if ($result_sql == 0) {
    echo '
    <script>
        alert("Usuario no existe");
        window.location = "Usuarios.php";
    </script>
    ';
    header('location: Usuarios.php');
} else {
    while ($data = mysqli_fetch_array($sql)) {
        $option = '';
        $id_usuario = $data['id_usuario'];
        $usuario = $data['usuario'];
        $nombreusuario = $data['nombreusuario'];
        $clave = $data['clave'];
        $id_rol = $data['id_rol'];
        $rol = $data['rol'];
        $correo = $data['correo'];
        $sexo = $data['sexo'];
        $numero_telef = $data['numero_telef'];
        $direccion = $data['direccion'];

        if ($id_rol == 1) {
            $option = '<option value="' . $id_rol . '" select>' . $rol . '</option>';
        } else if ($id_rol == 2) {
            $option = '<option value="' . $id_rol . '" select>' . $rol . '</option>';
        } else if ($id_rol == 3) {
            $option = '<option value="' . $id_rol . '" select>' . $rol . '</option>';
        }
    }
}

?>
<?php

if (!empty($_POST)) {
    $alert = '';
    if (empty($_POST['usuario']) || empty($_POST['nombreusuario']) || empty($_POST['clave']) || empty($_POST['correo']) || empty($_POST['numero_telef']) || empty($_POST['direccion'])) {
        echo '
        <script>
            alert("Todos los campos son obligatorios");
            header("Refresh:0");
        </script>';
    } else {
        $idUsuario = $_POST['idUsuario'];
        $usuario = $_POST['usuario'];
        $nombreusuario = $_POST['nombreusuario'];
        $clave = $_POST['clave'];
        $rol = $_POST['rol'];
        $correo = $_POST['correo'];
        $sexo = $_POST['sexo'];
        $numero_telef = $_POST['numero_telef'];
        $direccion = $_POST['direccion'];

        $sql_update = mysqli_query($conexion, "UPDATE login SET usuario='$usuario', nombreusuario='$nombreusuario', clave='$clave', rol='$rol', correo='$correo', sexo='$sexo', direccion='$direccion', numero_telef='$numero_telef'
            WHERE id_usuario='$idUsuario'");

        if ($sql_update) {
            echo '
            <script>
                alert("Usuario Actualizado Correctamente");
                window.location = "Usuarios.php";
            </script>';
        } else {
            echo '
            <script>
                alert("Error al actualizar usuario");
                window.location = "Usuarios.php";
            </script>';
        }
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
        <h2>Editar Usuarios</h2>
        <h3>Usted está Editando Usuarios</h3>
        <div class="Registro_Usuario">
            <form action="" method="POST" class="formulario_registro">
                <input type="hidden" name="idUsuario" value="<?php echo $id_usuario ?>">
                <label>Usuario</label>
                <input type="text" placeholder="Nuevo Usuario" name="usuario" value="<?php echo $usuario ?>">
                <label>Nombre del Usuario</label>
                <input type="text" placeholder="" name="nombreusuario" value="<?php echo $nombreusuario ?>">
                <label>Clave</label>
                <input type="text" placeholder="Nueva Clave" name="clave" value="<?php echo $clave ?>">
                <?php
                $query_rol = mysqli_query($conexion, "SELECT * FROM roles");
                $result_rol = mysqli_num_rows($query_rol);
                ?>
                <label>Rol</label>
                <select name="rol" id="rol" class="notItemOne">
                    <?php
                    echo $option;
                    if ($result_rol > 0) {
                        while ($roles = mysqli_fetch_array($query_rol)) {
                    ?>
                            <option value="<?php echo $roles["id_rol"]; ?>"><?php echo $roles["rol"]; ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
                <label>Correo</label>
                <input type="text" placeholder="Correo" name="correo" value="<?php echo $correo ?>">
                <label>Sexo</label>
                <select name="sexo" class="sexo">
                    <option type="text" placeholder="Sexo" name="sexo">M</option>
                    <option type="text" placeholder="Sexo" name="sexo">F</option>
                </select>
                <label>Numero de Teléfono</label>
                <input type="text" placeholder="Numero de Telefono" name="numero_telef" value="<?php echo $numero_telef ?>">
                <label>Dirección</label>
                <input type="text" placeholder="Dirección" name="direccion" value="<?php echo $direccion ?>">
                <button class="btn" type="submit">Actualizar</button>
            </form>
        </div>
    </div>

    <?php
    include "footer.php";
    ?>
</body>

</html>