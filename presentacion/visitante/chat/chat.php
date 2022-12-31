<?php

    session_start();//Se inicia la sesión.
    //Se verifica que exista la variable de sesión para que el usuario pueda acceder al menú.
    if(isset($_SESSION['usuario'])){ 
        //Si existe se obtiene el id del boleto.
        $id=$_GET['id']; 
        $idVisita=$_GET['idVisita'];
        //Requerimos del archivo para realizar la conexión.
        require '../../../datos/conexionBD.php';
    }else{
        
        //En caso de que no se encuentre la variable de sesión se redirige al inicio de sesión.
        header("Location: ../../login.php");
    }    
   
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Chat</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
        <link rel="stylesheet" href="../../css/estilos_Chat.css">
        <meta http-equiv="refresh" content="10"> <!-- para refrescar la pagina-->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

        <script src="../../../logica/js/chat.js"></script>

    </head>
    <body class="grid-container">
        <div class="row">
            <nav class="col-xs-12 col-sm-12 col-md-12">
                <a href="#" class="enlace"><img src="../../media/imagenes/logo.png" alt="" class="logo"><span> Parque Estatal "El Texcal"</span></a> 
            </nav>
        </div>
        <div class="row">
            <aside id="aside" class="col-xs-12 col-sm-12 col-md-12">
                <a href="../visitaGuiada/visitasPendientes.php?id=<?php echo $id;?>">Volver</a>
            </aside>
        </div>
        <div class="row">
            
            <section id="section" class="col-xs-12 col-sm-12 col-md-12">
                <div class="col-11 col-sm-11 col-md-6 ">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 datosChat">

                            <i class="fa-solid fa-circle-user" style="font-size: 45px; color: white;"></i>
                        
                            <?php 
                                require $_SERVER['DOCUMENT_ROOT'].'/sistema web/logica/chat/chat.php';

                                mostrarDatosVisitante($idVisita,"Guia"); 
                            ?>
                        
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 display-chat" id="display-chat">
                            <?php 
                               
                               mostrarMensajes($idVisita, "Visitante");
                            ?>
                        </div>
                    </div>  
                    
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 formulario-mensaje">
                            <form method="post" action="../../../logica/chat/enviarMensaje.php?id=<?php echo $id;?>&idVisita=<?php echo $idVisita;?>&tipo=2">
                            <div class="row divcol">
                                    <div class="col-10 divcol">
                                        <textarea name="msg" class="form-control" style="color: #000;" placeholder="Escribir aquí tu mensaje..."></textarea>
                                    </div>
                                    <div class="col-2 divcol">
                                        <button type="submit" class="btn" style="font-size: 20px; margin:15%;"><i class="fa-solid fa-paper-plane"></i></button>
                                    </div>
                                    </div>
                            </form>
                        </div>
                    </div>
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