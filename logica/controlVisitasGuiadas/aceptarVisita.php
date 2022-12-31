<?php
    require '../../datos/controlVisitasGuiadas/funcionesVisitasGuiadas.php';

    session_start();//Se inicia la sesión.

    $id = $_GET['id'];
    $idVisita = $_GET['idVisita'];


    $aceptarVisita = aceptarVisita($idVisita);
   
    if($aceptarVisita === 1){
        $correo = obtenerCorreoVisitante($idVisita);
        
        $header = "From: parqtexc@gmail.com \r\n";
        $header .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $header .= "Mime-Version: 1.0 \r\n";
        $header .= "Content-Type: text/plain";

        $message .= "Su solicitud de visita guiada fue aceptada. Si tienes alguna duda puedes acceder al chat que se encuentra en tu visita pendiente.\r\n\n";
        $message .= "¡Te esperamos!\r\n\n";
        $message .= "- Dirección: Av. El Texcal 62, Unidad Habitacional El Texcal, Jiutepec, Morelos, México. CP. 62573 \r\n";

        $asunto = 'Visita Guiada aceptada';

        
        mail($correo, $asunto, utf8_decode($message), $header);

        $_SESSION['status'] = "Visita aceptada con éxito.";
        header("Location: ../../presentacion/guia/visitaGuiada/solicitudes.php?id=".$id);
    }else{
        $_SESSION['status'] = "Hubo un error al aceptar.";
        header("Location: ../../presentacion/guia/visitaGuiada/solicitudes.php?id=".$id);
    }
?>