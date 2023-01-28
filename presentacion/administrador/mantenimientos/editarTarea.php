<?php
session_start(); //Se inicia la sesión.
//Se verifica que exista la variable de sesión para que el usuario pueda acceder al menú.
if (isset($_SESSION['usuario'])) {
    //Se obtiene el id del usuario
    $id = htmlentities($_GET['id']);
    //Se obtiene el id del mantenimiento al que pertenece la tarea a modificar
    $idMantenimiento = htmlentities($_GET['idMantenimiento']);
    //Se obtiene el id de la tarea a modificar
    $idTarea = htmlentities($_GET['idTarea']);
    //Requerimos del archivo para realizar la conexión.
    require '../../../datos/conexionBD.php';

    $sql  = "Select count(*) as contar from tarea where idTarea = '" . $idTarea . "'";
    $consulta =  mysqli_query($conn, $sql);
    $array = mysqli_fetch_array($consulta);
    //Si es mayor a cero significa que la clave ya existe y debe redirigirse a la página de registrar.
    if ($array['contar'] > 0) {
        //Se crea un query para mostrar datos de la tarea seleccionada para modificar.
        $buscarTarea = mysqli_query($conn, "SELECT tituloTarea, descTarea, estadoTarea, fechInic, fechTerm, correoTrab from Tarea INNER JOIN Trabajador on Trabajador.idTrabajador=Tarea.idTrabajador WHERE idTarea ='" . $idTarea . "'");
        $filas = mysqli_fetch_array($buscarTarea);
        //Se obtienen los datos de la tarea.
        $titulo = $filas['tituloTarea'];
        $desc = $filas['descTarea'];
        $estado = $filas['estadoTarea'];
        $inic = $filas['fechInic'];
        $term = $filas['fechTerm'];
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
    <title>Editar tarea</title>
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
            <a href="./tareas.php?id=<?php echo $id; ?>&idMantenimiento=<?php echo $idMantenimiento; ?>">Volver</a>
        </aside>
    </div>
    <!-- Div que contiene el formulario de actualización de la tarea -->
    <div class="row">
        <section id="section" class="col-12 col-sm-12 col-md-12">
            <div class="col-11 col-sm-8 col-md-4 formulario">
                <!--Formulario para editar la tarea-->
                <form action="../../../logica/gestionMantenimiento/editarTarea.php" method="post">
                    <h2 style="text-align: center">EDITAR TAREA</h2>

                    <!--Se verifica que exista la sesión llamada status, está ayuda a saber el estado del resultado 
                        que se retorno de la base de datos-->
                    <?php if (isset($_SESSION['status'])) {
                        //Se verifica lo que contienen la sesión, 
                        //en el que si son mensajes de éxito  se deberá crear un alert de bootstrap tipo alert-success
                        if ($_SESSION['status'] == 'Debe agregar una descripción a la tarea.' || $_SESSION['status'] == 'Hubo un error al actualizar la tarea.') {
                    ?>
                            <!-- Alerta de error -->
                            <div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert">
                                <?php echo $_SESSION['status']; ?>
                            </div> <br>
                    <?php   }
                        header("refresh:1; url = ./editarTarea.php?idMantenimiento=" . $idMantenimiento . "&id=" . $id . "&idTarea=" . $idTarea);
                        unset($_SESSION['status']);
                    } ?><!--Se elimina la variable de sesión-->
                    <!--Input no visible con el id del usuario-->
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <!--Input no visible con el id del mantenimiento-->
                    <input type="hidden" name="idMantenimiento" value="<?php echo $idMantenimiento; ?>">
                    <!--Input no visible con el id de la tarea-->
                    <input type="hidden" name="idTarea" value="<?php echo $idTarea; ?>">

                    <!--Título de la tarea-->
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text span" id=""><i class="fa-solid fa-briefcase icono"></i></span>
                        <input type="text" autocomplete="off" value="<?php echo $titulo ?>" class="form-control" name="titulo" placeholder="Título de la tarea" aria-label="Username" aria-describedby="addon-wrapping" required>
                    </div>
                    <!--Descripción de la tarea-->
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id=""><i class="fa-solid fa-align-left icono"></i></span>
                        <textarea class="form-control" placeholder="Descripción de la tarea" name="desc" style="height: 100px"><?php echo $desc ?></textarea>
                    </div>
                    <!--Selector del estado de la tarea-->
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id=""><i class="fa-solid fa-clipboard icono"></i></span>
                        <select class="form-select" name="estado" aria-label="Username" required>
                            <option value="">Estado de la tarea</option>
                            <?php
                            if ($estado === "Pendiente") {
                                echo '<option selected="selected" value="' . $estado . '">' . $estado . '</option>';
                                echo '<option value="En proceso">En proceso</option>';
                                echo '<option value="Finalizada">Finalizada</option>';
                            } else {
                                if ($estado === "Finalizada") {
                                    echo '<option value="Pendiente">Pendiente</option>';
                                    echo '<option value="En proceso">En proceso</option>';
                                    echo '<option selected="selected" value="' . $estado . '">' . $estado . '</option>';
                                } else {
                                    echo '<option value="Pendiente">Pendiente</option>';
                                    echo '<option selected="selected" value="' . $estado . '">' . $estado . '</option>';
                                    echo '<option value="Finalizada">Finalizada</option>';
                                }
                            }

                            ?>

                        </select>
                    </div>

                    <!--Fecha de inicio de la tarea-->
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text span" id=""><i class="fa-solid fa-calendar icono"></i></span>
                        <input type="date" autocomplete="off" value="<?php echo $inic ?>" class="form-control" name="inic" placeholder="Fecha de Inicio" aria-label="Username" aria-describedby="addon-wrapping" required>
                    </div>
                    <!--Fecha de finalización de la tarea-->
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id=""><i class="fa-solid fa-calendar icono"></i></span>
                        <input type="date" autocomplete="off" value="<?php echo $term ?>" class="form-control" name="term" placeholder="Fecha de termino" aria-label="Username" aria-describedby="addon-wrapping" required>
                    </div>

                    <!--Correo del encargado-->
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id=""><i class="fa-solid fa-user icono"></i></span>
                        <select class="form-select" name="correo" aria-label="Username" required>
                            <option value="">Seleccione un empleado</option>

                            <?php
                            require $_SERVER['DOCUMENT_ROOT'] . '/sistema web/datos/gestionMantenimiento/funcionesMantenimiento.php';

                            $ejecutar = consultarTrabajadores();

                            foreach ($ejecutar as $opciones) :

                                if ($correo === $opciones['correoTrab']) {
                            ?>

                                    <option value="<?php echo $opciones['correoTrab'] ?>" selected="selected"><?php echo $opciones['correoTrab'] ?></option>

                                <?php } else { ?>

                                    <option value="<?php echo $opciones['correoTrab'] ?>"><?php echo $opciones['correoTrab'] ?></option>


                            <?php   }
                            endforeach ?>


                        </select>
                    </div>


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
    <!-- Script de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>