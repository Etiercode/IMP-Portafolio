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
    <!--Icono Pestaña-->
    <link rel="icon" href="img/IMPlogo.png" type="image" sizes="16x16">

    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!--FONT OSWALD-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
    <!--CSS-->
    <link rel="stylesheet" href="css/agregarU.css">
    <title>IMP | Agregar Usuarios</title>
</head>

<body>
    <div class="menu-btn">
        <i class="fas fa-bars fa-2x"></i>
    </div>
    <?php
    include "header.php";
    ?>
    <br>
    <div class="showcase">
        <h2>Agregar Usuarios</h2>
        <h3>Usted está agregando Usuarios como <?php echo $_SESSION['usuario'] ?></h3>
        <div class="error"></div>
        <form action="php/registro_usuario_back.php" method="POST" class="formulario_registro">
            <input type="text" placeholder="Usuario" name="usuario">
            <input type="text" placeholder="Nombre de usuario" name="nombreusuario">
            <input type="text" placeholder="Clave" name="clave">
            <input type="text" placeholder="Correo" name="correo">
            <select name="rol" class="rol">
                <option value="1">Administrador</option>
                <option value="2">Diseñador de Procesos</option>
                <option value="3">Funcionario</option>
            </select>
            <select name="sexo" class="sexo">
                <option type="text" placeholder="Sexo" name="sexo">M</option>
                <option type="text" placeholder="Sexo" name="sexo">F</option>
            </select>
            <input type="text" placeholder="Numero de Telefono" name="numero_telef">
            <input type="text" placeholder="Dirección" name="direccion">
            <button class="btn" type="submit">Agregar</button>
        </form>
    </div>

    <?php
    include "footer.php";
    ?>
</body>

</html>