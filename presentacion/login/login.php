<?php
session_start(); //Se inicia la sesión.
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Codificación de caracteres utilizada en el documento -->
    <meta charset="UTF-8">
    <!-- viewport para el diseño responsive -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- viewport para el diseño responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Título de la página que se visualiza en la pestaña desde el navegador -->
    <title>Inicio de sesión</title>
    <!-- links de estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/estilos_Login.css"> <!--Estilos de la página-->
    <link rel="stylesheet" href="../css/bootstrap.min.css"> <!--Estilos de Bootstrap-->
</head>

<body>
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
                <li><a href="../../index.php">Inicio</a></li>
                <li><a href="registrar.php">Registrarse</a></li>
            </ul>
        </nav>
    </div>
    <div class="row">
        <aside id="aside" class="col-12 col-sm-12 col-md-12"></aside>
    </div>
    <div class="row">
        <section id="section" class="col-12 col-sm-12 col-md-12">
            <div class="col-11 col-sm-8 col-md-4 formulario">
                <!--Formulario para iniciar sesión-->
                <form action="../../logica/login/login.php" method="post">
                    <h2 style="text-align: center"></i>INICIAR SESIÓN</h2>
                    <center><i class="fa-solid fa-circle-user user"></i></center>
                    <!--Se muestra el mensaje de éxito o de error, dependiendo de lo que envie la capa lógica-->
                    <?php if (isset($_SESSION['status'])) {
                        if ($_SESSION['status'] == 'Tarifa registrada con éxito.') {
                    ?>
                            <div id="alerta" class="alert alert-success d-flex align-items-center" role="alert">
                                <?php echo $_SESSION['status']; ?>
                            </div>
                        <?php } else { ?>
                            <div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert">
                                <?php echo $_SESSION['status']; ?>
                            </div>
                            <!--Se refresca la página un seg despúes-->
                    <?php }
                        header("refresh:1; url = ./login.php");
                        unset($_SESSION['status']);
                    } ?><!--Se elimina la variable de sesión-->

                    <!--Correo electrónico del usuario-->
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="">
                            <i class="fa-solid fa-envelope icono"></i>
                        </span>
                        <input type="email" autocomplete="off" class="form-control" name="correo" placeholder="Correo electrónico" aria-label="Username" aria-describedby="addon-wrapping" required>
                    </div>

                    <!--Contraseña del usuario-->
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id=""><i class="fa-solid fa-lock icono"></i></span>
                        <input type="password" id="password" autocomplete="off" class="form-control" name="contra" placeholder="Contraseña" aria-label="Username" aria-describedby="addon-wrapping" required>
                        <button class="btnMostrarContra" type="button" onclick="mostrarContrasena()"><i id="icono" class="fa-solid fa-eye icono"></i></button>
                    </div>

                    <!--Botón para iniciar sesión con los datos ingresados-->
                    <button class="btnEntrar btn-lg" type="submit">Entrar</button>
                    <br><br>

                    <!--Enlace para realizar el proceso de recuperación de usuario y contraseña-->
                    <center>
                        <p><a href="recuperarContrasena.php" class="linkForm">¿Olvidaste tu contraseña?</a></p>
                    </center>
                </form>
            </div>
        </section>
    </div>
    <div class="row">
        <!--Footer de la página-->
        <footer>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 redes"></div>
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
                        <p class="card-text" style="color:white; font-size:18px;"><a class="link" href="registrar.php">- Registrarse</a></p>
                        <p class="card-text" style="color:white; font-size:18px;"><a class="link" href="../eventos.php">- Eventos</a></p>
                        <p class="card-text" style="color:white; font-size:18px;"><a class="link" href="../servicios/servicios.html">- Servicios</a></p>
                        <p class="card-text" style="color:white; font-size:18px;"><a class="link" href="../ubicacion.html">- Ubicación</a></p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
<!--Scripts-->
<script src="../../logica/js/mostrarContra.js"></script> <!--Script para mostrar y ocultar la contraseña-->

</html>