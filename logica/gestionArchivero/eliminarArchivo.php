<?php
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionArchivero/funcionesArchivero.php';

    session_start();//Se inicia la sesión.

    //Se obtienen todos los datos.
    $id =  htmlentities($_GET['idAdmin']);
    $idArchivo =  htmlentities($_GET['idArc']);

    $existe = contarArchivosXID($idArchivo);

    if($existe > 0 ){
        $datos = obtenerDatosArchivo($idArchivo);
        //Se obtienen los datos del boleto.
        $idCarpeta = $datos['idCarpeta'];

        $archivo = "../../presentacion/".$datos['url'];

        $resultadoEliminar = eliminarArchivo($idArchivo);

        if($resultadoEliminar === 1){
            unlink($archivo);

            $_SESSION['status'] = "Archivo eliminado con éxito.";
            header("Location: ../../presentacion/administrador/archivero/archivos/archivos.php?id=".$id."&idExp=".$idCarpeta);
        }else{
            //Se manda el mensaje de error y se redirigirse a la página de registrar.
            $_SESSION['status'] = "Hubo un error al eliminar.";
            header("Location: ../../presentacion/administrador/archivero/archivos/archivos.php?id=".$id."&idExp=".$idCarpeta);
        }
    }
?>