<?php
    //Insertamos código de otro archivo el cual contiene la conexión de la BD.
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionComentario/funcionesComentario.php';
    session_start();
    //Obtenemos el id del boleto
    $idComentario =  htmlentities($_GET['idComentario']);
   
    

    if(isset($_GET['idAdmin'])){
        $idAdmin =  htmlentities($_GET['idAdmin']);
        
        $resultado = eliminarComentario($idComentario);

        if($resultado === 1){
            $_SESSION['status'] = "Comentario eliminado con éxito.";
            header("Location: ../../presentacion/administrador/comentarios/comentarios.php?id=".$idAdmin);;
        }else{
            //Se manda el mensaje de error y se redirigirse a la página de registrar.
            $_SESSION['status'] = "Hubo un error al eliminar el comentario.";
            header("Location: ../../presentacion/administrador/comentarios/comentarios.php?id=".$idAdmin);;
        }
    }else{
        $idVisitante =  htmlentities($_GET['idVisitante']);
        
        $resultado = eliminarComentario($idComentario);

        if($resultado === 1){
            $_SESSION['status'] = "Comentario eliminado con éxito.";
            header("Location: ../../presentacion/visitante/comentario/comentarios.php?id=".$idVisitante);;
        }else{
            //Se manda el mensaje de error y se redirigirse a la página de registrar.
            $_SESSION['status'] = "Hubo un error al eliminar el comentario.";
            header("Location: ../../presentacion/visitante/comentario/comentarios.php?id=".$idVisitante);
        }
    }
    
?>