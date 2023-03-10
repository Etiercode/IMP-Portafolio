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
include "php/conexion_back.php";
$usuario_log = $_SESSION['id_usuario_log'];
?>
<?php
$fechaactual = date_default_timezone_set("America/Santiago");
$fecha_actual = new DateTime(date("d-m-Y"));
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
    <link rel="stylesheet" href="css/flujosdetareas.css">
    <title>IMP | Crear Flujos de Tareas</title>

    <!--JS-->
    <script src="js/showPlazo.js"></script>

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
        <h2>Crear Flujos de Tareas</h2>
        <h3>Usted está creando flujos de tareas como <?php echo $_SESSION['usuario'] ?></h3>
        <form action="php/flujo_tarea_back.php" method="POST" class="formulario_registro">
            <input type="hidden" value="<?php echo $usuario_log ?>" name="usuario_log">
            <label>Asignar Funcionario <span style="color: red;">*</span></label>
            <select name="id_funcionario_flujo">
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
            <label>Titulo Flujo de Tareas <span style="color: red;">*</span></label>
            <input type="text" placeholder="Titulo Flujo de Tareas" name="titulo_flujo">
            <label>Descripción del Flujo <span style="color: red;">*</span></label>
            <input type="text" placeholder="Descripción del Flujo" name="desc_flujo">

            <label>Seleccione las Tareas que se incluirán dentro del flujo<span style="color: red;">*</span></label>
            <br>
            <br>
            <?php 
                $query_checkbox = mysqli_query($conexion, "SELECT * FROM tareas_sin");
                $result_checkbox = mysqli_num_rows($query_checkbox);
                if($result_checkbox > 0){
                    while($data_checkbox = mysqli_fetch_array($query_checkbox)){
                        echo '
                        <label class="checkbox-inline" style="padding-right: 7px; padding-left: 7px;border-right:1px solid gray;">
                            <input type="checkbox" value="'.$data_checkbox['id_tarea_sin'].'" name="tarea[]">'.$data_checkbox['titulo_tarea_r'].'
                        </label>
                        ';
                    }
                }else{
                    echo '<br> No hay tareas creadas para seleccionar <br> <br>' ;
                }
            ?>
            <br>
            <br>
            <button class="btn" style="margin-top: 15px;" type="submit">Crear Flujo</button>
        </form>
    </div>

    <?php
    include "footer.php";
    ?>
</body>

</html>