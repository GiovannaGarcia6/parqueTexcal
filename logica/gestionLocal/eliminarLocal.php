<?php

    //Requerimos del archivo para realizar consultas u operaciones a la base de datos.
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionLocal/funcionesLocal.php';

    session_start(); //Se inicia la sesión.

    //Obtenemos los datos enviados por el método GET
    $idNegocio  = htmlentities($_GET['idNegocio']);
    $idVendedor = htmlentities($_GET['idVendedor']);
    
    //Se envía el id del negocio a eliminar.
    $resultado = eliminarLocal($idNegocio);

    //Si el resultado retornado por la función es igual a 1 indica que todo ha sido exitoso, caso contrario, ocurrió un error.
    if($resultado === 1){
        //Se manda el mensaje de éxito y se redirige a la página de locales
        $_SESSION['status'] = "Negocio y productos eliminados con éxito.";
        header("Location: ../../presentacion/vendedor/locales/locales.php?id=".$idVendedor);
    }else{
        //Se manda el mensaje de error y se redirigirse a la página de locales.
        $_SESSION['status'] = "Hubo un error al eliminar.";
        header("Location: ../../presentacion/vendedor/locales/locales.php?id=".$idVendedor);
    }
?>