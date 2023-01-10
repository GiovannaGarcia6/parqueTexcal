<?php
    session_start();//Se inicia la sesión.
    //Se verifica que exista la variable de sesión para que el usuario pueda acceder al menú.
    if(isset($_SESSION['usuario'])){
        //Se obtiene el id del usuario
        $id = htmlentities($_GET['id']);
        $idPublicacion = htmlentities($_GET['idPublicacion']);
        //Requerimos del archivo para realizar la conexión.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        //Se crea un query para mostrar datos de la publicación seleccionada para modificar.
        $buscarPub=mysqli_query($conn,"SELECT titulo, descripcion, tipoPublicacion, archivo,idServicio 
        FROM Publicacion WHERE idPublicacion ='".$idPublicacion."'");
        $filas=mysqli_fetch_array($buscarPub);
        //Se obtienen los datos de la publicación.
        $titulo = $filas['titulo'];
        $descripcion = $filas['descripcion'];
        $tipoPublicacion = $filas['tipoPublicacion'];
        $archivo = $filas['archivo'];
        $idServicio = $filas['idServicio'];
        mysqli_close($conn); //Se cierra la conexión de la bd.
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
        <title>Editar Publicación</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
        <link rel="stylesheet" href="../../css/estilos_AgregarPublicacion.css">
    </head>
    <body class="grid-container">
        <!--Navbar de la pagina, la cual contiene el logo y nombre del parque-->
        <div class="row">
            <nav class="col-xs-12 col-sm-12 col-md-12">
                <a href="#" class="enlace"><img src="../../media/imagenes/logo.png" alt="" class="logo"><span> Parque Estatal "El Texcal"</span></a> 
            </nav>
        </div>
        <!--Aside de la página en la que se encuentra el enlace de volver, esté redirige a la gestión de las publicaciones-->
        <div class="row">
            <aside id="aside" class="col-xs-12 col-sm-12 col-md-12">
                <a href="./publicaciones.php?id=<?php echo $id;?>">Volver</a>
            </aside>
        </div>
        <div class="row">
            <section id="section"  class="col-12 col-sm-12 col-md-12">
                <div class="col-11 col-sm-8 col-md-4 formulario">
                    <!--Formulario para realizar la actualización de una publicación que el administrador seleccione-->
                    <form action="../../../logica/gestionPublicacion/editarPublicacion.php" method="post" enctype="multipart/form-data" > 
                        <h2  style="text-align: center">EDITAR PUBLICACIÓN</h2>
                        <!--en esta parte se verifica que exista la variable de sesión llamada status
                        la cual se encargará de muestrar el mensaje de éxito o de error que se haya enviado de la capa lógica-->
                        <?php  
                            if(isset($_SESSION['status'])){ 
                        ?>
                                <div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert">
                                    <?php echo $_SESSION['status']; ?>
                                </div> <br>  
                        <!--una vez muestre el mensaje, pasará un segundoy la pagína se refrescará para eliminar el mensaje-->   
                        <?php
                                header("refresh:1; url = ./editarPublicacion.php?id=".$id."&idPublicacion=".$idPublicacion);
                                unset($_SESSION['status']); //Se elimina la variable de sesión
                            } 
                        ?>
                        <!--Input de tipo hidden que contiene el id de la publicación-->   
                        <input type="hidden" name="idPublicacion" value="<?php echo $idPublicacion;?>">
                        <!--Input tipo hidden que contiene el id del administrador-->   
                        <input type="hidden" name="idAdmin" value="<?php echo $id;?>">
                        <!--Selector del servicio-->   
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id=""><i class="fa-solid fa-users icono"></i></span>
                            <select class="form-select" name="servicio" aria-label="Username" required>
                                <option value="">Seleccione un servicio</option>
                                <?php
                                    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/logica/gestionPublicacion/publicacionAdmin.php';
                                    mostrarServicio("True",$idServicio);
                                ?>
                            </select>
                          
                        </div>
                        <!--Titulo de la publicación-->   
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text span" id=""> <i class="fa-solid fa-file-lines icono"></i></span>
                            <input type="text" autocomplete="off" value="<?php echo $titulo;?>" class="form-control" name="titulo" placeholder="Título de la publicación" aria-label="Username" aria-describedby="addon-wrapping" required>
                        </div>
                        <!--Textarea para la descripción de la publicación-->   
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text span" id=""><i class="fa-solid fa-align-left icono"></i></span>
                            <textarea class="form-control" placeholder="Descripción de la publicación" name="publicacion" style="height: 100px"><?php echo $descripcion?></textarea>
                        </div>
                        
                        <!--Selector del tipo de archivo-->
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text"><i class="fa-solid fa-photo-film icono"></i></span>
                            <select class="form-select" name="tipoPublicacion" aria-label="Username" onchange="habilitar(this);"required>
                                <?php
                                    //Si es el mismo tipo que se obtuvo al inicio se muestra como seleccionada.
                                    if($tipoPublicacion === "Video"){
                                        echo '<option selected="selected" value="Video">Video</option>';
                                        echo '<option value="Imagen">Imagen</option>';    
                                    }else{
                                        echo '<option value="Video">Video</option>';
                                        echo '<option selected="selected" value="Imagen">Imagen</option>';    
                                    }
                                ?>
                            </select> 
                        </div>
                        
                        <?php
                            //Si es el mismo tipo que se obtuvo al inicio se muestra como seleccionada.
                            if($tipoPublicacion === "Video"){
                        ?>
                                <div id="video" class="input-group flex-nowrap">
                                    <span class="input-group-text span" id=""> <i class="fa-solid fa-link icono"></i></span>
                                    <input type="text" value="<?php echo $archivo;?>" autocomplete="off" class="form-control" name="video" placeholder="Enlace del video de Youtube" aria-label="Username" aria-describedby="addon-wrapping" >
                                </div> 
                                <div id="imagen" style="display:none;" class="input-group flex-nowrap">
                                    <span class="input-group-text span" id=""> <i class="fa-solid fa-link icono"></i></span>
                                    <input type="file" class="form-control" name="imagen"  aria-label="Username" aria-describedby="addon-wrapping" >
                                </div>
                        <?php
                            }else{
                                
                        ?>
                                <div id="video" style="display:none;" class="input-group flex-nowrap">
                                    <span class="input-group-text span" id=""> <i class="fa-solid fa-link icono"></i></span>
                                    <input type="text"  autocomplete="off" class="form-control" name="video" placeholder="Enlace del video de Youtube" aria-label="Username" aria-describedby="addon-wrapping" >
                                </div> 
                                <?php 
                                    $imagen = explode("/", $archivo);
                                ?>
                                <br>
                                <div id="mostrarImagen" class="row">
                                    <div class="col-6">
                                        <br>
                                        <small id="fileHelpId" class="form-text text-muted">Imagen guardada: <?php echo $imagen[1];?></small>
                                    </div>
                                    <div class="col-6">
                                        <img src='../../<?php echo $archivo ?>' height='100' width='200'>
                                    </div>
                                </div>

                                <div id="imagen" class="input-group flex-nowrap">
                                    <span class="input-group-text span" id=""> <i class="fa-solid fa-link icono"></i></span>
                                    <input type="file" class="form-control" value="<?php echo '../../../'.$archivo;?>" name="imagen"  aria-label="Username" aria-describedby="addon-wrapping" >

                                </div>

                               
                        <?php
                                
                            }
                        ?>
                        <!--Botón para realizar la actualización de la publicación-->   
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
        <!--EL siguiente script permite mostrar el input de la imagen o del video según sea el caso cuando el selector cambie de estado-->   
        <script>
            var inputImagen = document.getElementById('imagen');
            var inputVideo= document.getElementById('video');
            var imagenMostrada= document.getElementById('mostrarImagen');

            //Si el video esta visible, se oculta la imagen
            if(inputVideo.style.display == ''){
                inputVideo.style.display = '';
                inputImagen.style.display = 'none';
                imagenMostrada.style.display = 'none';
            }else{
                //Si el video esta oculto, la imagen esta visible
                imagenMostrada.style.display = '';
                inputImagen.style.display = '';
                inputVideo.style.display = 'none';
            }
        </script>
        <script src="../../../logica/js/habilitarInputsImagen.js"></script><!--Determina si se habilita o no el input-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    </body>
</html>