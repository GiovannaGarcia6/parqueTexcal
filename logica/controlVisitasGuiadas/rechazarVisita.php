<?php
    //Archivo que nos permite acceder a las funciones de las visitas
    require '../../datos/controlVisitasGuiadas/funcionesVisitasGuiadas.php';

    session_start();//Se inicia la sesión.

    //Se obtienen todos los datos que fueron enviados por el método GET
    $id = htmlentities($_GET['id']);
    $idVisita = htmlentities($_GET['idVisita']);

    //Se rechaza la visita llamando a la función y enviando el id de la visita 
    $rechazarVisita = rechazarVisita($idVisita);

    //Si el resultado es 1, indica que la visita fue rechazada exitosa
    if($rechazarVisita === 1){
        //Se obtiene el correo del visitante con la función
        $correo = obtenerCorreoVisitante($idVisita);
        //Se prepara el mensaje que será enviado por correo
        $header = "From: parqtexc@gmail.com \r\n";
        $header .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $header .= "Mime-Version: 1.0 \r\n";
        $header .= "Content-Type: text/plain";
        $message .= "Su solicitud de visita guiada fue rechazada. Por favor intente de nuevo con otra fecha u otro guía disponible. \r\n";
        $message .= "Hasta luego, vuelve pronto...\r\n\n";
        $message .= "- Dirección: Av. El Texcal 62, Unidad Habitacional El Texcal, Jiutepec, Morelos, México. CP. 62573 \r\n";

        //Se envía el mensaje
        mail($correo, $asunto, utf8_decode($message), $header);

        //Se crea la variable de sesion con el mensaje correspondiente
        $_SESSION['status'] = "Visita rechazada con éxito.";
        //Se redirige a la interfaz de las solicitudes
        header("Location: ../../presentacion/guia/visitaGuiada/solicitudes.php?id=".$id);
    }else{
        //Se crea la variable de sesion con el mensaje correspondiente
        $_SESSION['status'] = "Hubo un error al rechazar la visita.";
        //Se redirige a la interfaz de las solicitudes
        header("Location: ../../presentacion/guia/visitaGuiada/solicitudes.php?id=".$id);
    }  
?>