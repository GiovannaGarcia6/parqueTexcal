<?php
    //Archivo que nos permite acceder a las funciones del archiver
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionArchivero/funcionesArchivero.php';

    session_start();//Se inicia la sesión.

    //Se obtienen todos los datos.
    $idCarpeta =  htmlentities($_GET['idExp']);
    $idAdmin =  htmlentities($_GET['idAdmin']);

    //Se realiza la eliminación de la carpeta
    $resultadEliminar = eliminarCarpeta($idCarpeta);

    //Si el resultado es 1, la eliminación fue exitosa
    if($resultadEliminar === 1){
        //Se envía un mensaje exitoso al usuario 
        $_SESSION['status'] = "Carpeta y archivos eliminados con éxito.";
        header("Location: ../../presentacion/administrador/archivero/carpetas/archivero.php?id=".$idAdmin);
    }else{
        //Se envía un mensaje de error al usuario 
        $_SESSION['status'] = "Hubo un error al eliminar.";
        header("Location: ../../presentacion/administrador/archivero/carpetas/archivero.php?id=".$idAdmin);
    }
?>