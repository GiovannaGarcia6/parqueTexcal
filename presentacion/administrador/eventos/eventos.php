<?php
    session_start();//Se inicia la sesión.
    //Se verifica que exista la variable de sesión para que el usuario pueda acceder al menú.
    if(isset($_SESSION['usuario'])){
        //Se obtiene el id del usuario
        $id = htmlentities($_GET['id']);
    }else{
        //En caso de que no se encuentre la variable de sesión se redirige al inicio de sesión.
        header("Location: ../../login/login.php");
    }      
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eventos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
        integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../css/estilos_Eventos.css">
    <link rel="stylesheet" href="../../css/fullcalendar.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body class="grid-container">
    <!--Navbar de la pagina, la cual contiene el logo y nombre del parque-->
    <div class="row">
        <nav class="col-xs-12 col-sm-12 col-md-12">
            <a href="#" class="enlace"><img src="../../media/imagenes/logo.png" alt="" class="logo"><span> Parque
                    Estatal "El Texcal"</span></a>
        </nav>
    </div>
    <!--Aside de la página en la que se encuentra el enlace de volver, esté redirige al menú del Administrador-->
    <div class="row">
        <aside id="aside" class="col-xs-12 col-sm-12 col-md-12">
            <a href="../../menu/menuAdministrador.php?id=<?php echo $id;?>">Volver</a>
        </aside>
    </div>
    <div class="row">
        <section id="section" class="col-12 col-sm-12 col-md-12">
            <?php
                    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

                    $SqlEventos   = ("SELECT * FROM Evento");
                    $resulEventos = mysqli_query($conn, $SqlEventos);

                ?>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <?php if(isset($_SESSION['status'])){ 
                                if($_SESSION['status']=='Evento agregado con éxito.' || $_SESSION['status']=='Evento actualizado con éxito.' || $_SESSION['status']=='Evento eliminado con éxito.' ){
                        ?>
                        <div id="alerta" class="alert alert-success d-flex align-items-center" role="alert">
                            <?php echo $_SESSION['status']; ?>
                        </div><br>
                        <?php   }else{?>
                        <div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert">
                            <?php echo $_SESSION['status']; ?>
                        </div> <br>
                        <?php   } header("refresh:2; url = ./eventos.php?id=".$id);unset($_SESSION['status']); } ?>
                        <!--Se elimina la variable de sesión-->

                    </div>
                    <div class="row">
                        <div class="col"></div>
                        <div class="col-12">
                            <div id="calendario"></div>
                        </div>
                        <div class="col"></div>
                    </div>
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
                            <center><img src="../../media/imagenes/logo.png" alt="" class="logoFooter"></center>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-9 datos2">
                    <div class="card-body ">
                        <p class="card-text" style="color:white; font-size:18px">© Derechos Reservados, Parque Estatal
                            "El Texcal" 2022</p>
                        <p class="card-text" style="color:Yellow; font-size:20px;">DIRECCIÓN</p>
                        <p class="card-text" style="color:white; font-size:18px;">Av. El Texcal 62, Unidad Habitacional
                            El Texcal, Jiutepec, Morelos, México. 62573</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"
        integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous">
    </script>
    <script src="../../../logica/js/jquery.min.js"></script>
    <script src="../../../logica/js/moment.min.js"></script>
    <script src="../../../logica/js/fullcalendar.min.js"></script>
    <script src="../../../logica/js/es.js"></script>
    <script>
    $(document).ready(function() {
        $('#calendario').fullCalendar({
            //Cabecera del calendario
            header: {
                left: 'today,prev,next,agregarEvento', //Izquierda
                center: 'title', //Centro
                right: 'basicDay,agendaWeek,month' //Derecha
            },

            locale: 'es',
            editable: false,
            eventLimit: true,
            selectable: true,
            selectHelper: false,
            //Propios botones que se desea que aparezcan en la cabecera del calendario
            customButtons: {
                agregarEvento: {
                    text: "Agregar Evento",
                    click: function() {
                        $("#agregarEvento").modal("show");
                    }
                }
            },

            events: [
                <?php
                while($dataEvento = mysqli_fetch_array($resulEventos)){ ?> {
                    id: '<?php echo $dataEvento['idEvento']; ?>',
                    title: '<?php echo $dataEvento['nombreEvento']; ?>',
                    descripcion: '<?php echo $dataEvento['descripcionEvento']; ?>',
                    start: '<?php echo $dataEvento['fechaInicio']; ?>',
                    end: '<?php echo $dataEvento['fechaFin']; ?>',
                    color: '<?php echo $dataEvento['colorEvento']; ?>',
                    textColor: '<?php echo $dataEvento['textColor']; ?>'

                },
                <?php } ?>
            ],

            select: function(start, end) {
                $("#agregarEvento").modal("show");
                $("#fechaInicio").val(start.format('YYYY-MM-DD'));

                var valorFechaFin = end.format("YYYY-MM-DD");
                var F_final = moment(valorFechaFin, "YYYY-MM-DD").subtract(1, 'days').format(
                    'YYYY-MM-DD'); //Le resto 1 dia
                $('#fechaFin').val(F_final);

            },

            //Eliminar Evento
            eventRender: function(event, element) {

                element
                    .find(".fc-content")
                    .prepend(
                        "<span id='btnCerrar' class='closeon' ><i class='fa-solid fa-circle-xmark'></i></span> "
                        );

                //Eliminar evento
                element.find(".closeon").on("click", function() {
                    var idAdmin = '<?php echo $id; ?>';
                    var id = event.id;
                    console.log(id);
                    console.log(idAdmin);

                    $("#modalEliminarEvento").modal("show");

                    $("#calendario").fullCalendar("removeEvents", event.id);

                    const modalEliminar = document.getElementById('modalEliminarEvento')
                    modalEliminar.addEventListener('shown.bs.modal', function() {
                        //Se  obtiene el elemento del modal con el id eliminarNegocio
                        const eliminar = modalEliminar.querySelector(
                            '#eliminarEvento')

                        //Se crea la variable action en la que se obtiene el data-bs-href que contiene el enlace de el archivo eliminarNEgocio
                        var action = eliminar.getAttribute("data-bs-href")
                        //Se asigna el href del enlace del botón
                        var enlace = action + id + "&idAdmin=" + idAdmin;
                        console.log(enlace);
                        eliminar.setAttribute("href", action + id + "&idAdmin=" +
                            idAdmin)



                    });
                });
            },

            //Modificar Evento del Calendario 
            eventClick: function(event) {
                var idEvento = event.id;
                $('input[name=idEvento').val(event.id);
                $('input[name=nombreEventoM').val(event.title);
                $('textArea[name=descripcionEventoM').val(event.descripcion);
                $('input[name=fechaInicioM').val(event.start.format('YYYY-MM-DD'));
                $('input[name=horaInicioM').val(event.start.format('HH:mm'));
                $('input[name=fechaFinM').val(event.end.format("YYYY-MM-DD"));
                $('input[name=horaFinM').val(event.end.format('HH:mm'));
                $('input[name=colorM').val(event.color);

                $("#modificarEvento").modal("show");
            }

        });
    });
    </script>


    <!-- Modal Agregar Evento -->
    <div class="modal fade" id="agregarEvento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">NUEVO EVENTO</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="formEvento" id="formEvento" action="../../../logica/gestionEvento/agregarEvento.php"
                        class="form-horizontal" method="POST">
                        <input type="hidden" name="idAdmin" value="<?php echo $id;?>">

                        <div class="mb-3 row">
                            <label class="col-sm-5 col-form-label">Nombre del Evento</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="nombreEvento" name="nombreEvento" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-5 col-form-label">Fecha de Inicio</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="fechaInicio" name="fechaInicio" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-5 col-form-label">Hora de Inicio</label>
                            <div class="col-sm-7">
                                <input type="time" class="form-control" id="horaInicio" name="horaInicio" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-5 col-form-label">Fecha de Termino</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="fechaFin" name="fechaFin" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-5 col-form-label">Hora de Termino</label>
                            <div class="col-sm-7">
                                <input type="time" class="form-control" id="horaFin" name="horaFin" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-5 col-form-label">Descripción</label>
                            <div class="col-sm-7">
                                <textarea name="descripcionEvento" class="form-control" id="descripcionEvento" cols="30"
                                    rows="3"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-5 col-form-label">Color</label>
                            <div class="col-sm-7">
                                <input type="color" class="form-control" id="color" name="color" value="#FFD607"
                                    required>
                            </div>
                        </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Eliminar-->
    <div class="modal fade" id="modalEliminarEvento" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Cabecera del modal-->
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Eliminar</h5>
                </div>
                <!-- Cuerpo del modal-->
                <div class="modal-body">
                    ¿Está seguro de eliminar el evento?
                    <br>
                    No podrá revertir la acción.
                </div>
                <!-- Pie del modal-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                        onclick="window.location.href='eventos.php?id=<?php echo $id;?>'">Cancelar</button>
                    <a id="eliminarEvento" href="" data-bs-href="../../../logica/gestionEvento/eliminarEvento.php?id=">
                        <button type="button" class="btn btn-danger">Aceptar</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Modificar Evento -->
    <div class="modal fade" id="modificarEvento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">ACTUALIZAR EVENTO</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="formEvento" id="formEvento" action="../../../logica/gestionEvento/editarEvento.php"
                        class="form-horizontal" method="POST">
                        <input type="hidden" name="idAdmin" value="<?php echo $id;?>">
                        <input type="hidden" name="idEvento" value="<?php echo $id;?>">

                        <div class="mb-3 row">
                            <label class="col-sm-5 col-form-label">Nombre del Evento</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" a id="nombreEventoM" name="nombreEventoM"
                                    required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-5 col-form-label">Fecha de Inicio</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="fechaInicioM" name="fechaInicioM" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-5 col-form-label">Hora de Inicio</label>
                            <div class="col-sm-7">
                                <input type="time" class="form-control" id="horaInicioM" name="horaInicioM" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-5 col-form-label">Fecha de Termino</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="fechaFinM" name="fechaFinM" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-5 col-form-label">Hora de Termino</label>
                            <div class="col-sm-7">
                                <input type="time" class="form-control" id="horaFinM" name="horaFinM" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-5 col-form-label">Descripción</label>
                            <div class="col-sm-7">
                                <textarea name="descripcionEventoM" class="form-control" id="descripcionEventoM"
                                    cols="30" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-5 col-form-label">Color</label>
                            <div class="col-sm-7">
                                <input type="color" class="form-control" id="colorM" name="colorM" required>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
                </form>

            </div>
        </div>
    </div>
</body>

</html>