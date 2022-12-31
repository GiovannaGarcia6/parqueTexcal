<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Eventos</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
        <link rel="stylesheet" href="css/estilos_EventosHome.css">
        <link rel="stylesheet" href="css/fullcalendar.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body class="grid-container">
        <div class="row">
            <nav>
                <input type="checkbox" id="check">
                <label for="check" class="checkbtn"><i class="fas fa-bars"></i></label>
                <a href="#" class="enlace">
                    <img src="media/imagenes/logo.png" alt="" class="logo">
                    <span>Parque Estatal "El Texcal"</span>
                </a>
                <ul>
                    <li><a href="../index.php">Inicio</a></li>
                    <li><a href="login/registrar.php">Registrarse</a></li>
                    <li><a href="login/login.php">Iniciar Sesión</a></li>
                    
                </ul>
            </nav>
        </div>
        
        <div class="row">
            <aside id="aside" class="col-xs-12 col-sm-12 col-md-12">
                <p>EVENTOS</p>
            </aside>
        </div>
        <div class="row">
            <section id="section"  class="col-12 col-sm-12 col-md-12">
                <?php
                    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

                    $SqlEventos   = ("SELECT * FROM Evento");
                    $resulEventos = mysqli_query($conn, $SqlEventos);

                ?>
                <div class="container">
                    
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
                                <center><img src="media/imagenes/logo.png" alt="" class="logoFooter"></center>
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

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>    
        <script src="../logica/js/jquery.min.js"></script>
        <script src="../logica/js/moment.min.js"></script>
        <script src="../logica/js/fullcalendar.min.js"></script>
        <script src="../logica/js/es.js"></script>
        <script>
            $(document).ready(function(){
                $('#calendario').fullCalendar({
                    //Cabecera del calendario
                    header:{
                        left: 'today,prev,next,agregarEvento', //Izquierda
                        center: 'title', //Centro
                        right: 'basicDay,agendaWeek,month' //Derecha
                    },

                    locale: 'es',
                    editable: false,
                    eventLimit: false, 
                    selectable: false,
                    selectHelper: false,
                   
                    events: [
                        <?php
                        while($dataEvento = mysqli_fetch_array($resulEventos)){ ?>
                        {
                        id: '<?php echo $dataEvento['idEvento']; ?>',
                        title: '<?php echo $dataEvento['nombreEvento']; ?>',
                        descripcion: '<?php echo $dataEvento['descripcionEvento']; ?>',
                        start: '<?php echo $dataEvento['fechaInicio']; ?>',
                        end:   '<?php echo $dataEvento['fechaFin']; ?>',
                        color: '<?php echo $dataEvento['colorEvento']; ?>',
                        textColor: '<?php echo $dataEvento['textColor']; ?>'

                        },
                        <?php } ?>
                    ],
                    eventClick:function(event){

                        document.getElementById('nombreEvento').innerHTML = event.title;
                        document.getElementById('fechaInicio').innerHTML = event.start.format('YYYY-MM-DD') + " " + event.start.format('HH:mm');
                        document.getElementById('fechaFin').innerHTML = event.end.format('YYYY-MM-DD') + " " + event.end.format('HH:mm');
                        document.getElementById('descripcionEvento').innerHTML = event.descripcion;

                        $("#mostrarEvento").modal("show");
                    }
                });
            });

        </script>

        <!-- Modal para mostrar los datos de un Evento -->
        <div class="modal fade" id="mostrarEvento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" style="color:#00627F;" id="nombreEvento" name="nombreEvento"></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <center><img src="media/imagenes/evento.png" class="img-fluid" alt="..."></center>
                        <br>
                        <div class="mb-3 row">
                            <label class="col-sm-10 col-form-label" style="color:#00627F;"><b><i class="fa-solid fa-calendar-days"></i> Fecha y hora de inicio:</b></label>
                            <div class="col-sm-10">
                                <label class="col-form-label" id="fechaInicio" name="fechaInicio"> </label>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-10 col-form-label" style="color:#00627F;"><b><i class="fa-solid fa-calendar-days"></i> Fecha y hora de termino:</b></label>
                            <div class="col-sm-10">
                                <label class="col-form-label" id="fechaFin" name="fechaFin"> </label>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-10 col-form-label" style="color:#00627F;"><b><i class="fa-solid fa-circle-info"></i> Información del evento:</b></label>
                            <div class="col-sm-10">
                                <p class="col-form-label" id="descripcionEvento" name="descripcionEvento"> </p>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </body>
</html>