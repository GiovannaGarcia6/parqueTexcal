<?php
    require '../../datos/controlVisitasGuiadas/funcionesVisitasGuiadas.php';

    session_start();//Se inicia la sesión.

    $id = $_GET['id'];
    $idVisita = $_GET['idVisita'];

    $rechazarVisita = rechazarVisita($idVisita);

    if($rechazarVisita === 1){

        $correo = obtenerCorreoVisitante($idVisita);

        $header = "From: parqtexc@gmail.com \r\n";
        $header .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $header .= "Mime-Version: 1.0 \r\n";
        $header .= "Content-Type: text/plain";
        $message .= "Su solicitud de visita guiada fue rechazada. Por favor intente de nuevo con otra fecha u otro guía disponible. \r\n";
        $message .= "Hasta luego, vuelve pronto...\r\n\n";
        $message .= "- Dirección: Av. El Texcal 62, Unidad Habitacional El Texcal, Jiutepec, Morelos, México. CP. 62573 \r\n";

        $asunto = 'Visita guiada rechazada';
        
        mail($correo, $asunto, utf8_decode($message), $header);
        $_SESSION['status'] = "Visita rechazada con éxito.";
        header("Location: ../../presentacion/guia/visitaGuiada/solicitudes.php?id=".$id);
    }else{
        $_SESSION['status'] = "Hubo un error al eliminar.";
        header("Location: ../../presentacion/guia/visitaGuiada/solicitudes.php?id=".$id);
    }  
?>