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
date_default_timezone_set("America/Santiago");
$fechaactual = getdate();
$fecha_now = date("Y-m-d");

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

    <!--Libs-->

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
    <!--CSS-->
    <link rel="stylesheet" href="css/tareas_sin.css">

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
        <p><a href="Tareas.php" style="color: red;">Agregar Tarea con Responsable</a></p>
    </div>
    <div class="container">
        <div class="row">
            <form action="php/registro_tarea_sin.php" method="POST" class="formulario_registro">
                <input type="hidden" value="<?php echo $_SESSION['id_usuario_log'] ?>" name="id_asignador_r">
                <label>Titulo Tarea</label>
                <input type="text" placeholder="Titulo" name="titulo_tarea_r">
                <label>Descripción de la tarea a realizar</label>
                <input type="text" placeholder="Descripción" name="descripcion_r">
                <div>
                    <div>
                        <input type="hidden" name="fecha_creacion" value="<?php echo $fecha_now ?>">
                    </div>
                    <div>
                        <label style="padding-right: 15px;">Duración de la Tarea (Dias)</label>
                        <select name="duracion_tarea">
                            <option value='01'>01</option>
                            <option value='02'>02</option>
                            <option value='03'>03</option>
                            <option value='04'>04</option>
                            <option value='05'>05</option>
                            <option value='06'>06</option>
                            <option value='07'>07</option>
                            <option value='08'>08</option>
                            <option value='09'>09</option>
                            <option value='10'>10</option>
                            <option value='11'>11</option>
                            <option value='12'>12</option>
                            <option value='13'>13</option>
                            <option value='14'>14</option>
                            <option value='15'>15</option>
                            <option value='16'>16</option>
                            <option value='17'>17</option>
                            <option value='18'>18</option>
                            <option value='19'>19</option>
                            <option value='20'>20</option>
                            <option value='21'>21</option>
                            <option value='22'>22</option>
                            <option value='23'>23</option>
                            <option value='24'>24</option>
                            <option value='25'>25</option>
                            <option value='26'>26</option>
                            <option value='27'>27</option>
                            <option value='28'>28</option>
                            <option value='29'>29</option>
                            <option value='30'>30</option>
                            <option value='31'>31</option>
                        </select>
                    </div>
                </div>
                <button class="btn" style="margin-top: 15px;">Crear Tarea</button>
                <br>
                <br>
            </form>
<br>
<br>
<br>


        </div>
    </div>

    <?php
    include "footer.php";
    ?>
</body>

</html>