<?php 
    //Insertamos código de otro archivo el cual contiene la conexión de la BD.
    require '../../datos/login/funciones.php';
   
    session_start();//Se inicia la sesión.
    //Se obtienen todos los datos que se mandaron al formulario.

    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
 
    //Se realiza un conteo de cuantos vistantes tienen el mismo correo.
    $resultado = existeUsuario($correo,0,"Correo","Visitante");

    //Si es mayor a cero significa que la clave ya existe y debe redirigirse a la página de registrar.
    if($resultado > 0 ){
        $datos = obtenerDatos($correo,"Correo","Visitante");
        $id = $datos['idVisitante'];
        $nombre = $datos['nombVisit'];
        
        //Sentencias para generar el correo hacia el trabajador con sus datos
        $header = "From: parqtexc@gmail.com \r\n";
        $header .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $header .= "Mime-Version: 1.0 \r\n";
        $header .= "Content-Type: text/plain";

        $message = "Hola, " . $nombre . ": \r\n";
        $message .= "Hemos detectado que requieres recuperar tu contraseña... \r\n\n";
        $message .= "Accede a este link para crear tu nueva contraseña:  \r\n";
        $message .= "http://127.0.0.1/Sistema%20Web/presentacion/login/nuevaContrasena.php?id=" . $id . " \r\n\n";

        $asunto = 'Recuperación de Contraseña';

        mail($correo, $asunto, utf8_decode($message), $header);

        $_SESSION['status'] = "Revisa la bandeja de tu correo electrónico.";
        header("Location: ../../presentacion/login/recuperarContrasena.php");


    }else{
        //Se verifica que exista un trabajador con dicho correo.
        $resultado = existeUsuario($correo,0,"Correo","Trabajador");

        //Si es mayor a cero significa que el trabajador existe.
        if($resultado > 0 ){
        
            $datos = obtenerDatos($correo,"Correo","Trabajador");
            //Se obtienen los datos del trabajador;
            $id = $datos['idTrabajador'];
            $nombre = $datos['nombreTrab'];
            //Sentencias para generar el correo hacia el trabajador con sus datos
            $header = "From: parqtexc@gmail.com \r\n";
            $header .= "X-Mailer: PHP/" . phpversion() . "\r\n";
            $header .= "Mime-Version: 1.0 \r\n";
            $header .= "Content-Type: text/plain";

            $message = "Hola, " . $nombre . ": \r\n";
            $message .= "Hemos detectado que requieres recuperar tu contraseña... \r\n\n";
            $message .= "Accede a este link para crear tu nueva contraseña:  \r\n";
            $message .= "http://127.0.0.1/Sistema%20Web/presentacion/login/nuevaContrasena.php?id=" . $id . " \r\n\n";

            $asunto = 'Recuperación de Contraseña';

            mail($correo, $asunto, utf8_decode($message), $header);
    
            $_SESSION['status'] = "Revisa la bandeja de tu correo electrónico.";
            header("Location: ../../presentacion/login/recuperarContrasena.php");

        }else{

            //Se manda el mensaje de error y se redirigirse a la página de registrar.
            $_SESSION['status'] = "Hubo un error al recuperar la contraseña.";
            header("Location: ../../presentacion/login/recuperarContrasena.php");
        }

    }
?>
