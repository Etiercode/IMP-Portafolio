<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMP | Login</title>

    <!--Icono Pestaña-->
    <link rel="icon" href="../img/IMPlogo.png" type="image" sizes="16x16">

    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!--FONT OSWALD-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">

    <!--CSS-->
    <link rel="stylesheet" href="../css/estiloLogin.css">
</head>

<body>

    <main>
        <div class="contenedor__todo">
            <div class="caja__trasera">
                <div class="cajaTrasera__login">
                </div>
            </div>
            <div class="contenedorLogin">
                <form action="../php/login_usuario_back.php" method="POST" class="formularioLogin">

                    <h2>Iniciar sesión</h2>
                    <input type="text" placeholder="Nombre de usuario" name="nombreusuario">
                    <input type="password" placeholder="Contraseña" name="clave">
                    <button>Entrar</button>

                </form>
            </div>
        </div>
    </main>

</body>

</html>