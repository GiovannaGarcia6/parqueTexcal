<?php 
    //Archivo que nos permite acceder a las funciones del chat
    require '../../datos/chat/funcionesChat.php';
    session_start();//Se inicia la sesión.

    //Se obtienen los datos enviados por el método GET
    $id = htmlentities($_GET['id']);
    $idVisita = htmlentities($_GET['idVisita']);
    $tipoUsuario = htmlentities($_GET['tipo']);

    //Se obtienen el mensaje que envio el usuario
    $msg = htmlentities($_POST['msg']);

    //Si el tipo de usuario es igual a 1, es decir, el mensaje fue enviado por un guia
    if($tipoUsuario === '1'){
        //En la variable se almacena el resultado que se retorne de la función que se encargará de insertar un nuevo mensaje
        $enviarMensaje = enviarMensaje($idVisita,"Guia",$msg);

        //Si el resultado es exitoso, es igual a 1 
        if($enviarMensaje === 1){
            header("Location: ../../presentacion/guia/chat/chat.php?id=".$id."&idVisita=".$idVisita); //se redirige al chat
        }else{
            header("Location: ../../presentacion/guia/chat/chat.php?id=".$id."&idVisita=".$idVisita);//se redirige al chat
        }
    }else{
        //Si el tipo de usuario es un 1, el mensaje fue enviado por el visitante.
        //En la variable se almacena el resultado que se retorne de la función que se encargará de insertar un nuevo mensaje
        $enviarMensaje = enviarMensaje($idVisita,"Visitante",$msg);

        //Si el resultado es exitoso, es igual a 1 
        if($enviarMensaje === 1){
            header("Location: ../../presentacion/visitante/chat/chat.php?id=".$id."&idVisita=".$idVisita); //se redirige al chat
        }else{
            header("Location: ../../presentacion/visitante/chat/chat.php?id=".$id."&idVisita=".$idVisita); //se redirige al chat
        }
    }
?>