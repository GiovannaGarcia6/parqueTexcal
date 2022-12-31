<?php 
    //Insertamos código de otro archivo el cual contiene la conexión de la BD.
    require '../../datos/controlVisitasGuiadas/funcionesVisitasGuiadas.php';
    session_start();//Se inicia la sesión.
    $idVisitante =  htmlentities($_GET['id']);
    //Se obtienen todos los datos que se mandaron al formulario.
    $fecha = strtotime($_POST['fecha']);

    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);

    $visitaEnEspera = visitasEnEspera($idVisitante);

    if($visitaEnEspera > 0 ){
        $_SESSION['status'] = "Ya tiene una solicitud de visita, espere a que sea aceptada o rechazada.";
        header("Location: ../../presentacion/visitante/visitaGuiada/agregarVisita.php?id=".$idVisitante);
        exit();
    }else{
        $idTrab = obtenerIdTrabajadorXCorreo($correo);
        
        $resultadoAgregarVisita = agregarVisita($fecha, $idVisitante, $idTrab);

        if($resultadoAgregarVisita === 1){
            //Sentencias para generar el correo hacia el trabajador con sus datos
            $header = "From: parqtexc@gmail.com \r\n";
            $header .= "X-Mailer: PHP/" . phpversion() . "\r\n";
            $header .= "Mime-Version: 1.0 \r\n";
            $header .= "Content-Type: text/plain";

            $message .= "Tiene una nueva solicitud de visita guiada, consulte su bandeja dentro del sistema del Parque Texcal. \r\n";

            $asunto = 'Solicitud de visita guiada';

            mail($correo, $asunto, utf8_decode($message), $header);

            $_SESSION['status'] = "Visita solicitada con éxito.";
            header("Location: ../../presentacion/visitante/visitaGuiada/agregarVisita.php?id=".$idVisitante);
        }else{
            //Se manda el mensaje de error y se redirigirse a la página de agregarEmpleado.
            $_SESSION['status'] = "Hubo un error al hacer la solicitud.";
            header("Location: ../../presentacion/visitante/visitaGuiada/agregarVisita.php?id=".$idVisitante);
        }
    }
    

?>