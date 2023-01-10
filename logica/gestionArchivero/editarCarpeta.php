<?php
    //Archivo que nos permite acceder a las funciones del archivero
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionArchivero/funcionesArchivero.php';
    
    session_start(); //Se inicia sesión
    
    //Se obtiene los datos que se enviaron del formulario.
    $idExpediente =  htmlentities($_POST['idCarpeta']);
    $nombreExp =  htmlentities($_POST['nombreExp']);
    $idAdmin = htmlentities($_POST['idAdmin']);

    //Se realiza la consulta para saber si existe el nuevo nombre de la carpeta 
    $existe = contarCarpetasXNombreyid($nombreCarpeta,$idExpediente);

    //Si el resultado retornado por la función es mayor a 0 significa que si hay un registro con ese nombre
    if($existe > 0 ){
        //Se crea la variable de sesión con el mensaje a mostrar en la interfaz
        $_SESSION['status'] = "No se ha podido modificar debido al nombre de la carpeta.";
        //Se redirige a la interfaz de editar carpeta
        header("Location: ../../presentacion/administrador/archivero/carpetas/editarCarpeta.php?idAdmin=".$idAdmin."&id=".$idExpediente);
        exit();
    }else{
       
        //Se mandan los nuevos datos para realizar la actualización
        $resultadoEditar = editarCarpeta($nombreExp, $idExpediente);

        //Si el resultado es igual a 1, esta fue actualizada correctamente
        if($resultadoEditar === 1){
            //Se crea la variable de sesión con el mensaje a mostrar en la interfaz
            $_SESSION['status'] = "Carpeta actualizada con éxito.";
            //Se redirige a la interfaz del archivero
            header("Location: ../../presentacion/administrador/archivero/carpetas/archivero.php?id=".$idAdmin);
        }else{
            //Se crea la variable de sesión con el mensaje a mostrar en la interfaz
            $_SESSION['status'] = "Hubo un error al actualizar.";
            //Se redirige a la interfaz de editar carpeta
            header("Location: ../../presentacion/administrador/archivero/carpetas/editarCarpeta.php?idAdmin=".$idAdmin."&id=".$idExpediente);
        }
    }
?>