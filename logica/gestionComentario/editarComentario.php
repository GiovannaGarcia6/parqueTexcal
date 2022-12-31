<?php 
    //Insertamos código de otro archivo el cual contiene la conexión de la BD.
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionComentario/funcionesComentario.php';
    session_start();//Se inicia la sesión.
    //Se obtienen todos los datos que se mandaron al formulario.
    $idUsuario =  htmlentities($_POST['idVisitante']);
    $idComentario =  htmlentities($_POST['idComentario']);
    $servicio =  htmlentities($_POST['servicio']);
    $puntuacion =  htmlentities($_POST['puntuacion']);
    $comentario =  htmlentities($_POST['comentario']);

    if(empty($comentario)){
        $_SESSION['status'] = "Debe agregar su comentario.";
        header("Location: ../../presentacion/visitante/comentario/editarComentario.php?idComentario=".$idComentario);
        exit();
    }else{
        $resultadoEditar = editarComentario($idComentario,$comentario, $puntuacion, $idUsuario, $servicio);
        if($resultadoEditar === 1){
            $_SESSION['status'] = "Comentario actualizado con éxito.";
            header("Location: ../../presentacion/visitante/comentario/comentarios.php?id=".$idUsuario);
        }else{
            //Se manda el mensaje de error y se redirigirse a la página de registrar.
            $_SESSION['status'] = "Hubo un error al actualizar su comentario.";
            header("Location: ../../presentacion/visitante/comentario/comentarios.php?id=".$idUsuario);
        }
    }

    mysqli_close($conn);//Se cierra la conexión
?>