<?php 
    //Insertamos código de otro archivo.
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/login/funciones.php';
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionEmpleado/funcionesEmpleado.php';

    session_start();//Se inicia la sesión.

    $id = htmlentities($_GET['id']);

    //Se obtienen todos los datos que se mandaron al formulario.
    $tipoEmpleado = htmlentities($_POST['tipoEmpleado']);
    $nombre = htmlentities($_POST['nombre']);
    $apellidoPaterno = htmlentities($_POST['apPaterno']);
    $apellidoMaterno = htmlentities($_POST['apMaterno']);
    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
    $contrasena = htmlentities($_POST['contra']);

    $existe = existeUsuario($correo,0, "Correo","Trabajador");

    //Si es mayor a cero significa existe y debe redirigirse.
    if($existe > 0 ){
        $_SESSION['status'] = "El usuario ya existe.";
        header("Location: ../../presentacion/administrador/empleado/agregarEmpleado.php?id=".$id);
        exit();
    }else{
        $resultadoAgregarEmpleado = agregarEmpleado($tipoEmpleado, $nombre, $apellidoPaterno, $apellidoMaterno, $correo, $contrasena);
        
        if($resultadoAgregarEmpleado === 1){
            //Sentencias para generar el correo hacia el trabajador con sus datos
            $header = "From: parqtexc@gmail.com \r\n";
            $header .= "X-Mailer: PHP/" . phpversion() . "\r\n";
            $header .= "Mime-Version: 1.0 \r\n";
            $header .= "Content-Type: text/plain";

            $message = "¡Hola " . $nombre . "! \r\n";
            $message .= "Haz sido registrado en el sistema del Parque El Texcal como ". $tipoEmpleado .", BIENVENID@!! \r\n";
            $message .= "Su contraseña es: " . $contrasena . " \r\n";

            $asunto = 'Registro en el Sistema Parque el Texcal';

            mail($correo, $asunto, utf8_decode($message), $header);

            $_SESSION['status'] = "Empleado registrado con éxito.";
            header("Location: ../../presentacion/administrador/empleado/agregarEmpleado.php?id=".$id);
        }else{
            //Se manda el mensaje de error y se redirigirse a la página de agregarEmpleado.
            $_SESSION['status'] = "Hubo un error al registrar.";
            header("Location: ../../presentacion/administrador/empleado/agregarEmpleado.php?id=".$id);
        }
    }
?>
