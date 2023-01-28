<?php
//Se inicia sesión parahacer uso de las variables de sesión
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
    <title>Registrar</title>
    <!-- links de estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous"><!--Estilos en línea de Bootstrap-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> <!--Enlace para hacer uso de los iconos de font awesome -->
    <link rel="stylesheet" href="../css/estilos_Registrar.css"> <!-- EStilos de la pagína -->
    <link rel="stylesheet" href="../css/bootstrap.min.css"> <!--Estilos de Bootstrap -->
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
                <li><a href="../../index.php">Inicio</a></li>
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
                <!--Formulario para el registro de usuarios de tipo visitante -->
                <form action="../../logica/login/registrar.php" method="post">
                    <h2 style="text-align: center">REGISTRARSE</h2>
                    <center><i class="fa-solid fa-circle-user user"></i></center>
                    <!--Se muestra el mensaje de éxito o de error según lo que envíe la capa lógica-->
                    <?php if (isset($_SESSION['status'])) {
                        if ($_SESSION['status'] == 'Registrado con éxito.') {
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
                        header("refresh:1; url = ./registrar.php");
                        unset($_SESSION['status']);
                    } ?><!--Se elimina la variable de sesión-->

                    <!--Nombre del visitante-->
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text span" id=""><i class="fa-solid fa-user icono"></i></span>
                        <input type="text" autocomplete="off" class="form-control" name="nombre" placeholder="Nombre" aria-label="Username" aria-describedby="addon-wrapping" required>
                    </div>
                    <!--Apellido Paterno del visitante-->
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id=""><i class="fa-solid fa-user icono"></i></span>
                        <input type="text" autocomplete="off" class="form-control" name="apPaterno" placeholder="Apellido Paterno" aria-label="Username" aria-describedby="addon-wrapping" required>
                    </div>
                    <!--Apellido Materno del visitante-->
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id=""><i class="fa-solid fa-user icono"></i></span>
                        <input type="text" autocomplete="off" class="form-control" name="apMaterno" placeholder="Apellido Materno" aria-label="Username" aria-describedby="addon-wrapping">
                    </div>
                    <!--Email del visitante-->
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id=""><i class="fa-solid fa-envelope icono"></i></span>
                        <input type="email" autocomplete="off" class="form-control" name="correo" placeholder="Correo electrónico" aria-label="Username" aria-describedby="addon-wrapping" required>
                    </div>
                    <!--Contraseña del visitante-->
                    <?php
                    //Se crea una variable con todos los signos y caracteres que se pueden permitir para la generación de 
                    //la contraseña
                    $combinacion = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890./*$';
                    //Se crea un array en el que se almacenará la contraseña aleatoria
                    $pass = array();
                    //Se almacena el número de bytes que ocupa la variable combinación
                    $combLen = strlen($combinacion) - 1;
                    //Se crea un ciclo para generar la contraseña de 10 dígitos
                    for ($i = 0; $i < 10; $i++) {
                        //Se obtiene una posición aleatoria
                        $n = rand(0, $combLen);
                        //Se almacena el carater o singo que se obtuvo de la posición
                        $pass[] = $combinacion[$n];
                    }
                    ?>
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id=""><i class="fa-solid fa-lock icono"></i></span>
                        <input type="password" id="password" autocomplete="off" value="<?php print(implode($pass)); ?>" class="form-control" name="contra" placeholder="Contraseña" aria-label="Username" aria-describedby="addon-wrapping" required>
                        <button class="btnMostrarContra" type="button" onclick="mostrarContrasena()"><i id="icono" class="fa-solid fa-eye icono"></i></button>
                    </div>
                    <!--Botón para registrar el nuevo visitante-->
                    <button class="btnRegistrar btn-lg" type="submit">Registrar</button>
                </form>
            </div>

        </section>
    </div>
    <!--Footer de la página-->
    <div class="row">
        <footer>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 redes">

                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 datos">
                    <!--Logo-->
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
                        <p class="card-text" style="color:white; font-size:18px;"><a class="link" href="../eventos.php">- Eventos</a></p>
                        <p class="card-text" style="color:white; font-size:18px;"><a class="link" href="../servicios/servicios.html">- Servicios</a></p>
                        <p class="card-text" style="color:white; font-size:18px;"><a class="link" href="../ubicacion.html">- Ubicación</a></p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!--Scripts-->
    <script src="../../logica/js/mostrarContra.js"></script> <!--Script para mostrar y ocultar la contraseña-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="../../logica/js/bootstrap.bundle.min.js"></script><!--Script de Bootrstrap-->
</body>

</html>