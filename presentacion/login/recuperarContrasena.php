<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Codificación de caracteres utilizada en el documento -->
    <meta charset="utf-8">
    <!-- viewport para el diseño responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Título de la página que se visualiza en la pestaña desde el navegador -->
    <title>Recuperar Contraseña</title>
    <!-- links de estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/estilos_Registrar.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>

<body class="grid-container">
    <div class="row">
        <!--Menú de navegación-->
        <nav>
            <input type="checkbox" id="check">
            <label for="check" class="checkbtn"><i class="fas fa-bars"></i></label>
            <a href="#" class="enlace">
                <img src="../media/imagenes/logo.png" alt="" class="logo">
                <span>Parque Estatal "El Texcal"</span>
            </a>
            <ul>
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="login.php">Iniciar sesión</a></li>
            </ul>
        </nav>
    </div>
    <div class="row">
        <aside id="aside" class="col-xs-12 col-sm-12 col-md-12"></aside>
    </div>
    <div class="row">
        <section id="section" class="col-12 col-sm-12 col-md-12">
            <div class="col-11 col-sm-8 col-md-4 formulario">
                <!--Formulario para recuperar la contraseña, para esto el usuario debe de ingresar el correo 
                    con el que creo la cuenta -->
                <form action="../../logica/login/recuperarContrasena.php" method="post">
                    <h2 style="text-align: center">RECUPERAR CONTRASEÑA</h2>
                    <center><i class="fa-solid fa-unlock-keyhole user"></i></center>
                    <br>
                    <!--Se muestra el mensaje de éxito o de error según lo que envíe la capa lógica-->
                    <?php if (isset($_SESSION['status'])) {
                        if ($_SESSION['status'] == 'Revisa la bandeja de tu correo electrónico.') {
                    ?>
                            <div id="alerta" class="alert alert-success d-flex align-items-center" role="alert">
                                <?php echo $_SESSION['status']; ?>

                            </div><br>
                        <?php } else { ?>
                            <div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert">
                                <?php echo $_SESSION['status']; ?>
                            </div> <br>
                            <!--Se refresca la página 1 seg despúes-->
                    <?php }
                        header("refresh:1; url = ./recuperarContrasena.php");
                        unset($_SESSION['status']);
                    } ?><!--Se elimina la variable de sesión-->

                    <!--Correo electrónico con el cual se registró la cuenta-->
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id=""><i class="fa-solid fa-envelope icono"></i></span>
                        <input type="email" autocomplete="off" class="form-control" name="correo" placeholder="Correo electrónico" aria-label="Username" aria-describedby="addon-wrapping" required>
                    </div>

                    <!--Botón para recuperar la contraseña-->
                    <button class="btnRegistrar btn-lg" type="submit">Recuperar</button>
                </form>
            </div>

        </section>
    </div>
    <!--Footer de la página-->
    <div class="row">
        <footer>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 redes"> </div>
            </div>
            <div class="row">
                <!--Logo-->
                <div class="col-xs-12 col-sm-12 col-md-4 datos">
                    <div class="logo">
                        <div class="card-body">
                            <center><img src="../media/imagenes/logo.png" alt="" class="logoFooter"></center>
                            <p class="card-text" style="color:white; font-size:18px">© Derechos Reservados, Parque Estatal "El Texcal" 2022</p>

                        </div>
                    </div>
                </div>
                <!--Información de la ubicación-->
                <div class="col-xs-12 col-sm-12 col-md-4 datos2">
                    <div class="card-body ">
                        <p class="card-text" style="color:Yellow; font-size:20px;">DIRECCIÓN</p>
                        <p class="card-text" style="color:white; font-size:18px;">Av. El Texcal 62, Unidad Habitacional El Texcal, Jiutepec, Morelos, México. 62573</p>
                    </div>
                </div>
                <!--Enlaces de navegación-->
                <div class="col-xs-12 col-sm-12 col-md-4 datos3">
                    <div class="card-body ">
                        <p class="card-text" style="color:Yellow; font-size:20px;">NAVEGACIÓN</p>
                        <p class="card-text" style="color:white; font-size:18px;"><a class="link" href="login.php">- Iniciar Sesión</a></p>
                        <p class="card-text" style="color:white; font-size:18px;"><a class="link" href="registrar.php">- Registrarse</a></p>
                        <p class="card-text" style="color:white; font-size:18px;"><a class="link" href="../eventos.php">- Eventos</a></p>
                        <p class="card-text" style="color:white; font-size:18px;"><a class="link" href="../servicios/servicios.html">- Servicios</a></p>
                        <p class="card-text" style="color:white; font-size:18px;"><a class="link" href="../ubicacion.html">- Ubicación</a></p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!--Script de Bootrstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="../../logica/js/mostrarContra.js"></script> <!--Script para mostrar y ocultar la contraseña-->
</body>

</html>