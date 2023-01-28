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

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Codificación de caracteres utilizada en el documento -->
    <meta charset="utf-8">
    <!-- viewport para el diseño responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Título de la página que se visualiza en la pestaña desde el navegador -->
    <title>Archivero</title>
    <!-- links de estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../../css/estilos_Archivero.css">
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
            <a href="../../../menu/menuAdministrador.php?id=<?php echo $id; ?>">Volver</a>
        </aside>
    </div>
    <!-- Div que contiene el buscador de archivos -->
    <div class="row">
        <section id="section" class="col-12 col-sm-12 col-md-12">
            <div class="card col-10 offset-1 buscador">
                <div class="row">
                    <!-- Div con el icono de archivos -->
                    <div class="col-2 col-sm-1">
                        <i class="fa-solid fa-folder-open " style="text-align: center; font-size:40px; color: #FFD607"></i>
                    </div>
                    <!-- Div con el titulo de archivero -->
                    <div class="col-4 col-sm-3">
                        <label class="col-form-label">Archivero</label>
                    </div>
                    <!-- Formulario con el input de buscador -->
                    <form class="col-12 col-sm-6" method="post">
                        <div class="row">
                            <div class="col-9 col-sm-10">
                                <input type="text" autocomplete="off" name="buscador" id="buscador" placeholder="Buscador" class="form-control">
                            </div>
                            <!-- Botón para realizar la búsqueda -->
                            <div class="col-1 ">
                                <button type="submit" class="btn btn-primary btnBuscar"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <br>
            <br>
            <!--Enlace que redirige a la página del formulario de agregar carpeta-->
            <div class="col-10 offset-1">
                <a href="./agregarCarpeta.php?id=<?php echo $id; ?>"><button class=" col-12 col-sm-5 btn btnAgregar" type="button"><i class="fa-solid fa-folder-plus"></i> Nueva carpeta</button></a>
            </div>
            <br>

            <?php
            //Se verifica que exista la sesión llamada status, está ayuda a saber el estado del resultado 
            //que se retorno de la base de datos
            if (isset($_SESSION['status'])) {
                //Se verifica lo que contienen la sesión, 
                //en el que si son mensajes de éxito  se deberá crear un alert de bootstrap tipo alert-success
                if ($_SESSION['status'] == 'Carpeta creada con éxito.' || $_SESSION['status'] == 'Carpeta y archivos eliminados con éxito.' || $_SESSION['status'] == 'Carpeta actualizada con éxito.') {
            ?>
                    <!-- Alerta de éxito -->
                    <div class="col-10 offset-1">
                        <div id="alerta" class="alert alert-success d-flex align-items-center" role="alert">
                            <?php echo $_SESSION['status']; ?>
                        </div>
                    </div>
                    <br>
                <?php   } else { ?>
                    <!-- Si el mensaje que contiene la sesión es porque ocurrión un problema y se debe mostrar
                            un mensaje de alerta de tipo alert-danger -->
                    <!-- Alerta de error -->
                    <div class="col-10 offset-1">
                        <div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert">
                            <?php echo $_SESSION['status']; ?>
                        </div>
                    </div>
                    <br>
            <?php   }
                //Se refresca la página 2 segundos después para eliminar el mensaje. 
                header("refresh:1; url = ./archivero.php?id=" . $id);
                //Se elimina la variable de sesión
                unset($_SESSION['status']);
            }
            ?>
            <!-- Div que contiene la función de mostrar las carpetas del buscador -->

            <div class="col-10 offset-1">
                <?php
                require $_SERVER['DOCUMENT_ROOT'] . '/sistema web/logica/gestionArchivero/archivero.php';
                //Se verifica que exista la variable buscador enviada por el método POST
                if (isset($_POST['buscador'])) {
                    $buscador = htmlentities($_POST['buscador']);
                    //Llamada a la función con las entradas para mostrar las carpetas que coincidan con las palabras del buscador
                    mostrarCarpetas($buscador, $id);
                } else {
                    //Llamada a la función para mostrar todos las carpetas si no existe la variable de buscador
                    mostrarCarpetas("", $id);
                }
                ?>
            </div>
        </section>
    </div>
    <!-- Modal con mensaje de confirmación de eliminación de carpeta -->
    <div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Cabecera del modal-->
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Eliminar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Cuerpo del modal-->
                <div class="modal-body">
                    ¿Está seguro de eliminar la carpeta?
                    <br>
                    Se eliminará todo lo que contenga dicha carpeta y no podrá revertir la acción.
                </div>
                <!-- Pie del modal-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                    <a id="eliminarCarpeta" href="" data-bs-href="../../../../logica/gestionArchivero/eliminarCarpeta.php?idAdmin=">
                        <button type="button" class="btn btn-danger">Aceptar</button>
                    </a>
                </div>
            </div>
        </div>
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
    <!-- Script para el slider -->
    <script src="../../../../logica/js/eliminarCarpeta.js"></script>
    <!-- Script para mostrar mensaje de confirmación de eliminación de archivo -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>