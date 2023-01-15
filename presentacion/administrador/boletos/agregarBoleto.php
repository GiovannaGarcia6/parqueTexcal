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
        <title>Agregar boleto</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
        <link rel="stylesheet" href="../../css/estilos_AgregarBoleto.css">
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
                <a href="./boletos.php?id=<?php echo $id;?>">Volver</a>
            </aside>
        </div>
        <div class="row">
            <section id="section"  class="col-12 col-sm-12 col-md-12">
                <div class="col-11 col-sm-8 col-md-4 formulario">
                    <!--Formulario para agregar un boleto-->
                    <form action="../../../logica/gestionBoleto/agregarBoleto.php" method="post"> 
                        <h2 class="mb-5" style="text-align: center"></i>NUEVA TARIFA</h2>
                        <!--Se muestra el mensaje de éxito o de error-->
                        <?php if(isset($_SESSION['status'])){ 
                          if($_SESSION['status']=='Tarifa registrada con éxito.'){
                        ?>
                        <div id="alerta" class="alert alert-success d-flex align-items-center" role="alert">
                          <?php echo $_SESSION['status']; ?>
                          
                        </div> 
                        <?php }else{?> 
                        <div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert">
                          <?php echo $_SESSION['status']; ?>
                        
                        </div>  
                        <?php } header("refresh:1; url = ./agregarBoleto.php?id=$id");unset($_SESSION['status']); } ?><!--Se elimina la variable de sesión-->
                        
                        <!--Id del administrador-->
                        <input type="hidden" name="id" value="<?php echo $id;?>">

                        <!--Nombre del boleto-->
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-ticket-perforated" viewBox="0 0 16 16">
                                    <path d="M4 4.85v.9h1v-.9H4Zm7 0v.9h1v-.9h-1Zm-7 1.8v.9h1v-.9H4Zm7 0v.9h1v-.9h-1Zm-7 1.8v.9h1v-.9H4Zm7 0v.9h1v-.9h-1Zm-7 1.8v.9h1v-.9H4Zm7 0v.9h1v-.9h-1Z"/>
                                    <path d="M1.5 3A1.5 1.5 0 0 0 0 4.5V6a.5.5 0 0 0 .5.5 1.5 1.5 0 1 1 0 3 .5.5 0 0 0-.5.5v1.5A1.5 1.5 0 0 0 1.5 13h13a1.5 1.5 0 0 0 1.5-1.5V10a.5.5 0 0 0-.5-.5 1.5 1.5 0 0 1 0-3A.5.5 0 0 0 16 6V4.5A1.5 1.5 0 0 0 14.5 3h-13ZM1 4.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v1.05a2.5 2.5 0 0 0 0 4.9v1.05a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-1.05a2.5 2.5 0 0 0 0-4.9V4.5Z"/>
                                </svg>
                            </span>
                            <input type="text" autocomplete="off" class="form-control" name="nombre" placeholder="Nombre del boleto" aria-label="Username" aria-describedby="addon-wrapping" required>
                        </div>

                        <!--Precio del boleto-->
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id=""><i class="fa-solid fa-dollar-sign"></i></span>
                            <input type="text" autocomplete="off" class="form-control" name="precio" placeholder="Precio del boleto" aria-label="Username" aria-describedby="addon-wrapping" required>
                        </div>
                    
                        <!--Selector del servicio-->
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id=""><i class="fa-solid fa-users"></i></span>
                            <select class="form-select" id="servicio" name="servicio" aria-label="Username" required>
                                <option value="">Seleccione un servicio</option>
                                <?php
                                    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/logica/gestionComentario/comentarios.php';
                                    mostrarServicios(FALSE, 0);
                                ?>
                            </select>
                          
                        </div>
                        <!--Botón para agregar el boleto-->
                        <button class="btnAceptar btn-lg" type="submit">Agregar</button>
                    </form>       
                </div>
                
            </section>  
        </div>
        <div class="row">
            <!-- Footer de la página en la que contiene el logo y los datos de la empresa-->
            <footer>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 footer1"> </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-3 datos">
                        <div class="logo">
                            <div class="card-body">
                            <center><img src="../../media/imagenes/logo.png" alt="" class="logoFooter"><center>                    
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-9 datos2">
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
        <!--Script de Bootstrap-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    </body>
</html>