<?php
    //Archivo que nos permite acceder a las funciones de las visitas
    require '../../datos/controlVisitasGuiadas/funcionesVisitasGuiadas.php';

    session_start();//Se inicia la sesión.

    //Se obtienen los datos enviados por el método GET
    $id = htmlentities($_GET['id']);
    $idVisita = htmlentities($_GET['idVisita']);

    //Se llama a la función para que la visita que fue seleccionada sea aceptada
    $aceptarVisita = aceptarVisita($idVisita);
   
    //Si el resultado es igual a uno se envia un correo al visitante notificando que la visita ha sido aceptada
    if($aceptarVisita === 1){

        //Se obtiene el correo del visitante
        $correo = obtenerCorreoVisitante($idVisita);
        
        $header = "From: parqtexc@gmail.com \r\n";
        $header .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $header .= "Mime-Version: 1.0 \r\n";
        $header .= "Content-Type: text/plain";

        //Mensaje
        $message .= "Su solicitud de visita guiada fue aceptada. Si tienes alguna duda puedes acceder al chat que se encuentra en tu visita pendiente.\r\n\n";
        $message .= "¡Te esperamos!\r\n\n";
        $message .= "- Dirección: Av. El Texcal 62, Unidad Habitacional El Texcal, Jiutepec, Morelos, México. CP. 62573 \r\n";

        $asunto = 'Visita Guiada aceptada';

        //Se envía el correo
        mail($correo, $asunto, utf8_decode($message), $header);

        //Se crea la variable de sesión con el estatus del proceso realizado
        $_SESSION['status'] = "Visita aceptada con éxito.";

        //Se redirige a la interfaz de solicitudes
        header("Location: ../../presentacion/guia/visitaGuiada/solicitudes.php?id=".$id);
    }else{

        //Se crea la variable de sesión con el estatus del proceso realizado
        $_SESSION['status'] = "Hubo un error al aceptar.";
        
        //Se redirige a la interfaz de solicitudes
        header("Location: ../../presentacion/guia/visitaGuiada/solicitudes.php?id=".$id);
    }
?>