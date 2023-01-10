<?php 
    //Archivo el cual contiene las funciones del login
    require '../../datos/login/funciones.php';

    session_start();//Se inicia la sesión.
    
    //Se obtienen todos los datos que se mandaron al formulario.
    $id=htmlentities($_POST['id']);
    $contrasena1 = htmlentities($_POST['contra']);
    $contrasena2 = htmlentities($_POST['confirmarContra']);

    //Se verifica que las contraseñas sean iguales
    if($contrasena1 === $contrasena2){

        //Se verifica que exista el usuario con dicho id
        $existe = existeUsuario($id,0, "ID","Visitante");

        //Si es mayor a cero significa que si existe el visitante.
        if($existe > 0 ){
            //Se actualiza la nueva contraseña
            $resultado = actualizarContrasena($id,$contrasena1,"Visitante");

            //Si el resultado fue satisfactorio esté debe ser igual a 1
            if($resultado === 1){
                //Se obtiene el correo y contraseña del visitante
                $datos = obtenerDatos($id,"ID","Visitante");
                
                //Se obtienen los datos del visitante;
                $correo = $datos['correoVisit'];
                $nombre = $datos['nombVisit'];

                //Sentencias para generar el correo hacia el visitante con sus datos
                $header = "From: parqtexc@gmail.com \r\n";
                $header .= "X-Mailer: PHP/" . phpversion() . "\r\n";
                $header .= "Mime-Version: 1.0 \r\n";
                $header .= "Content-Type: text/plain";

                $message = "Hola ".$nombre.", tu contraseña ha sido actualizada exitosamente. \r\n";
                $message .= "Ahora tu contraseña es: " . $contrasena1 . " \r\n\n";

                $asunto = 'Cambio de Contraseña';

                //Se envía el correo
                mail($correo, $asunto, utf8_decode($message), $header);

                //Se crea la variable de sesión con el mensaje correspondiente
                $_SESSION['status'] = "Cambio exitoso, revisa la bandeja de tu correo electrónico.";
                //Se redirije al formulario
                header("Location: ../../presentacion/login/nuevaContrasena.php?id=".$id);
            }else{
                //Se crea la variable de sesión con el mensaje correspondiente
                $_SESSION['status'] = "Hubo un error al actualizar.";
                //Se redirije al formulario
                header("Location: ../../presentacion/login/nuevaContrasena.php?id=".$id);
            }
        }else{
            //si el caso fue que no se encontró en los visitantes, ahora se realiza una consulta a los trabajadores
            $existe = existeUsuario($id,0, "ID","Trabajador");

            //Si es mayor a cero significa que ya existe
            if($existe > 0 ){
                
                //Se actualiza la nueva contraseña  
                $resultado = actualizarContrasena($id,$contrasena1,"Trabajador");
                //Si el resultado fue satisfactorio esté debe ser igual a 1
                if($resultado === 1){
                    //Se obtiene el correo y contraseña del trabajador
                    $datos = obtenerDatos($id,"ID","Trabajador");
                    
                    //Se obtienen los datos del trabajador;
                    $correo = $datos['correoTrab'];
                    $nombre = $datos['nombreTrab'];

                    //Sentencias para generar el correo hacia el trabajador con sus datos
                    $header = "From: parqtexc@gmail.com \r\n";
                    $header .= "X-Mailer: PHP/" . phpversion() . "\r\n";
                    $header .= "Mime-Version: 1.0 \r\n";
                    $header .= "Content-Type: text/plain";

                    $message = "Hola ".$nombre.", tu contraseña ha sido actualizada exitosamente. \r\n";
                    $message .= "Ahora tu contraseña es: " . $contrasena1 . " \r\n\n";
    
                    $asunto = 'Cambio de Contraseña';
    
                    //Se envía el correo
                    mail($correo, $asunto, utf8_decode($message), $header);

                    //Se crea la variable de sesión con el mensaje correspondiente
                    $_SESSION['status'] = "Cambio exitoso, revisa la bandeja de tu correo electrónico.";
                    header("Location: ../../presentacion/login/nuevaContrasena.php?id=".$id);
                }else{
                    //Se crea la variable de sesión con el mensaje correspondiente
                    $_SESSION['status'] = "Hubo un error al actualizar.";
                    header("Location: ../../presentacion/login/nuevaContrasena.php?id=".$id);
                }

            }
        }
    }else{
        //Se crea la variable de sesión con el mensaje correspondiente
        $_SESSION['status'] = "Las contraseñas deben ser iguales.";
        header("Location: ../../presentacion/login/nuevaContrasena.php?id=".$id);
    }
?>
