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
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Local</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
        <link rel="stylesheet" href="../../css/estilos_Negocio.css">
    </head>
    <body class="grid-container">
        <!--Navbar de la pagina, la cual contiene el logo y nombre del parque-->
        <div class="row">
            <nav class="col-xs-12 col-sm-12 col-md-12">
                <a href="#" class="enlace"><img src="../../media/imagenes/logo.png" alt="" class="logo"><span> Parque Estatal "El Texcal"</span></a> 
            </nav>
        </div>
        <!--Aside de la página en la que se encuentra el enlace de volver, esté redirige al menú del Administrador-->
        <div class="row">
            <aside id="aside" class="col-xs-12 col-sm-12 col-md-12">
                <a href="../../menu/menuVendedor.php?id=<?php echo $id;?>">Volver</a>
            </aside>
        </div>
        <div class="row">
            <section id="section"  class="col-xs-12 col-sm-12 col-md-12">
                <div class="card col-10 offset-1 buscador">
                    <div class="row">
                        <div class="col-lg-1 col-md-1 col-sm-2 col-2">
                            <i class="fa-solid fa-shop" style="text-align: center; font-size:40px; color: #349704"></i>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-8 col-10">
                            <label class="col-form-label">Locales</label>
                        </div>
                        
                        <form class="col-12 col-sm-6" method="post">
                            <div class="row">   
                                <div class="col-9 col-sm-10">
                                    <input type="text" autocomplete="off" name="buscador" id="buscador" placeholder="Buscador" class="form-control">
                                </div>
                                <div class="col-1 ">
                                    <button type="submit" class="btn btn-primary btnBuscar"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </div>    
                        </form>
                    </div>
                </div>

                
                <br>
                <br>
                <?php 
                    //Se verifica que exista la sesión llamada status, está ayuda a saber el estado del resultado 
                    //que se retorno de la base de datos
                    if(isset($_SESSION['status'])){ 
                        //Se verifica lo que contienen la sesión, 
                        //en el que si son mensajes de éxito  se deberá crear un alert de bootstrap tipo alert-success
                        if($_SESSION['status']=='Negocio actualizado con éxito.' || $_SESSION['status']=='Negocio y productos eliminados con éxito.'){
                ?>
                            <!-- Alerta de éxito -->
                            <div class="col-10 offset-1">
                                <div id="alerta" class="alert alert-success d-flex align-items-center" role="alert">
                                    <?php echo $_SESSION['status']; ?>
                                </div>
                            </div>
                            <br>  
                <?php   }else{ ?> 
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
                        header("refresh:2; url = ./locales.php?id=".$id);
                        //Se elimina la variable de sesión
                        unset($_SESSION['status']); 
                    } 
                ?>
                
                <!--Enlace que redirige a la página del formulario de agregar boleto-->
                <div class="col-10 offset-1">
                    <a href="./agregarLocal.php?id=<?php echo $id;?>"><button class="col-12 col-sm-5 btn btnAgregar" type="button"><i class="fa-solid fa-plus"></i> Crear local</button></a>
                </div>
                <br>
                <br>

                <div class="col-10 offset-1">   
                    <?php 
                        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/logica/gestionLocal/locales.php';
                        //Se verifica que exista la variable buscador enviada por el método POST
                        if(isset($_POST['buscador'])){
                            $buscador = htmlentities($_POST['buscador']);
                            mostrarLocales($buscador,$id);
                        }else{
                            mostrarLocales("",$id);
                        }
                    ?>
                </div>
            </section>  
        </div>
        <!-- Modal -->
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
                        ¿Está seguro de eliminar este local?
                        <br>
                        Se eliminarán los productos correspondientes al local.  
                    </div>
                    <!-- Pie del modal-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                        <a id="eliminarNegocio" href="" data-bs-href="../../../logica/gestionLocal/eliminarLocal.php?idNegocio=">
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
                                <center><img src="../../media/imagenes/logo.png" alt="" class="logoFooter"></center>
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
        
        <script src="../../../logica/js/eliminarLocal.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    </body>
</html>