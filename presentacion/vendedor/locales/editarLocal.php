<?php

    session_start();//Se inicia la sesión.
    //Se verifica que exista la variable de sesión para que el usuario pueda acceder al menú.
    if(isset($_SESSION['usuario'])){ 
        //Si existe se obtiene el id del boleto.
        $idNegocio = htmlentities($_GET['id']);
        //Requerimos del archivo para realizar la conexión.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        //Se crea un query para mostrar datos del negocio seleccionado para modificar.
        $buscarBoleto=mysqli_query($conn,"SELECT nombTienda,idTrabajador FROM Tienda WHERE idTienda ='".$idNegocio."'");
        $filas=mysqli_fetch_array($buscarBoleto);
        //Se obtienen los datos del negocio.
        $nombreNegocio= $filas['nombTienda'];
        $idVendedor= $filas['idTrabajador'];
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
        <title>Taquilla</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
        <link rel="stylesheet" href="../../css/estilos_AgregarNegocio.css">
    </head>
    <body class="grid-container">
        <div class="row">
            <nav class="col-xs-12 col-sm-12 col-md-12">
                <a href="#" class="enlace"><img src="../../media/imagenes/logo.png" alt="" class="logo"><span> Parque Estatal "El Texcal"</span></a> 
            </nav>
        </div>
        <div class="row">
            <aside id="aside" class="col-xs-12 col-sm-12 col-md-12">
                <a href="./locales.php?id=<?php echo $idVendedor;?>">Volver</a>
            </aside>
        </div>
        <div class="row">
            <section id="section"  class="col-xs-12 col-sm-12 col-md-12">
                <div class="col-xs-12 col-sm-8 col-md-4 formulario">
                    <form action="../../../logica/gestionLocal/editarLocal.php" method="post"> 
                        <h2 class="mb-5" style="text-align: center"></i>EDITAR NEGOCIO</h2>
                        <!--Se muestra el mensaje de éxito o de error-->
                        <?php if(isset($_SESSION['status'])){ 
                          if($_SESSION['status']=='Negocio actualizado con éxito.'){
                        ?>
                        <div id="alerta" class="alert alert-success d-flex align-items-center" role="alert">
                          <?php echo $_SESSION['status']; ?>
                          
                        </div><br>  
                        <?php }else{?> 
                        <div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert">
                          <?php echo $_SESSION['status']; ?>
                        
                        </div> <br>     
                        <?php } header("refresh:1; url = ./editarLocal.php?id=".$idNegocio);unset($_SESSION['status']); } ?><!--Se elimina la variable de sesión-->
                        
                        <input type="hidden" name="idNegocio" value="<?php echo $idNegocio;?>">
                        <input type="hidden" name="idVendedor" value="<?php echo $idVendedor;?>">
                        <!--Nombre del boleto-->
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id=""><i class="fa-solid fa-shop icono"></i></span>
                            <input type="text" autocomplete="off" value="<?php echo $nombreNegocio?>" class="form-control" name="nombreNegocio" placeholder="Nombre del negocio" aria-label="Username" aria-describedby="addon-wrapping" required>
                        </div>
                       
                        <button class="btnAceptar btn-lg" type="submit">Aceptar</button>
                    </form>       
                </div>
                
            </section>  
        </div>
        <div class="row">
            <footer>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 footer1"> </div>
                </div>
                <div class="row">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-3 opc">
                        <div class="logo">
                            <div class="card-body">
                                <img src="../../media/imagenes/logo.png" alt="" class="logoFooter">
                                
                            </div>
                        </div>
                    </div>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    </body>
</html>