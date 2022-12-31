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
        <title>Nuevo comentario</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
        <link rel="stylesheet" href="../../css/estilos_AgregarComentario.css">
    </head>
    <body class="grid-container">
        <div class="row">
            <nav class="col-xs-12 col-sm-12 col-md-12">
                <a href="#" class="enlace"><img src="../media/imagenes/logo.png" alt="" class="logo"><span> Parque Estatal "El Texcal"</span></a> 
            </nav>
        </div>
        <div class="row">
            <aside id="aside" class="col-xs-12 col-sm-12 col-md-12">
                <a href="./comentarios.php?id=<?php echo $id;?>">Volver</a>
            </aside>
        </div>
        <div class="row">
            <section id="section"  class="col-xs-12 col-sm-12 col-md-12">
                <div class="col-xs-12 col-sm-8 col-md-4 formulario">
                    <form action="../../../logica/gestionComentario/agregarComentario.php" method="post"> 
                        <h2  style="text-align: center">NUEVO COMENTARIO</h2>
                        <!--Se muestra el mensaje de éxito o de error-->
                        <?php if(isset($_SESSION['status'])){ 
                                if($_SESSION['status']=='Comentario enviado con éxito.'){
                        ?>
                                    <div id="alerta" class="alert alert-success d-flex align-items-center" role="alert">
                                        <?php echo $_SESSION['status']; ?>
                                    </div><br>  
                        <?php   }else{?> 
                                    <div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert">
                                    <?php echo $_SESSION['status']; ?>
                                    </div> <br>     
                        <?php   } header("refresh:1; url = ./agregarComentario.php?id=".$id);unset($_SESSION['status']); } ?><!--Se elimina la variable de sesión-->
                        
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                         <!--Selector del servicio-->
                         <div class="input-group flex-nowrap">
                            <span class="input-group-text" id=""><i class="fa-solid fa-users icono"></i></span>
                            <select class="form-select" name="servicio" aria-label="Username" required>
                                <option value="">Seleccione un servicio</option>
                                <?php
                                    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/logica/gestionComentario/comentarios.php';
                                    mostrarServicios(FALSE, 0);
                                ?>
                            </select>
                          
                        </div>

                        <!--Selector de la puntuación-->
                         <div class="input-group flex-nowrap">
                            <span class="input-group-text"><i class="fa-solid fa-star icono"></i></span>
                            <select class="form-select" name="puntuacion" aria-label="Username" required>
                                <option value="">Puntuación</option>
                                <?php
                                   for($puntuacion=1; $puntuacion<=5; $puntuacion++){
                                        echo '<option value="'.$puntuacion.'">'.$puntuacion.' Estrellas</option>';
                                   }
                                ?>
                            </select>
                          
                        </div>
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text span" id=""> <i class="fa-solid fa-message icono"></i></span>
                            <textarea class="form-control" placeholder="Comentario" name="comentario" style="height: 100px"></textarea>
                        </div>

                        <button class="btnRegistrar btn-lg" type="submit">Registrar</button>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    </body>
</html>