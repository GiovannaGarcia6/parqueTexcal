<?php
    session_start(); //Se inicia la sesión.
    //Se verifica que exista la variable de sesión para que el usuario pueda acceder al menú.
    if (isset($_SESSION['usuario'])) {
        //Se obtiene el id del usuario
        $id = htmlentities($_GET['id']);
    } else {
        //En caso de que no se encuentre la variable de sesión se redirige al inicio de sesión.
        header("Location: ../../login/login.php");
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Codificación de caracteres utilizada en el documento -->
        <meta charset="utf-8">
        <!-- Viewport para el diseño responsive -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Título de la página que se visualiza en la pestaña desde el navegador -->
        <title>Reportes</title>
        <!-- links de estilos -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="../../css/estilos_Reportes.css">

        <!-- Google Charts -->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    </head>
    <!-- Body con la clase grid-container que alinea el contenido -->
    <body class="grid-container">
        <!-- Div que contiene el renglón con el logo y nombre del sistema -->
        <div class="row">
            <nav class="col-xs-12 col-sm-12 col-md-12">
                <a href="#" class="enlace"><img src="../../media/imagenes/logo.png" alt="" class="logo"><span> Parque Estatal "El Texcal"</span></a>
            </nav>
        </div>
        <!-- Div que contiene la opción de regresar a la sección anterior enviando las variables
                Necesarias para que se muestren los datos correspondientes -->
        <div class="row">
            <aside id="aside" class="col-xs-12 col-sm-12 col-md-12">
                <a href="../../menu/menuGuia.php?id=<?php echo $id; ?>">Volver</a>
            </aside>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-4 section">
                <!-- Encabezado de la sección de comentarios -->
                <div class="col-11 encabezadoParametros">
                    <center>
                        <h3>Parámetros</h3>
                    </center>
                </div>
                <!-- Formulario para el ingreso de los parámetros para los reportes -->
                <form method="post" class="col-11 card cuerpoParametros">
                    <!-- Input no visible con el id del guia -->
                    <input type="hidden" name="idGuia" value="<?php echo $id; ?>">
                    <div class="col-12" id="parametro3">
                        <h4><i class="fa-solid fa-filter"></i> Filtrar por fecha: </h4>
                        <br>
                        <h6>Fecha inicio</h6>
                        <!-- Input fecha inicio -->
                        <input type="date" autocomplete="off" class="form-control" name="fechaInicio" placeholder="Fecha de inicio" aria-label="Username" aria-describedby="addon-wrapping" required>
                        <br>
                        <!-- Input fecha termino -->
                        <h6>Fecha termino</h6>
                        <input type="date" autocomplete="off" class="form-control" name="fechaTermino" placeholder="Fecha termino" aria-label="Username" aria-describedby="addon-wrapping" required>
                    </div>
                    <br>
                    <button class="btnAplicar btn-lg" type="submit">Aplicar</button>
                </form>
            </div>
            <!-- Sección de resultados -->
            <div class="col-12 col-sm-12 col-md-8 section">
                <!-- Encabezado de la sección de resultados -->
                <div class="col-11 encabezadoResultados">
                    <center>
                        <h3>Resultados</h3>
                    </center>
                </div>
                <!-- Cuerpo de resultados -->
                <div class="col-11 card cuerpoResultados">
                    <?php
                    //Se manda llamar el archivo necesario para los reportes
                    require $_SERVER['DOCUMENT_ROOT'] . '/sistema web/logica/reportes/reportes.php';

                    //Se comprueban los valores insertados en el formulario de parámetros
                    if (isset($_POST['fechaInicio']) && isset($_POST['fechaTermino']) && isset($_POST['idGuia'])) {
                        //Se almacenan los valores obtenidos del formulario
                        $fechaInicio = $_POST['fechaInicio'];
                        $fechaTermino = $_POST['fechaTermino'];
                        //Se llama la función de la capa lógica para mostrar los resultados del reporte
                        mostrarResultadosGuia($idGuia, $fechaInicio, $fechaTermino);
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- Footer de la página en la que contiene el logo y los datos de la empresa-->
        <div class="row">
            <footer>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 footer1"> </div>
                </div>
                <!--Logo-->
                <div class="row footerRow">
                    <div class="col-xs-12 col-sm-12 col-md-3 datos1">
                        <div class="logo">
                            <div class="card-body">
                                <center><img src="../../media/imagenes/logo.png" alt="" class="logoFooter"></center>
                            </div>
                        </div>
                    </div>
                    <!--Información de la ubicación del parque-->
                    <div class="col-xs-12 col-sm-12 col-md-9 datos2">
                        <div class="card-body ">
                            <p class="card-text" style="color:white; font-size:18px">© Derechos Reservados, Parque Estatal "El Texcal" 2022</p>
                            <p class="card-text" style="color:Yellow; font-size:20px;">DIRECCIÓN</p>
                            <p class="card-text" style="color:white; font-size:18px;">Av. El Texcal 62, Unidad Habitacional El Texcal, Jiutepec, Morelos, México. 62573</p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- Script de Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    </body>
</html>