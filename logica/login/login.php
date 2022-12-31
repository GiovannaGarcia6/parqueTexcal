
<?php
    
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/login/funciones.php';
    
    session_start(); //Se inicia la sesión.
    
    //Se obtiene los datos que se enviaron del formulario.
    $email = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
    $password = htmlentities($_POST['contra']);
    
    $existe = existeUsuario($email,$password, "Correo&Contrasena","Trabajador");

    //Si es mayor a 0 significa que encontro al usuario.
    if ($existe > 0) {
        
        $tipo = consultarTipoTrabajador($email, $password);
        $id = sesion($email, "Trabajador");
        switch ($tipo) {
            case "Administrador":
                header('Location: /Sistema Web/presentacion/menu/menuAdministrador.php?id='.$id.'');
                break;
            case "Guia":
                header('Location: /Sistema Web/presentacion/menu/menuGuia.php?id='.$id.'');
                break;
            case "Vendedor":
                header('Location: /Sistema Web/presentacion/menu/menuVendedor.php?id='.$id.'');
                break;
            case "Mantenimiento":
                header('Location: /Sistema Web/presentacion/menu/menuMantenimiento.php?id='.$id.'');
                break;
        }
    } else {

        $existe = existeUsuario($email,$password, "Correo&Contrasena","Visitante");
        
        echo "".$existe;
        //Si es mayor a 0 significa que encontro al usuario.
        if ($existe > 0) {
            $id = sesion($email, "Visitante");
             
            echo "".$id;
            header('Location: /Sistema Web/presentacion/menu/menuVisitante.php?id='.$id.'');
        } else {
            //Sino entro en ninguna de las condiciones anteriores es porque no se encontro al usuario con esos datos.
            //Se dirige de nuevo al inicio de sesión mostrandole un mensaje.
            $_SESSION['status'] = "Usuario y/o contraseña incorrectos";
            header("Location: /Sistema Web/presentacion/login/login.php");
        }
    }

?>