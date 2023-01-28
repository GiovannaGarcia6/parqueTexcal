<?php

$id = htmlentities($_GET['id']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Codificación de caracteres utilizada en el documento -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- viewport para el diseño responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Título de la página que se visualiza en la pestaña desde el navegador -->
    <title>Balneario "El Texcal"</title>
    <!-- links de estilos -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilos_Balneario.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <div class="row">
        <!--Menú superior de la página-->
        <nav>
            <input type="checkbox" id="check">
            <label for="check" class="checkbtn"><i class="fas fa-bars"></i></label>
            <a href="#" class="enlace">
                <img src="../media/imagenes/logo.png" alt="" class="logo">
                <span>Parque Estatal "El Texcal"</span>
            </a>
            <!--Enlaces a páginas del sistema y que se encuentran en el menú a la derecha-->
            <ul>
                <li><a href="servicios.html">Servicios</a></li>
                <li><a href="../login/registrar.php">Registrarse</a></li>
                <li><a href="../login/login.php">Iniciar Sesión</a></li>
            </ul>
        </nav>
    </div>

    <!--Nombre del servicio al que se accedio-->
    <div class="row">
        <aside id="aside" class="col-xs-12 col-sm-12 col-md-12">
            <p>Productos Balneario</p>
        </aside>
    </div>
    <!--Sección con la lista de productos del local seleccionado-->
    <div class="row contenido">
        <section>
            <div class="row">
            </div>
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 ">
                    <h4><a href="./productos.php" class="enlaceVolver"><i class="fa-solid fa-arrow-left"></i> Volver</a></h4>
                </div>
                <br><br><br>
                <div class="col-12 col-sm-12 col-md-5 columna">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-5 tituloSeccion">
                            <p><i class="fa-solid fa-shop" style="color: #005DBB;"></i> Productos</p>
                        </div>
                    </div>
                </div>
                <!-- Se manda llamar la función de la capa lógica con el id de la tienda seleccionada -->
                <div class="col-12">
                    <br>
                    <?php
                    require $_SERVER['DOCUMENT_ROOT'] . '/sistema web/logica/gestionProducto/Productos.php';


                    mostrarProductosHome($id);

                    ?>
                </div>
            </div>
            <br><br>
        </section>
    </div>
    <div class="row">
        <footer>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 redes">

                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 datos">
                    <div class="logo">
                        <div class="card-body">
                            <br>
                            <center><img src="../media/imagenes/logo.png" alt="" class="logoFooter"></center>
                            <p class="card-text" style="color:white; font-size:18px">© Derechos Reservados, Parque Estatal "El Texcal" 2022</p>

                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 datos2">
                    <div class="card-body ">
                        <br>
                        <p class="card-text" style="color:Yellow; font-size:20px;">DIRECCIÓN</p>
                        <p class="card-text" style="color:white; font-size:18px;">Av. El Texcal 62, Unidad Habitacional El Texcal, Jiutepec, Morelos, México. 62573</p>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 datos3">
                    <div class="card-body ">
                        <br>
                        <p class="card-text" style="color:Yellow; font-size:20px;">NAVEGACIÓN</p>
                        <p class="card-text" style="color:white; font-size:18px;"><a class="link" href="../../index.php">- Inicio</a></p>
                        <p class="card-text" style="color:white; font-size:18px;"><a class="link" href="../login/registrar.php">- Registrarse</a></p>
                        <p class="card-text" style="color:white; font-size:18px;"><a class="link" href="../login/login.php">- Iniciar sesión</a></p>
                        <p class="card-text" style="color:white; font-size:18px;"><a class="link" href="../eventos.php">- Eventos</a></p>
                        <p class="card-text" style="color:white; font-size:18px;"><a class="link" href="servicios.html">- Servicios</a></p>
                        <p class="card-text" style="color:white; font-size:18px;"><a class="link" href="../ubicacion.html">- Ubicación</a></p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="../../logica/js/bootstrap.bundle.min.js"></script>
</body>

</html>