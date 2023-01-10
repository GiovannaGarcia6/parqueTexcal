<?php
    //Archivo que nos permite acceder a las funciones de las visitas
    require '../../datos/controlVisitasGuiadas/funcionesVisitasGuiadas.php';

    session_start();//Se inicia la sesión.
    
    //Se obtienen todos los datos que fueron enviados por el método GET
    $id = htmlentities($_GET['id']);
    $idVisita = htmlentities($_GET['idVisita']);

    //Se cancela la visita, llamando a la función y enviando el id de la visita 
    $cancelarVisita = rechazarVisita($idVisita);

    //Si el resultado es 1, indica que la cancelación fue exitosa
    if($cancelarVisita === 1){
        //Se obtiene el correo del visitante con la función
        $correo = obtenerCorreoVisitante($idVisita);

        //Se prepara el mensaje que será enviado por correo
        $header = "From: parqtexc@gmail.com \r\n";
        $header .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $header .= "Mime-Version: 1.0 \r\n";
        $header .= "Content-Type: text/plain";
        $message .= "Haz cancelado tu solicitud de la visita guiada.\r\n";
        $message .= "Esperamos no hayas tenido ningún inconveniente, y si es así, puedes mandarnos un correo con lo ocurrido.\r\n\n";
        $message .= "Hasta luego, vuelve pronto...\r\n\n";

        $message .= "- Dirección: Av. El Texcal 62, Unidad Habitacional El Texcal, Jiutepec, Morelos, México. CP. 62573 \r\n";

        $asunto = 'Visita guiada cancelada';

        //Se envía el mensaje
        mail($correo, $asunto, utf8_decode($message), $header);

        //Se crea la variable de sesion con el mensaje correspondiente
        $_SESSION['status'] = "Visita cancelada con éxito.";
        //Se redirige a la interfaz de las solicitudes
        header("Location: ../../presentacion/visitante/visitaGuiada/solicitudVisitas.php?id=".$id);
    }else{
        //Se crea la variable de sesion con el mensaje correspondiente
        $_SESSION['status'] = "Hubo un error al cancelar la visita.";
         //Se redirige a la interfaz de las solicitudes
        header("Location: ../../presentacion/visitante/visitaGuiada/solicitudVisitas.php?id=".$id);
    }  
?>