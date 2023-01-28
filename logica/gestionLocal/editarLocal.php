<?php
    //Requerimos del archivo para realizar consultas u operaciones a la base de datos.
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionLocal/funcionesLocal.php';

    session_start(); //Se inicia la sesión.

    //Se obtienen y se limpian los datos que se enviaron del formulario.
    $idNegocio     = htmlentities($_POST['idNegocio']);
    $nombreNegocio = html_entity_decode($_POST['nombreNegocio'], ENT_QUOTES | ENT_HTML401, "UTF-8");
    $idVendedor    = htmlentities($_POST['idVendedor']);
    
    //Se realiza un llamado a la función para verificar si existe un nombre igual al del negocio.
    $existe = existeLocalIgual($idNegocio,$nombreNegocio);

    //Si es mayor a cero significa ya existe y debe redirigirse a la página de editar.
    if($existe > 0 ){
        //En la variable de sesión se almacena el mensaje que se va a mostrar al usuario.
        $_SESSION['status'] = "No se ha podido modificar debido al nombre del negocio.";
        //Se redirige a la página de editar local.
        header("Location: ../../presentacion/vendedor/locales/editarLocal.php?id=".$idNegocio."");
        exit();
    }else{

        //Se envían los datos a la función para se realice la actualización de los datos.
        $resultado = editarLocal($nombreNegocio,$idNegocio);

        //Si el resultado retornado por la función es igual a 1 indica que todo ha sido exitoso, caso contrario, ocurrió un error.
        if($resultado === 1){
            //Se manda el mensaje de éxito y se redirige a la página de locales
            $_SESSION['status'] = "Negocio actualizado con éxito.";
            header("Location: ../../presentacion/vendedor/locales/locales.php?id=".$idVendedor);
        }else{
            //Se manda el mensaje de error y se redirigirse a la página de editar local.
            $_SESSION['status'] = "Hubo un error al actualizar.";
            header("Location: ../../presentacion/vendedor/locales/editarLocal.php?id=".$idNegocio."");
        }
    }
?>