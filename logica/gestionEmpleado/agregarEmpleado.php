<?php 
    //Insertamos código de otros archivos para poder acceder a más funciones
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/login/funciones.php';
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionEmpleado/funcionesEmpleado.php';

    session_start();//Se inicia la sesión.

    //Se obtiene el id enviado por el método GET
    $id = htmlentities($_GET['id']); 

    //Se obtienen todos los datos que se mandaron al formulario.
    $tipoEmpleado = htmlentities($_POST['tipoEmpleado']);
    $nombre = html_entity_decode($_POST['nombre'], ENT_QUOTES | ENT_HTML401, "UTF-8");
    $apellidoPaterno = html_entity_decode($_POST['apPaterno'], ENT_QUOTES | ENT_HTML401, "UTF-8");
    $apellidoMaterno = html_entity_decode($_POST['apMaterno'], ENT_QUOTES | ENT_HTML401, "UTF-8");
    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
    $contrasena = htmlentities($_POST['contra']);

    //Se consulta a la base de datos para saber si existe el usuario
    $existe = existeUsuario($correo,0, "Correo","Trabajador");

    //Si es mayor a cero significa que existe y debe redirigirse.
    if($existe > 0 ){
        $_SESSION['status'] = "El usuario ya existe.";
        header("Location: ../../presentacion/administrador/empleado/agregarEmpleado.php?id=".$id);
        exit();
    }else{
        //sino, se realiza la inserción del nuevo empleado con los datos obtenidos del formulario
        $resultadoAgregarEmpleado = agregarEmpleado($tipoEmpleado, $nombre, $apellidoPaterno, $apellidoMaterno, $correo, $contrasena);
        
        //Si el resultado es 1, la inserción se realizó correctamente. En cambio, si fue 0, hubo un error en la ejecución.
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

            //Se envía el correo
            mail($correo, $asunto, utf8_decode($message), $header);

            //Se crea la variable de sesión con el mensaje a mostrar en la interfaz
            $_SESSION['status'] = "Empleado registrado con éxito.";
            header("Location: ../../presentacion/administrador/empleado/agregarEmpleado.php?id=".$id);
        }else{
            //Se manda el mensaje de error y se redirigirse a la página de agregarEmpleado.
            $_SESSION['status'] = "Hubo un error al registrar.";
            header("Location: ../../presentacion/administrador/empleado/agregarEmpleado.php?id=".$id);
        }
    }
?>
