<?php
    //Archivo que contiene las funciones de las publiaciones
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionPublicacion/funcionesPublicacion.php';

    session_start(); //Se inicia sesión

    //Se obtiene y limpian los datos enviados por el método GET
    $idAdmin = htmlentities($_GET['id']);
    $idPublicacion = htmlentities($_GET['idPublicacion']);   

    //Con la funciín se obtiene la ruta de la imagen
    $ruta = rutaImagen($idPublicacion);

    //Se obtienen la imagen almacenada en la bd
    $imagenEliminar = "../../presentacion/".$ruta['archivo'];

    //Se realiza la eliminación de la publicación
    $resultadoEliminar = eliminarPublicacion($idPublicacion);

    //Si el resultado de la ejecución fue 1 ha sido exitoso, si es 0 hubo un error
    if($resultadoEliminar === 1){
        //Se elimina la imagen de la carpeta de imagenes temporales
        unlink($imagenEliminar);
        //Se manda un mensaje con la variable de sesión
        $_SESSION['status'] = "Publicación eliminada con éxito.";
         //y se redirige a la página de publicaciones para mostrar el mensaje
        header("Location: ../../presentacion/administrador/publicaciones/publicaciones.php?id=".$idAdmin);;
    }else{
        //Se manda un mensaje con la variable de sesión
        $_SESSION['status'] = "Hubo un error al eliminar la publicación.";
        //y se redirige a la página de publicaciones para mostrar el mensaje
        header("Location: ../../presentacion/administrador/publicaciones/publicaciones.php?id=".$idAdmin);;
    }
?>