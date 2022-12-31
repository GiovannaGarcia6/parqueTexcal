<?php

    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionEvento/funcionesEvento.php';
    session_start();//Se inicia la sesión.

    $idEvento = $_GET['id']; 
    $idAdmin = $_GET['idAdmin']; 

    $resultadoEliminar = eliminarEvento($idEvento);
    if($resultadoEliminar === 1){
        $_SESSION['status'] = "Evento eliminado con éxito.";
        header("Location: ../../presentacion/administrador/eventos/eventos.php?id=".$idAdmin);
    }else{
        //Se manda el mensaje de error y se redirigirse a la página de registrar.
        $_SESSION['status'] = "Hubo un error al registrar.";
        header("Location: ../../presentacion/administrador/eventos/eventos.php?id=".$idAdmin);
    }

?>
  