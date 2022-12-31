<?php
    //Requerimos del archivo para realizar la conexión.
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionArchivero/funcionesArchivero.php';
    session_start();
    //Se obtiene los datos que se enviaron del formulario.
    $idExpediente =  htmlentities($_POST['idCarpeta']);
    $nombreExp =  htmlentities($_POST['nombreExp']);
    $idAdmin = htmlentities($_POST['idAdmin']);

    $existe = contarCarpetasXNombreyid($nombreCarpeta,$idExpediente);

    if($existe > 0 ){
        $_SESSION['status'] = "No se ha podido modificar debido al nombre de la carpeta.";
        header("Location: ../../presentacion/administrador/archivero/carpetas/editarCarpeta.php?idAdmin=".$idAdmin."&id=".$idExpediente);
        exit();
    }else{
       
        $resultadoEditar = editarCarpeta($nombreExp, $idExpediente);

        if($resultadoEditar === 1){
            $_SESSION['status'] = "Carpeta actualizada con éxito.";
            header("Location: ../../presentacion/administrador/archivero/carpetas/archivero.php?id=".$idAdmin);
        }else{
            //Se manda el mensaje de error y se redirigirse a la página de registrar.
            $_SESSION['status'] = "Hubo un error al actualizar.";
            header("Location: ../../presentacion/administrador/archivero/carpetas/editarCarpeta.php?idAdmin=".$idAdmin."&id=".$idExpediente);
        }
    }
?>