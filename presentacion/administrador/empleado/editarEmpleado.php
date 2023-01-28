<?php
session_start(); //Se inicia la sesión.
//Se verifica que exista la variable de sesión para que el usuario pueda acceder al menú.
if (isset($_SESSION['usuario'])) {
    //Se obtiene el id del usuario
    $id = htmlentities($_GET['id']);
    $idTrabajador = htmlentities($_GET['idTrabajador']);
    //Requerimos del archivo para realizar la conexión.
    require $_SERVER['DOCUMENT_ROOT'] . '/sistema web/datos/conexionBD.php';

    $sql  = "SELECT count(*) as contar from trabajador where idTrabajador = '" . $idTrabajador . "'";
    $consulta =  mysqli_query($conn, $sql);
    $array = mysqli_fetch_array($consulta);
    //Si es mayor a cero significa que la clave ya existe y debe redirigirse a la página de registrar.
    if ($array['contar'] > 0) {
        //Se crea un query para mostrar datos del empleado seleccionado para modificar.
        $buscarEmpleado = mysqli_query($conn, "SELECT tipoTrab, nombreTrab, apellPatTrab, apellMatTrab, correoTrab from Trabajador WHERE idTrabajador ='" . $idTrabajador . "'");
        $filas = mysqli_fetch_array($buscarEmpleado);
        //Se obtienen los datos del trabajador.
        $tipo = $filas['tipoTrab'];
        $nombre = $filas['nombreTrab'];
        $apellidoPat = $filas['apellPatTrab'];
        $apellidoMat = $filas['apellMatTrab'];
        $correo = $filas['correoTrab'];
    }

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
    <title>Editar empleado</title>
    <!-- links de estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../css/estilos_AgregarEmpleado.css">
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
            <a href="./empleados.php?id=<?php echo $id; ?>">Volver</a>
        </aside>
    </div>
    <!-- Div que contiene el formulario de actualización del empleado -->
    <div class="row">
        <section id="section" class="col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-12 col-sm-8 col-md-4 formulario">
                <!--Formulario para editar el empleado-->
                <form action="../../../logica/gestionEmpleado/editarEmpleado.php" method="post">
                    <h2 style="text-align: center">EDITAR EMPLEADO</h2>

                    <!--Se verifica que exista la sesión llamada status, está ayuda a saber el estado del resultado 
                        que se retorno de la base de datos-->
                    <?php if (isset($_SESSION['status'])) {
                        //Se verifica lo que contienen la sesión, 
                        //en el que si son mensajes de éxito  se deberá crear un alert de bootstrap tipo alert-success
                        if ($_SESSION['status'] == 'Complete todos los campos.') {
                    ?>
                            <!-- Alerta de error -->
                            <div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert">
                                <?php echo $_SESSION['status']; ?>
                            </div> <br>
                            <!--Una vez mostrado el mensaje, pasa un segundo y se refresaca la página-->
                    <?php   }
                        header("refresh:1; url = ./editarEmpleado.php?idTrabajador=" . $idTrabajador);
                        unset($_SESSION['status']);
                    } ?><!--Se elimina la variable de sesión-->

                    <!--Selector del tipo de empleado-->
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id=""><i class="fa-solid fa-users icono"></i></span>
                        <select class="form-select" name="tipoEmpleado" aria-label="Username" required>
                            <option value="">Tipo de empleado</option>
                            <?php
                            //Este if anidado permite mostrar las opciones del selector dependiendo de
                            //el tipo de trabajador
                            if ($tipo === "Guia") {
                                echo '<option selected="selected" value="' . $tipo . '">' . $tipo . '</option>';
                                echo '<option value="Vendedor">Vendedor</option>';
                                echo '<option value="Mantenimiento">Mantenimiento</option>';
                                echo '<option value="Administrador">Administrador</option>';
                            } else {
                                if ($tipo === "Vendedor") {
                                    echo '<option value="Guia">Guia</option>';
                                    echo '<option selected="selected" value="' . $tipo . '">' . $tipo . '</option>';
                                    echo '<option value="Mantenimiento">Mantenimiento</option>';
                                    echo '<option value="Administrador">Administrador</option>';
                                } else {

                                    if ($tipo === "Mantenimiento") {
                                        echo '<option value="Guia">Guia</option>';
                                        echo '<option value="Vendedor">Vendedor</option>';
                                        echo '<option selected="selected" value="' . $tipo . '">' . $tipo . '</option>';
                                        echo '<option value="Administrador">Administrador</option>';
                                    } else {
                                        echo '<option value="Guia">Guia</option>';
                                        echo '<option value="Vendedor">Vendedor</option>';
                                        echo '<option value="Mantenimiento">Mantenimiento</option>';
                                        echo '<option selected="selected" value="' . $tipo . '">' . $tipo . '</option>';
                                    }
                                }
                            }

                            ?>

                        </select>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="idTrabajador" value="<?php echo $idTrabajador; ?>">
                    <!--Nombre del empleado-->
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text span" id=""><i class="fa-solid fa-user icono"></i></span>
                        <input type="text" autocomplete="off" value="<?php echo $nombre ?>" class="form-control" name="nombre" placeholder="Nombre" aria-label="Username" aria-describedby="addon-wrapping" required>
                    </div>
                    <!--Apellido Paterno del empleado-->
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id=""><i class="fa-solid fa-user icono"></i></span>
                        <input type="text" autocomplete="off" value="<?php echo $apellidoPat ?>" class="form-control" name="apPaterno" placeholder="Apellido Paterno" aria-label="Username" aria-describedby="addon-wrapping" required>
                    </div>
                    <!--Apellido Materno del empleado-->
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id=""><i class="fa-solid fa-user icono"></i></span>
                        <input type="text" autocomplete="off" value="<?php echo $apellidoMat ?>" class="form-control" name="apMaterno" placeholder="Apellido Materno" aria-label="Username" aria-describedby="addon-wrapping">
                    </div>
                    <!--Email del empleado-->
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id=""><i class="fa-solid fa-envelope icono"></i></span>
                        <input type="email" autocomplete="off" value="<?php echo $correo ?>" class="form-control" name="correo" placeholder="Correo electrónico" aria-label="Username" aria-describedby="addon-wrapping" required>
                    </div>
                    <!--Botón para confirmar la actualización-->
                    <button class="btnRegistrar btn-lg" type="submit">Actualizar</button>
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
    <script src="../../../logica/js/mostrarContra.js"></script> <!--Script para mostrar y ocultar la contraseña-->
    <!--Script de Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>