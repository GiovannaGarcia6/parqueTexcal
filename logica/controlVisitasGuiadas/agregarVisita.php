<?php 
    //Archivo que nos permite acceder a las funciones de las visitas
    require '../../datos/controlVisitasGuiadas/funcionesVisitasGuiadas.php';

    session_start();//Se inicia la sesión.

    //Se obtienen los datos enviados por el método GET
    $idVisitante =  htmlentities($_GET['id']);

    //Se obtienen todos los datos que se mandaron al formulario.
    $fecha = strtotime($_POST['fecha']);
    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);

    //Se realiza una consulta a la base de datos para obtener el resultado de si exiten mas visitas pendientes del visitante
    $visitaEnEspera = visitasEnEspera($idVisitante);

    //Si el resultado es mayor a 0, significa que no puede realizar otra visita hasta que la visita pendiente sea cambiada de estatus
    if($visitaEnEspera > 0 ){
        //Se crea la variable de sesión con el mensaje correspondiente
        $_SESSION['status'] = "Ya tiene una solicitud de visita, espere a que sea aceptada o rechazada.";
        //Se redirige a la interfaz de agregar visita
        header("Location: ../../presentacion/visitante/visitaGuiada/agregarVisita.php?id=".$idVisitante);
        exit();
    }else{
        //Sino existen visitas en espera, se obtiene el id del trabajador
        $idTrab = obtenerIdTrabajadorXCorreo($correo);
        
        //Se envían los datos para agregar una nueva visita
        $resultadoAgregarVisita = agregarVisita($fecha, $idVisitante, $idTrab);

        //Si el resultado es igual a 1, la visita fue agregada correctamente
        if($resultadoAgregarVisita === 1){

            //Se crea el mensaje que se enviara por correo
            $header = "From: parqtexc@gmail.com \r\n";
            $header .= "X-Mailer: PHP/" . phpversion() . "\r\n";
            $header .= "Mime-Version: 1.0 \r\n";
            $header .= "Content-Type: text/plain";

            $message .= "Tiene una nueva solicitud de visita guiada, consulte su bandeja dentro del sistema del Parque Texcal. \r\n";

            $asunto = 'Solicitud de visita guiada';

            //Se envía el mensaje
            mail($correo, $asunto, utf8_decode($message), $header);

            //Se crea la variable de sesion con el mensaje correspondiente
            $_SESSION['status'] = "Visita solicitada con éxito.";
            //Se redirige a la interfaz del formulario de agregar visita
            header("Location: ../../presentacion/visitante/visitaGuiada/agregarVisita.php?id=".$idVisitante); 
        }else{
            //Se crea la variable de sesion con el mensaje correspondiente
            $_SESSION['status'] = "Hubo un error al hacer la solicitud.";
            //Se redirige a la interfaz del formulario de agregar visita
            header("Location: ../../presentacion/visitante/visitaGuiada/agregarVisita.php?id=".$idVisitante);
        }
    }
    

?>