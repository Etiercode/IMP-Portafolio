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

if ($_SESSION['rol'] == 2) {
    echo '
    <script>
        alert("Debes iniciar sesión con un rol diferente");
        window.location = "inicio.php";
    </script>';
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
    <link rel="stylesheet" href="css/tareas1.css">
    <title>IMP | Agregar Tareas</title>
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
        <h2>Agregar Tareas</h2>
        <h3>Usted está agregando tareas como <?php echo $_SESSION['usuario'] ?></h3>
        <p><a href="tareas_sin.php" style="color: red;">Agregar Tareas Sin Responsable</a></p>
        <form action="php/registro_tarea_back.php" method="POST" class="formulario_registro">
            <input type="hidden" value="<?php echo $_SESSION['id_usuario_log'] ?>" name="id_asignador">
            <label>Asignar Funcionario</label>
            <select name="id_funcionario">
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
            <label>Titulo Tarea</label>
            <input type="text" placeholder="Titulo" name="titulo_tarea">
            <label>Descripción de la tarea a realizar</label>
            <input type="text" placeholder="Descripción" name="descripcion">
            <label>Estado</label>
            <select name="estado" class="estado">
                <option type="text" placeholder="Estado" name="estado">En Progreso</option>
            </select>
            <label>Progreso</label>
            <select name="progreso" class="progreso">
                <option type="text" placeholder="progreso" name="progreso">En Progreso</option>
            </select>
            <div class="row">
                <div class="col">
                    <label style="padding-right: 30px;">Fecha Inicio</label>
                    <input type="date" name="fecha_inicio">
                </div>
                <div class="col">
                    <label style="padding-right: 15px;">Fecha Termino</label>
                    <input type="date" name="fecha_termino">
                </div>
            </div>
            <button class="btn" style="margin-top: 15px;">Crear Tarea</button>
        </form>
    </div>
    <?php
    include "footer.php";
    ?>
</body>

</html>