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
        <!-- Links de estilos -->
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

        <!--Carrusel de imagenes-->
        <div class="row">
            <div id="carouselExampleDark" class="carousel carousel-ligth slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <!--Imagen 1 del carrousel-->
                    <div class="carousel-item active " data-bs-interval="10000">
                        <img src="../media/imagenes/sliderB3.png" class="d-block w-100 h-50" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Parque Estatal "El Texcal"</h5>
                            <p>Disfruta los servicios y actividades que tenemos para ti...</p>
                        </div>
                    </div>
                    <!--Imagen 2 del carrousel-->
                    <div class="carousel-item" data-bs-interval="10000">
                        <img src="../media/imagenes/sliderB3.png" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Parque Estatal "El Texcal"</h5>
                            <p>Disfruta los servicios y actividades que tenemos para ti...</p>
                        </div>
                    </div>
                    <!--Imagen 3 del carrousel-->
                    <div class="carousel-item" data-bs-interval="10000">
                        <img src="../media/imagenes/sliderB3.png" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Parque Estatal "El Texcal"</h5>
                            <p>Disfruta los servicios y actividades que tenemos para ti...</p>
                        </div>
                    </div>
                </div>
                <!--Botón para cambiar la imagen anterior del slider-->
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <!--Botón para cambiar la siguiente imagen del slider-->
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <!--Nombre del servicio al que se accedio-->
        <div class="row">
            <aside id="aside" class="col-xs-12 col-sm-12 col-md-12">
                <p>BALNEARIO</p>
            </aside>
        </div>
        <div class="row contenido">
            <section>
                <!--Boletos del servicio -->
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-2 tituloSeccion">
                        <p><i class="fa-solid fa-money-bill-1" style="color: #005DBB;"></i> Boletos</p>
                    </div>
                </div>
                <div class="row seccionTarifas">
                    <?php
                    //Archivo con las funciones lógicas de los boletos
                    require '../../logica/gestionBoleto/boletos.php';
                    //Se llama a la función para mostrar los boletos del servicio con id = 1 (balneario)
                    mostrarBoletosServicio(1);
                    ?>
                </div>
                <br><br>
                <!-- Horarios del parque -->
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-5 columna">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-5 tituloSeccion">
                                <p><i class="fa-solid fa-clock" style="color: #005DBB;"></i> Horarios</p>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="col-xs-11 col-sm-11 col-md-10 horario">
                                    <p>Lunes a Viernes: 9:00am a 13:00pm</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Opción para ver los productos del balneario -->
                    <div class="col-12 col-sm-12 col-md-5 columna">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-5 tituloSeccion">
                                <p><i class="fa-solid fa-shop" style="color: #005DBB;"></i> Productos</p>
                            </div>
                        </div>
                        <div class="row">
                            <a class="linkCard" href="productos.php">
                                <div class="col-11 col-sm-11 col-md-10 producto">
                                    <p>Ver productos</p>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>

                <br><br>
                <!-- Publicaciones del servicio del balneario -->
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-5 tituloSeccion">
                        <p><i class="fa-solid fa-photo-film" style="color: #005DBB;"></i> Publicaciones</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <br>
                        <?php
                        //Archivo para utilizar las funciones lógicas de las publicaciones
                        require '../../logica/gestionPublicacion/publicacion.php';
                        //Se llama a la función para mostrar las publicaciones del servicio del balneario
                        mostrarPublicacion("Balneario");
                        ?>
                    </div>
                </div>
                <br><br>
                <!-- Comentarios del servicio -->
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-5 tituloSeccion">
                        <p><i class="fa-solid fa-message" style="color: #005DBB;"></i> Comentarios</p>
                    </div>
                </div>

                <div class="row seccionComentarios">
                    <?php
                    //Archivo para utilizar las funciones lógicas de los comentarios
                    require '../../logica/gestionComentario/comentarios.php';
                    //Se llama a la función para mostrar los comentarios del servicio con id =1 (Balneario)
                    mostrarComentariosXServicio(1);
                    ?>
                </div>
            </section>
        </div>
        <!-- Footer de la página en la que contiene el logo y los datos de la empresa-->
        <div class="row">
            <footer>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 redes"></div>
                </div>
                <div class="row">
                    <!--Logo-->
                    <div class="col-xs-12 col-sm-12 col-md-4 datos">
                        <div class="logo">
                            <div class="card-body">
                                <br>
                                <center><img src="../media/imagenes/logo.png" alt="" class="logoFooter"></center>
                                <p class="card-text" style="color:white; font-size:18px">© Derechos Reservados, Parque Estatal "El Texcal" 2022</p>

                            </div>
                        </div>
                    </div>
                    <!--Información de la ubicación del parque-->
                    <div class="col-xs-12 col-sm-12 col-md-4 datos2">
                        <div class="card-body ">
                            <br>
                            <p class="card-text" style="color:Yellow; font-size:20px;">DIRECCIÓN</p>
                            <p class="card-text" style="color:white; font-size:18px;">Av. El Texcal 62, Unidad Habitacional El Texcal, Jiutepec, Morelos, México. 62573</p>
                        </div>
                    </div>
                    <!--Navegación rápida del sistema-->
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
        <!--Script bootstrap-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
        <script src="../../logica/js/bootstrap.bundle.min.js"></script>
    </body>
</html>