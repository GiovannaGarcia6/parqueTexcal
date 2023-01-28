<?php
session_start(); //Se inicia la sesión.
//Se verifica que exista la variable de sesión para que el usuario pueda acceder al menú.
if (isset($_SESSION['usuario'])) {
    //Se obtiene el id del usuario
    $id = htmlentities($_GET['id']);
} else {
    //En caso de que no se encuentre la variable de sesión se redirige al inicio de sesión.
    header("Location: ../../../login/login.php");
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
    <title>Nueva carpeta</title>
    <!-- links de estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../../css/estilos_AgregarCarpeta.css">
</head>
<!-- Body con la clase grid-container que alinea el contenido -->

<body class="grid-container">
    <!-- Div que contiene el renglón con el logo y nombre del sistema -->
    <div class="row">
        <nav class="col-xs-12 col-sm-12 col-md-12">
            <a href="#" class="enlace"><img src="../../../media/imagenes/logo.png" alt="" class="logo"><span> Parque Estatal "El Texcal"</span></a>
        </nav>
    </div>
    <!-- Div que contiene la opción de regresar a la sección anterior enviando las variables
            Necesarias para que se muestren los datos correspondientes -->
    <div class="row">
        <aside id="aside" class="col-xs-12 col-sm-12 col-md-12">
            <a href="./archivero.php?id=<?php echo $id; ?>">Volver</a>
        </aside>
    </div>
    <!-- Div que contiene el formulario de registro de archivo -->
    <div class="row">
        <section id="section" class="col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-12 col-sm-8 col-md-4 formulario">
                <!-- Formulario de registro de archivo con el action y el método para registrar -->
                <form action="../../../../logica/gestionArchivero/agregarCarpeta.php" method="post">
                    <h2 style="text-align: center">NUEVA CARPETA</h2>
                    <center> <i class="fa-solid fa-folder-open" style="text-align: center; font-size:80px; color: #349704"></i></center>
                    <br>
                    <!--Se verifica que exista la sesión llamada status, está ayuda a saber el estado del resultado 
                        que se retorno de la base de datos-->
                    <?php if (isset($_SESSION['status'])) {
                        //Se verifica lo que contienen la sesión, 
                        //en el que si son mensajes de éxito  se deberá crear un alert de bootstrap tipo alert-success
                        if ($_SESSION['status'] == 'Carpeta agregada con éxito.') {
                    ?>
                            <!-- Alerta de éxito -->
                            <div id="alerta" class="alert alert-success d-flex align-items-center" role="alert">
                                <?php echo $_SESSION['status']; ?>
                            </div><br>
                        <?php   } else { ?>
                            <!-- Si el mensaje que contiene la sesión es porque ocurrión un problema y se debe mostrar
                            un mensaje de alerta de tipo alert-danger -->
                            <!-- Alerta de error -->
                            <div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert">
                                <?php echo $_SESSION['status']; ?>
                            </div> <br>
                            <!-- Se refresca la página 2 segundos después para eliminar el mensaje.  -->
                    <?php   }
                        header("refresh:1; url = ./agregarCarpeta.php?id=" . $id);
                        unset($_SESSION['status']);
                    } ?><!--Se elimina la variable de sesión-->
                    <!-- Input no visible con el valor del id del usuario -->
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <!-- Input para el nombre de la carpeta -->
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text span" id=""> <i class="fa-solid fa-folder-open icono"></i></span>
                        <input type="text" autocomplete="off" class="form-control" name="nombreCarpeta" placeholder="Nombre de la carpeta" aria-label="Username" aria-describedby="addon-wrapping" required>
                    </div>
                    <!-- Botón para registrar la carpeta -->
                    <button class="btnRegistrar btn-lg" type="submit">Agregar</button>
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
            <div class="row footerRow">
                <div class="col-xs-12 col-sm-12 col-md-3 datos1">
                    <div class="logo">
                        <div class="card-body">
                            <center><img src="../../../media/imagenes/logo.png" alt="" class="logoFooter"></center>
                        </div>
                    </div>
                </div>
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