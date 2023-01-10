<?php
    session_start();//Se inicia la sesión.
    //Se verifica que exista la variable de sesión para que el usuario pueda acceder al menú.
    if(isset($_GET['id'])){
        //Se obtiene el id del usuario que fue enviado por el método GET
        $id = htmlentities($_GET['id']);
    }else{
        //En caso de que no se encuentre la variable de sesión se redirige al inicio de sesión.
        header("Location: login.php");
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Recuperar Contraseña</title> <!--Titulo de la página-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
        <link rel="stylesheet" href="../css/estilos_Registrar.css"><!--Estilos de la página-->
        <link rel="stylesheet" href="../css/bootstrap.min.css"><!--Estilos de Bootstrap-->
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
            <section id="section"  class="col-xs-12 col-sm-12 col-md-12">
                <div class="col-xs-12 col-sm-8 col-md-4 formulario">
                    <!--Formulario para crear la nueva contraseña-->
                    <form action="../../logica/login/nuevaContrasena.php" method="post"> 
                        <h2  style="text-align: center">NUEVA CONTRASEÑA</h2>
                        <center><i class="fa-solid fa-unlock-keyhole user"></i></center>
                        <br>
                        <!--Se muestra el mensaje de éxito o de error, dependiendo de lo que envie la capa lógica-->
                        <?php if(isset($_SESSION['status'])){ 
                          if($_SESSION['status']=='Cambio exitoso, revisa la bandeja de tu correo electrónico.'){
                        ?>
                        <div id="alerta" class="alert alert-success d-flex align-items-center" role="alert">
                          <?php echo $_SESSION['status']; ?>
                          
                        </div><br>  
                        <?php }else{?> 
                        <div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert">
                          <?php echo $_SESSION['status']; ?>
                        
                        </div> <br>   
                        <!--Se refresca la página un seg despúes-->    
                        <?php } header("refresh:1; url = ./nuevaContrasena.php?id=$id");unset($_SESSION['status']); } ?><!--Se elimina la variable de sesión-->
                       
                        <!--Id del usuario-->
                        <input type="hidden" value="<?php echo $id;?>" name="id">

                        <!--Contraseña nueva del usuario-->
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id=""><i class="fa-solid fa-lock icono"></i></span>
                            <input type="password" id="password" autocomplete="off" value="" class="form-control" name="contra" placeholder="Nueva contraseña" aria-label="Username" aria-describedby="addon-wrapping" required>
                            <button class="btnMostrarContra" type="button" onclick="mostrarContrasena()"><i id="icono" class="fa-solid fa-eye icono"></i></button>
                        </div>
                        <!--Contraseña nueva de confirmación del usuario-->
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id=""><i class="fa-solid fa-lock icono"></i></span>
                            <input type="password" id="password2" autocomplete="off" value="" class="form-control" name="confirmarContra" placeholder="Confirmar contraseña" aria-label="Username" aria-describedby="addon-wrapping" required>
                            <button class="btnMostrarContra" type="button" onclick="mostrarConfirContrasena()"><i id="icono2" class="fa-solid fa-eye icono"></i></button>
                        </div>
                       
                        <!--Botón para cambiar la contraseña-->
                        <button class="btnRegistrar btn-lg" type="submit">Cambiar contraseña</button>
                    </form>       
                </div>
            </section>  
        </div>
        <div class="row">
            <!--Footer de la página que contiene el logo, información del parque y enlaces de navegación-->
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
                            <p class="card-text" style="color:white; font-size:18px;"><a class="link" href="login.php">- IniciarSesión</a></p>
                            <p class="card-text" style="color:white; font-size:18px;"><a class="link" href="registrar.php">- Registrarse</a></p>
                            <p class="card-text" style="color:white; font-size:18px;"><a class="link" href="../eventos.php">- Eventos</a></p>
                            <p class="card-text" style="color:white; font-size:18px;"><a class="link" href="../servicios/servicios.html">- Servicios</a></p>
                            <p class="card-text" style="color:white; font-size:18px;"><a class="link" href="../ubicacion.html">- Ubicación</a></p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!--Scripts-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
        <script src="js/bootstrap.bundle.min.js"></script><!--Script de Bootrstrap-->
        <script src="../../logica/js/mostrarContra.js"></script><!--Script para mostrar y ocultar la contraseña-->
        <script src="../../logica/js/mostrarConfirmarContra.js"></script><!--Script para mostrar y ocultar la confirmación de la contraseña-->
    </body>
    
</html>