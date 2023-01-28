<?php
session_start(); //Se inicia la sesión.
//Se verifica que exista la variable de sesión para que el usuario pueda acceder al menú.
if (isset($_SESSION['usuario'])) {
    //Se obtiene el id del usuario
    $id = htmlentities($_GET['idComentario']);
    //Requerimos del archivo para realizar la conexión.
    require $_SERVER['DOCUMENT_ROOT'] . '/sistema web/datos/conexionBD.php';
    //Se crea un query para mostrar datos del boleto seleccionado para modificar.
    $buscarComentario = mysqli_query($conn, "SELECT contenido, puntuacion, idServicio, idVisitante from Comentario WHERE idComentario ='" . $id . "'");
    $filas = mysqli_fetch_array($buscarComentario);
    //Se obtienen los datos del comentario.
    $comentario = $filas['contenido'];
    $puntuacion = $filas['puntuacion'];
    $idServicio = $filas['idServicio'];
    $idVisitante = $filas['idVisitante'];
    mysqli_close($conn); //Se cierra la conexión de la bd.
} else {
    //En caso de que no se encuentre la variable de sesión se redirige al inicio de sesión.
    header("Location: ../login.php");
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Codificación de caracteres utilizada en el documento -->
    <meta charset="utf-8">
    <!-- viewport para el diseño responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Título de la página que se visualiza en la pestaña desde el navegador -->
    <title>Nuevo comentario</title>
    <!-- links de estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../css/estilos_AgregarComentario.css">
</head>
<!-- Body con la clase grid-container que alinea el contenido -->

<body class="grid-container">
    <!-- Div que contiene el renglón con el logo y nombre del sistema -->
    <div class="row">
        <nav class="col-xs-12 col-sm-12 col-md-12">
            <a href="#" class="enlace"><img src="../media/imagenes/logo.png" alt="" class="logo"><span> Parque Estatal "El Texcal"</span></a>
        </nav>
    </div>
    <!-- Div que contiene la opción de regresar a la sección anterior enviando las variables
            Necesarias para que se muestren los datos correspondientes -->
    <div class="row">
        <aside id="aside" class="col-xs-12 col-sm-12 col-md-12">
            <a href="./comentarios.php?id=<?php echo $idVisitante; ?>">Volver</a>
        </aside>
    </div>
    <!-- Div que contiene el formulario de actualización de comentario -->
    <div class="row">
        <section id="section" class="col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-12 col-sm-8 col-md-4 formulario">
                <!--Formulario para editar un producto-->
                <form action="../../../logica/gestionComentario/editarComentario.php" method="post">
                    <h2 style="text-align: center">EDITAR COMENTARIO</h2>
                    <!--Se verifica que exista la sesión llamada status, está ayuda a saber el estado del resultado 
                        que se retorno de la base de datos-->
                    <?php if (isset($_SESSION['status'])) {
                        //Se verifica lo que contienen la sesión, 
                        //en el que si son mensajes de éxito  se deberá crear un alert de bootstrap tipo alert-success
                        if ($_SESSION['status'] == 'Debe agregar su comentario.') {
                    ?>
                            <!-- Alerta de error -->
                            <div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert">
                                <?php echo $_SESSION['status']; ?>
                            </div> <br>
                    <?php   }
                        header("refresh:1; url = ./editarComentario.php?idComentario=" . $id);
                        unset($_SESSION['status']);
                    } ?><!--Se elimina la variable de sesión-->

                    <input type="hidden" name="idComentario" value="<?php echo $id; ?>">
                    <input type="hidden" name="idVisitante" value="<?php echo $idVisitante; ?>">
                    <!--Selector del servicio-->
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id=""><i class="fa-solid fa-users icono"></i></span>
                        <select class="form-select" name="servicio" aria-label="Username" required>
                            <option value="">Seleccione un servicio</option>
                            <?php
                            require $_SERVER['DOCUMENT_ROOT'] . '/sistema web/logica/gestionComentario/comentarios.php';
                            mostrarServicios(TRUE, $idServicio);
                            ?>
                        </select>

                    </div>

                    <!--Selector de la puntuación-->
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text"><i class="fa-solid fa-star icono"></i></span>
                        <select class="form-select" name="puntuacion" aria-label="Username" required>
                            <option value="">Puntuación</option>
                            <?php
                            for ($i = 1; $i <= 5; $i++) {
                                echo "<option value='" . $i . "'";
                                //Si es el mismo id que se obtuvo al inicio se muestra como seleccionada.
                                if ($i == $puntuacion) {
                                    echo ' selected="selected"';
                                }
                                echo ">" . $i . " Estrellas</option>";
                            }
                            ?>
                        </select>

                    </div>
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text span" id=""> <i class="fa-solid fa-message icono"></i></span>
                        <textarea class="form-control" placeholder="Comentario" name="comentario" style="height: 100px"><?php echo $comentario ?></textarea>
                    </div>

                    <button class="btnRegistrar btn-lg" type="submit">Enviar</button>
                </form>
            </div>

        </section>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>