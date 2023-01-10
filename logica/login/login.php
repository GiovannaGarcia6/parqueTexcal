
<?php
    //Archivo el cual contiene las funciones del login
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/login/funciones.php';
    
    session_start(); //Se inicia la sesión.
    
    //Se obtiene los datos que se enviaron del formulario.
    $email = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
    $password = htmlentities($_POST['contra']);
    
    //Se verifica que los datos coincidan con una cuenta ya existente en la base de datos
    $existe = existeUsuario($email,$password, "Correo&Contrasena","Trabajador");

    //Si es mayor a 0 significa que encontró al usuario.
    if ($existe > 0) {
        //Se obtiene el tipo de trabajador
        $tipo = consultarTipoTrabajador($email, $password);
        //Se inicia una sesión
        $id = sesion($email, "Trabajador");
        //Con el switch se redirige al menú correspondiente del usuario
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
        //Sino existe el usuario con los trabajadores, se realiza una consulta a la tabla de los visitantes para 
        //saber si existe una cuenta con esos datos
        $existe = existeUsuario($email,$password, "Correo&Contrasena","Visitante");

        //Si es mayor a 0 significa que encontró al usuario.
        if ($existe > 0) {

            //Se inicia sesión
            $id = sesion($email, "Visitante");
            //Se redirige al menú del visitante
            header('Location: /Sistema Web/presentacion/menu/menuVisitante.php?id='.$id.'');
        } else {
            //Sino entró en ninguna de las condiciones anteriores es porque no se encontró al usuario con esos datos.
            //Se dirige de nuevo al inicio de sesión mostrandole un mensaje enviado por la variable de sesión.
            $_SESSION['status'] = "Usuario y/o contraseña incorrectos";
            header("Location: /Sistema Web/presentacion/login/login.php");
        }
    }

?>