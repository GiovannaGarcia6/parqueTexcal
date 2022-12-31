<?php 
    //Insertamos código de otro archivo para utilizar las funciones.
    require '../../datos/login/funciones.php';

    session_start();//Se inicia la sesión.
    
    //Se obtienen todos los datos que se mandaron al formulario.
    $id=htmlentities($_POST['id']);
    $contrasena1 = $_POST['contra'];
    $contrasena2 = $_POST['confirmarContra'];

    if($contrasena1 === $contrasena2){
        $existe = existeUsuario($id,0, "ID","Visitante");

        //Si es mayor a cero significa que si existe el visitante.
        if($existe > 0 ){
            $resultado = actualizarContrasena($id,$contrasena1,"Visitante");
            if($resultado === 1){
                $datos = obtenerDatos($id,"ID","Visitante");
                
                //Se obtienen los datos del visitante;
                $correo = $datos['correoVisit'];
                $nombre = $datos['nombVisit'];

                //Sentencias para generar el correo hacia el trabajador con sus datos
                $header = "From: parqtexc@gmail.com \r\n";
                $header .= "X-Mailer: PHP/" . phpversion() . "\r\n";
                $header .= "Mime-Version: 1.0 \r\n";
                $header .= "Content-Type: text/plain";

                $message = "Hola ".$nombre.", tu contraseña ha sido actualizada exitosamente. \r\n";
                $message .= "Ahora tu contraseña es: " . $contrasena1 . " \r\n\n";

                $asunto = 'Cambio de Contraseña';

                mail($correo, $asunto, utf8_decode($message), $header);


                $_SESSION['status'] = "Cambio exitoso, revisa la bandeja de tu correo electrónico.";
                header("Location: ../../presentacion/login/nuevaContrasena.php?id=".$id);
            }else{
                //Se manda el mensaje de error y se redirigirse a la página de registrar.
                $_SESSION['status'] = "Hubo un error al actualizar.";
                header("Location: ../../presentacion/login/nuevaContrasena.php?id=".$id);
            }
        }else{

            $existe = existeUsuario($id,0, "ID","Trabajador");

            //Si es mayor a cero significa que la clave ya existe y debe redirigirse a la página de registrar.
            if($existe > 0 ){
            
                $resultado = actualizarContrasena($id,$contrasena1,"Trabajador");
                
                if($resultado === 1){
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
    
                    mail($correo, $asunto, utf8_decode($message), $header);
    
    
                    $_SESSION['status'] = "Cambio exitoso, revisa la bandeja de tu correo electrónico.";
                    header("Location: ../../presentacion/login/nuevaContrasena.php?id=".$id);
                }else{
                    //Se manda el mensaje de error y se redirigirse a la página de registrar.
                    $_SESSION['status'] = "Hubo un error al actualizar.";
                    header("Location: ../../presentacion/login/nuevaContrasena.php?id=".$id);
                }

            }
        }
    }else{
        $_SESSION['status'] = "Las contraseñas deben ser iguales.";
        header("Location: ../../presentacion/login/nuevaContrasena.php?id=".$id);
    }
?>
