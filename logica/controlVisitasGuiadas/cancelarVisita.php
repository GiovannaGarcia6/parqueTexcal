<?php
    //Insertamos código de otro archivo el cual contiene la conexión de la BD.
    require '../../datos/controlVisitasGuiadas/funcionesVisitasGuiadas.php';

    session_start();//Se inicia la sesión.
    //Se obtienen todos los datos que se mandaron al formulario.

    $id = $_GET['id'];
    $idVisita = $_GET['idVisita'];

    $cancelarVisita = rechazarVisita($idVisita);

    if($cancelarVisita === 1){
        $correo = obtenerCorreoVisitante($idVisita);
        $header = "From: parqtexc@gmail.com \r\n";
        $header .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $header .= "Mime-Version: 1.0 \r\n";
        $header .= "Content-Type: text/plain";
        $message .= "Haz cancelado tu solicitud de la visita guiada.\r\n";
        $message .= "Esperamos no hayas tenido ningún inconveniente, y si es así, puedes mandarnos un correo con lo ocurrido.\r\n\n";
        $message .= "Hasta luego, vuelve pronto...\r\n\n";

        $message .= "- Dirección: Av. El Texcal 62, Unidad Habitacional El Texcal, Jiutepec, Morelos, México. CP. 62573 \r\n";

        $asunto = 'Visita guiada cancelada';

        mail($correo, $asunto, utf8_decode($message), $header);
        $_SESSION['status'] = "Visita cancelada con éxito.";
        header("Location: ../../presentacion/visitante/visitaGuiada/solicitudVisitas.php?id=".$id);
    }else{
        //Se manda el mensaje de error y se redirigirse a la página de registrar.
        $_SESSION['status'] = "Hubo un error al eliminar.";
        header("Location: ../../presentacion/visitante/visitaGuiada/solicitudVisitas.php?id=".$id);
    }  
?>