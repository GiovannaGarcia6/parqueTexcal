<?php
session_start(); //Se inicia la sesión.
//Se verifica que exista la variable de sesión para que el usuario pueda acceder al menú.
if (isset($_SESSION['usuario'])) {
    //Si existe, se obtiene el id del producto y del trabajador.
    $idProducto = htmlentities($_GET['id']);
    $idTrab = htmlentities($_GET['idTrab']);
    //Requerimos del archivo para realizar la conexión.
    require $_SERVER['DOCUMENT_ROOT'] . '/sistema web/datos/conexionBD.php';
    //Se crea un query para mostrar datos del producto seleccionado para modificar.
    $buscarProducto = mysqli_query($conn, "SELECT idProducto,nombreProd,precioProd,descProd,imagenProd,idTienda FROM Producto WHERE idProducto ='" . $idProducto . "'");
    $datos = mysqli_fetch_array($buscarProducto);
    //Se obtienen los datos del producto.
    $nombreProd = $datos['nombreProd'];
    $precioProd = $datos['precioProd'];
    $descProd   = $datos['descProd'];
    $imagenProd = $datos['imagenProd'];
    $idTienda   = $datos['idTienda'];
    mysqli_close($conn); //Se cierra la conexión de la bd.
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
    <!-- viewport para el diseño responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Título de la página que se visualiza en la pestaña desde el navegador -->
    <title>Editar producto</title>
    <!-- links de estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../css/estilos_AgregarNegocio.css">
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
            <a href="./productos.php?id=<?php echo $idTrab; ?>&idTienda=<?php echo $idTienda; ?>">Volver</a>
        </aside>
    </div>
    <!-- Div que contiene el formulario de registro de producto -->
    <div class="row">
        <section id="section" class="col-xs-12 col-sm-12 col-md-12">
            <div class="col-12 col-sm-8 col-md-4 formulario">
                <!--Formulario para editar un producto-->
                <form action="../../../logica/gestionProducto/editarProducto.php" method="post" enctype="multipart/form-data">
                    <h2 class="mb-5" style="text-align: center"></i>EDITAR PRODUCTO</h2>
                    <!--Se verifica que exista la sesión llamada status, está ayuda a saber el estado del resultado 
                        que se retorno de la base de datos-->
                    <?php if (isset($_SESSION['status'])) {
                        //Se verifica lo que contienen la sesión, 
                        //en el que si son mensajes de éxito  se deberá crear un alert de bootstrap tipo alert-success
                        if ($_SESSION['status'] == 'Producto actualizado con éxito.') {
                    ?>
                            <!-- Alerta de éxito -->
                            <div id="alerta" class="alert alert-success d-flex align-items-center" role="alert">
                                <?php echo $_SESSION['status']; ?>

                            </div><br>
                            <!-- Si el mensaje que contiene la sesión es porque ocurrión un problema y se debe mostrar
                            un mensaje de alerta de tipo alert-danger -->
                            <!-- Alerta de error -->
                        <?php } else { ?>
                            <div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert">
                                <?php echo $_SESSION['status']; ?>
                            </div> <br>
                            <!--Se refresca un segundo después de mostrar el mensaje-->
                    <?php }
                        header("refresh:1; url = ./editarProducto.php?id=" . $idProducto . "&idTrab=" . $idTrab);
                        unset($_SESSION['status']);
                    } ?><!--Se elimina la variable de sesión-->

                    <!--Id del producto-->
                    <input type="hidden" name="idProducto" value="<?php echo $idProducto; ?>">
                    <!--Id de la tienda-->
                    <input type="hidden" name="idTienda" value="<?php echo $idTienda; ?>">
                    <!--Id del vendedor-->
                    <input type="hidden" name="idTrabajador" value="<?php echo $idTrab; ?>">
                    <!--Nombre del producto-->
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text span" id=""> <i class="fa-solid fa-store icono"></i></span>
                        <input type="text" value="<?php echo $nombreProd ?>" autocomplete="off" class="form-control" name="nombreProducto" placeholder="Nombre del producto" aria-label="Username" aria-describedby="addon-wrapping" required>
                    </div>
                    <!--Precio del producto-->
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text span" id=""> <i class="fa-solid fa-money-bill icono"></i></span>
                        <input type="number" value="<?php echo $precioProd ?>" autocomplete="off" class="form-control" name="precioProducto" placeholder="Precio del producto" aria-label="Username" aria-describedby="addon-wrapping" required>
                    </div>
                    <!--Decripción del producto-->
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text span" id=""> <i class="fa-solid fa-align-left icono"></i></span>
                        <textarea class="form-control" placeholder="Descripción del producto" name="descProducto" style="height: 100px"><?php echo $descProd ?></textarea>
                    </div>
                    <!--Imagen del producto-->
                    <div id="mostrarImagen" class="row">
                        <div class="col-6">
                            <br>
                            <small id="fileHelpId" class="form-text text-muted">Imagen guardada: </small>
                        </div>
                        <div class="col-6">
                            <?php echo '<img  style="width:150px;height:150px" src="data:image/jpeg;base64,' . base64_encode($imagenProd) . '"/>'; ?>
                        </div>
                    </div>
                    <!--Nota para actualizar la imagen-->
                    <small id="fileHelpId" class="form-text text-muted">* Si desea actualizar la imagen debe subir la imagen. </small>
                    <!--Nueva imagen del producto-->
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text span" id=""> <i class="fa-solid fa-image icono"></i></span>
                        <input type="file" class="form-control" name="archivo" aria-label="Username" aria-describedby="addon-wrapping">
                    </div>
                    <!--Botón para editar el producto-->
                    <button class="btnAceptar btn-lg" type="submit">Aceptar</button>
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
            <div class="row">
                <div class="row">
                    <!--Logo-->
                    <div class="col-xs-12 col-sm-12 col-md-3 opc">
                        <div class="logo">
                            <div class="card-body">
                                <img src="../../media/imagenes/logo.png" alt="" class="logoFooter">

                            </div>
                        </div>
                    </div>
                    <!--Información de la ubicación del parque-->
                    <div class="col-xs-12 col-sm-12 col-md-9 opc">
                        <div class="datosFooter">
                            <div class="card-body ">
                                <p class="card-text" style="color:white; font-size:18px">© Derechos Reservados, Parque Estatal "El Texcal" 2022</p>
                                <p class="card-text" style="color:Yellow; font-size:20px;">DIRECCIÓN</p>
                                <p class="card-text" style="color:white; font-size:18px;">Av. El Texcal 62, Unidad Habitacional El Texcal, Jiutepec, Morelos, México. 62573</p>
                            </div>
                        </div>
                    </div>
                </div>
        </footer>
    </div>
    <!--Script js de Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>