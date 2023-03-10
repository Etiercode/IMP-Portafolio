<div class:="container">
    <nav class="nav-main">
        <img src="img/IMPlogo.png" alt="Imp Logo" class="nav-brand">
        <ul class="nav-menu">
            <li>
                <i class="fa-solid fa-inbox"></i>
                &nbsp;&nbsp;
                <a href="inicio.php">Inicio</a>
            </li>
            <?php if ($_SESSION['rol'] == 1) { ?>
                <li>
                    <i class="fa-sharp fa-solid fa-user"></i>
                    &nbsp;&nbsp;
                    <a href="Usuarios.php">Usuarios</a>
                </li>
            <?php } ?>
            <?php if ($_SESSION['rol'] == 3) { ?>
                <li>
                    <i class="fa-sharp fa-solid fa-calendar-days"></i>
                    &nbsp;&nbsp;
                    <a href="Tareas.php">Crear Tareas</a>
                </li>
            <?php } ?>
            <?php if ($_SESSION['rol'] == 1) { ?>
                <li>
                    <i class="fa-sharp fa-solid fa-calendar-days"></i>
                    &nbsp;&nbsp;
                    <a href="Tareas.php">Crear Tareas</a>
                </li>
            <?php } ?>
            <?php if ($_SESSION['rol'] == 2) { ?>
                <li>
                    <i class="fa-sharp fa-solid fa-calendar-days"></i>
                    &nbsp;&nbsp;
                    <a href="flujosdetareas.php">Crear Flujos</i></a>
                </li>
            <?php } ?>
            <?php if ($_SESSION['rol'] == 1) { ?>
                <li>
                    <i class="fa-sharp fa-solid fa-calendar-days"></i>
                    &nbsp;&nbsp;
                    <a href="flujosdetareas.php">Crear Flujos</i></a>
                </li>
            <?php } ?>
            <?php if ($_SESSION['rol'] == 1) { ?>
                <li>
                    <i class="fa-sharp fa-solid fa-calendar-days"></i>
                    &nbsp;&nbsp;
                    <a href="Flujos_tarea.php">Ver Flujos</a>
                </li>
            <?php } ?>
            <?php if ($_SESSION['rol'] == 2) { ?>
                <li>
                    <i class="fa-sharp fa-solid fa-calendar-days"></i>
                    &nbsp;&nbsp;
                    <a href="Flujos_tarea.php">Ver Flujos</a>
                </li>
            <?php } ?>
            <?php if ($_SESSION['rol'] == 1) { ?>
                <li>
                    <i class="fa-sharp fa-solid fa-user"></i>
                    &nbsp;&nbsp;
                    <a href="agregar_usuario.php">Agregar Usuarios</i></a>
                </li>
            <?php } ?>
            <li>
                <i class="fa-solid fa-circle-user"></i>
                &nbsp;&nbsp;
                <a href="php/cerrar_sesion.php">Cerrar Sesión</a>
            </li>
            <li>
                <?php if ($_SESSION['rol'] == 3 || $_SESSION['rol'] == 1) { ?>
                    <a href="reportes.php">
                        <i class="fa fa-bell"></i>
                        <span class="">
                            <?php
                            $query_count = mysqli_query($conexion, "SELECT COUNT(id_reporte)AS cantidad_reportes, id_asignador_t FROM reportes WHERE $_SESSION[id_usuario_log]=id_asignador_t");
                            $resultado_count = mysqli_num_rows($query_count);
                            if ($resultado_count > 0) {
                                $data = mysqli_fetch_array($query_count);
                                echo $data['cantidad_reportes'];
                            }
                            ?>
                        </span>
                    </a>
                <?php } ?>
                <?php if ($_SESSION['rol'] == 2 || $_SESSION['rol'] == 1) { ?>
                    <a href="reportes_f.php">
                        <i class="fa-sharp fa-solid fa-list-check"></i>
                        <span class="">
                            <?php
                            $query_count_f = mysqli_query($conexion, "SELECT COUNT(id_reporte_f)AS cantidad_reportes_f, id_asignador_f FROM reportes_f WHERE $_SESSION[id_usuario_log]=id_asignador_f");
                            $resultado_count_f = mysqli_num_rows($query_count_f);
                            if ($resultado_count_f > 0) {
                                $data_f = mysqli_fetch_array($query_count_f);
                                echo $data_f['cantidad_reportes_f'];
                            }
                            ?>
                        </span>
                    </a>
                <?php } ?>
                &nbsp;&nbsp;
                <a href=""><?php echo $_SESSION['usuario'] ?></a>
            </li>
        </ul>
    </nav>
</div>