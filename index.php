<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Parque Estatal "El Texcal"</title>
        <link rel="stylesheet" href="presentacion/css/estilos_Index.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
        <link rel="stylesheet" href="presentacion/css/bootstrap.min.css">
    </head>
    <body>
        <div class="row">
            <nav>
                <input type="checkbox" id="check">
                <label for="check" class="checkbtn"><i class="fas fa-bars"></i></label>
                <a href="#" class="enlace">
                    <img src="presentacion/media/imagenes/logo.png" alt="" class="logo">
                    <span>Parque Estatal "El Texcal"</span>
                </a>
                <ul>
                    <li><a href="presentacion/login/registrar.php">Registrarse</a></li>
                    <li><a href="presentacion/login/login.php">Iniciar Sesión</a></li>                 
                </ul>
            </nav>
        </div>
        <div class="row">
            <div id="carouselExampleDark" class="carousel carousel-ligth slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active " data-bs-interval="10000">
                    <img src="presentacion/media/imagenes/sliderP1.png" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Parque Estatal "El Texcal"</h5>
                        <p>Disfruta los servicios y actividades que tenemos para ti...</p>
                    </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="10000">
                    <img src="presentacion/media/imagenes/sliderP1.png" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Parque Estatal "El Texcal"</h5>
                        <p>Disfruta los servicios y actividades que tenemos para ti...</p>
                    </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="10000">
                    <img src="presentacion/media/imagenes/sliderP1.png" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Parque Estatal "El Texcal"</h5>
                        <p>Disfruta los servicios y actividades que tenemos para ti...</p>
                    </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div class="row">
            <aside id="aside" class="col-xs-12 col-sm-12 col-md-12">
                <p>!Bienvenido!</p>
            </aside>
        </div>
        <div class="row contenido">
            <section>
                <div class="row opciones">
                    <div class="opc col-xs-12 col-sm-12 col-md-4">
                        <a class="linkCard" href="presentacion/eventos.php">
                            <div class="card tarjeta">
                                <div class="card-body">
                                    <p class="card-title" style="text-align: center; font-size:60px"><i class="fa-solid fa-calendar-days icono"></i></p>
                                    <p class="card-text" style="text-align: center; font-size:20px"><b> Eventos</b></p>
                                    <p class="card-text" style="text-align: center; font-size:15px">No te pierdas los próximos eventos que tenemos para ti...</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <br>
                    <div class="opc col-xs-12 col-sm-12 col-md-4">
                        <a class="linkCard" href="presentacion/servicios/servicios.html">
                            <div class="card tarjeta">
                                <div class="card-body">
                                    <p class="card-title" style="text-align: center; font-size:60px"><i class="fa-solid fa-users icono"></i></p>
                                    <p class="card-text" style="text-align: center; font-size:20px"><b>Servicios</b></p>
                                    <p class="card-text" style="text-align: center; font-size:15px">Conoce los servicios que tenemos para ti...</p>

                                </div>
                            </div>
                        </a>
                    </div>
                    <br><br>
                    <div class="opc col-xs-12 col-sm-12 col-md-4">
                        <a class="linkCard" href="presentacion/ubicacion.html">
                            <div class="card tarjeta">
                                <div class="card-body">
                                    <p class="card-title" style="text-align: center; font-size:60px"><i class="fa-solid fa-location-dot icono"></i></p>
                                    <p class="card-text" style="text-align: center; font-size:20px"><b>Cómo llegar</b></p>
                                    <p class="card-text" style="text-align: center; font-size:15px">Ubícanos...</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                
                <br>

                <?php 
                    require 'logica/gestionPublicacion/publicacion.php';
                    mostrarPublicacion("Parque");
                ?>

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
                                <center><img src="presentacion/media/imagenes/logo.png" alt="" class="logoFooter"></center>
                                <p class="card-text" style="color:white; font-size:18px">© Derechos Reservados, Parque Estatal "El Texcal" 2022</p>

                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 datos2">
                        <div class="card-body ">
                            <p class="card-text" style="color:Yellow; font-size:20px;">DIRECCIÓN</p>
                            <p class="card-text" style="color:white; font-size:18px;">Av. El Texcal 62, Unidad Habitacional El Texcal, Jiutepec, Morelos, México. 62573</p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 datos3">
                        <div class="card-body ">
                            <p class="card-text" style="color:Yellow; font-size:20px;">NAVEGACIÓN</p>
                            <p class="card-text" style="color:white; font-size:18px;"><a class="link" href="presentacion/login/registrar.php">- Registrarse</a></p>
                            <p class="card-text" style="color:white; font-size:18px;"><a class="link" href="presentacion/login/login.php">- Iniciar sesión</a></p>
                            <p class="card-text" style="color:white; font-size:18px;"><a class="link" href="presentacion/eventos.php">- Eventos</a></p>
                            <p class="card-text" style="color:white; font-size:18px;"><a class="link" href="presentacion/servicios/servicios.html">- Servicios</a></p>
                            <p class="card-text" style="color:white; font-size:18px;"><a class="link" href="presentacion/ubicacion.html">- Ubicación</a></p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
        <script src="logica/js/bootstrap.bundle.min.js"></script>
    </body>
    
</html>