<?php
    //Insertamos código de otro archivo el cual contiene la conexión de la BD.
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionPublicacion/funcionesPublicacion.php';
    session_start();
    //Obtenemos el id del boleto
    $idAdmin = htmlentities($_GET['id']);
    $idPublicacion = htmlentities($_GET['idPublicacion']);   

    $filas = rutaImagen($idPublicacion);
    //Se obtienen la imagen almacenada en la bd
    $imagenEliminar = "../../presentacion/".$filas['archivo'];

    $resultadoEliminar = eliminarPublicacion($idPublicacion);
    if($resultadoEliminar === 1){
        //Se elimina la imagen
        unlink($imagenEliminar);
        $_SESSION['status'] = "Publicación eliminada con éxito.";
        header("Location: ../../presentacion/administrador/publicaciones/publicaciones.php?id=".$idAdmin);;
    }else{
        //Se manda el mensaje de error y se redirigirse a la página de registrar.
        $_SESSION['status'] = "Hubo un error al eliminar la publicación.";
        header("Location: ../../presentacion/administrador/publicaciones/publicaciones.php?id=".$idAdmin);;
    }
    
?>