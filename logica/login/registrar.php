<?php
    //Insertamos código de otro archivo el cual contiene la conexión de la BD.
    require '../../datos/login/funciones.php';
    session_start();//Se inicia la sesión.
    //Se obtienen todos los datos que se mandaron al formulario.
    $nombre = html_entity_decode($_POST['nombre'], ENT_QUOTES | ENT_HTML401, "UTF-8");
    $apellidoPaterno = html_entity_decode($_POST['apPaterno'], ENT_QUOTES | ENT_HTML401, "UTF-8");
    $apellidoMaterno = html_entity_decode($_POST['apMaterno'], ENT_QUOTES | ENT_HTML401, "UTF-8");
    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
    $contrasena = htmlentities($_POST['contra']);
    
    $resultado = existeUsuario($correo,0, "Correo","Visitante");

    //Si es igual cero significa que la clave ya existe y debe redirigirse a la página de registrar.
    if($resultado > 0 ){
       $_SESSION['status'] = "El usuario ya existe.";
       header("Location: ../../presentacion/login/registrar.php");
       exit();
    }else{
        $registrado = registrarVisitante($nombre, $apellidoMaterno, $apellidoPaterno, $correo, $contrasena);
        if($registrado === 1){
            //Sentencias para generar el correo hacia el trabajador con sus datos
            $header = "From: parqtexc@gmail.com \r\n";
            $header .= "X-Mailer: PHP/" . phpversion() . "\r\n";
            $header .= "Mime-Version: 1.0 \r\n";
            $header .= "Content-Type: text/plain";

            $message = "¡Hola " . $nombre . "! \r\n";
            $message .= "B I E N V E N I D @ \r\n\n";
            $message .= "Te haz registrado en el sistema del Parque El Texcal \r\n";
            $message .= "Tu contraseña es: " . $contrasena . " \r\n\n";
            
            $message .= "Disfruta de los servicios que tenemos para ti\r\n";
            $message .= "¡Te esperamos! \r\n\n";

            $message .= "- Dirección: Av. El Texcal 62, Unidad Habitacional El Texcal, Jiutepec, Morelos, México. CP. 62573 \r\n";

            $asunto = 'Registro en el Sistema Parque el Texcal';

            mail($correo, $asunto, utf8_decode($message), $header);


            $_SESSION['status'] = "Registrado con éxito.";
            header("Location: ../../presentacion/login/registrar.php");

        }else{
            //Se manda el mensaje de error y se redirigirse a la página de registrar.
            $_SESSION['status'] = "Hubo un error al registrar.";
            header("Location: ../../presentacion/login/registrar.php");
        }

    }
?>