<?php 
    require '../../datos/chat/funcionesChat.php';
    session_start();//Se inicia la sesión.
    $id = $_GET['id'];
    $idVisita = $_GET['idVisita'];
    $tipoUsuario = $_GET['tipo'];

    //Se obtienen todos los datos que se mandaron al formulario.
    $msg = $_POST['msg'];

    if($tipoUsuario === '1'){
        $enviarMensaje = enviarMensaje($idVisita,"Guia",$msg);
        if($enviarMensaje === 1){
            header("Location: ../../presentacion/guia/chat/chat.php?id=".$id."&idVisita=".$idVisita); 
        }else{
            header("Location: ../../presentacion/guia/chat/chat.php?id=".$id."&idVisita=".$idVisita);
        }
    }else{
        $enviarMensaje = enviarMensaje($idVisita,"Visitante",$msg);
        if($enviarMensaje === 1){
            header("Location: ../../presentacion/visitante/chat/chat.php?id=".$id."&idVisita=".$idVisita); 
        }else{
            header("Location: ../../presentacion/visitante/chat/chat.php?id=".$id."&idVisita=".$idVisita);
        }
    }
   

       
  

?>