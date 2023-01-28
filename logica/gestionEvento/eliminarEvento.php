<?php
    //Archivo que contiene las funciones de los eventos
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionEvento/funcionesEvento.php';

    session_start();//Se inicia la sesión.

    //Se obtienen y limpian todos los datos que se mandaron por el método GET
    $idEvento = htmlentities($_GET['id']); 
    $idAdmin = htmlentities($_GET['idAdmin']); 

    //Se le envían los datos a la función para que se realice la eliminación del evento
    $resultadoEliminar = eliminarEvento($idEvento);
    
    //Si el resultado es 1, la eliminación se realizó correctamente. En cambio, si fue 0, hubo un error en la ejecución.
    if($resultadoEliminar === 1){
        //Se manda el mensaje de éxito y se redirige a la página de eventos
        $_SESSION['status'] = "Evento eliminado con éxito.";
        header("Location: ../../presentacion/administrador/eventos/eventos.php?id=".$idAdmin);
    }else{
        //Se manda el mensaje de éxito y se redirige a la página de eventos
        $_SESSION['status'] = "Hubo un error al registrar.";
        header("Location: ../../presentacion/administrador/eventos/eventos.php?id=".$idAdmin);
    }

?>
  