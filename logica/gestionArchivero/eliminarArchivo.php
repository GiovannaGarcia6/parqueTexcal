<?php
    //Archivo que nos permite acceder a las funciones del archiver
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionArchivero/funcionesArchivero.php';

    session_start();//Se inicia la sesión.

    //Se obtienen todos los datos.
    $id =  htmlentities($_GET['idAdmin']);
    $idArchivo =  htmlentities($_GET['idArc']);

    //Se verifica que exista el archivo
    $existe = contarArchivosXID($idArchivo);

    //si existe el resultado retornado de la función debe ser mayor a 0
    if($existe > 0 ){
        //Se obtienen los datos del archivo
        $datos = obtenerDatosArchivo($idArchivo);

        //Se obtiene el id de la carpeta
        $idCarpeta = $datos['idCarpeta'];

        //Se crea la ubicación del archivo
        $archivo = "../../presentacion/".$datos['url'];

        //Se elimina el archivo de la base de datos
        $resultadoEliminar = eliminarArchivo($idArchivo);

        //Si el resultado es 1, la eliminación fue exitosa
        if($resultadoEliminar === 1){
            //se elimina el archivo de la carperta de archivosTemp
            unlink($archivo);

            //Se envía un mensaje exitoso al usuario 
            $_SESSION['status'] = "Archivo eliminado con éxito.";
            header("Location: ../../presentacion/administrador/archivero/archivos/archivos.php?id=".$id."&idExp=".$idCarpeta);
        }else{
            //Se manda el mensaje de error y se redirigirse a la página de archivos.
            $_SESSION['status'] = "Hubo un error al eliminar.";
            header("Location: ../../presentacion/administrador/archivero/archivos/archivos.php?id=".$id."&idExp=".$idCarpeta);
        }
    }
?>