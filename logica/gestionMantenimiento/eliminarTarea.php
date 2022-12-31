<?php
    require '../../datos/gestionMantenimiento/funcionesMantenimiento.php';

    session_start();//Se inicia la sesión.

    $idAdmin = htmlentities($_GET['idAdmin']);
    $idTarea = htmlentities($_GET['idTarea']);
    $idMantenimiento = htmlentities($_GET['idMantenimiento']);

    $resultadoEliminar = eliminarTarea($idTarea);

    if($resultadoEliminar === 1){
        $_SESSION['status'] = "Tarea eliminada con éxito.";
        header("Location: ../../presentacion/administrador/mantenimientos/tareas.php?id=".$id."&idMantenimiento=".$idMantenimiento);
    }else{
        //Se manda el mensaje de error y se redirigirse a la página de registrar.
        $_SESSION['status'] = "Hubo un error al eliminar.";
        header("Location: ../../presentacion/administrador/mantenimientos/tareas.php?id=".$id."&idMantenimiento=".$idMantenimiento);
    }
        


    
?>