<?php
    //Archivo que contiene las funciones de los mantenimientos y que permiten realizar consultas u operaciones a la base de datos.
    require '../../datos/gestionMantenimiento/funcionesMantenimiento.php';

    session_start();//Se inicia la sesión.

    //Se obtienen y limpian todos los datos que se enviaron por método GET
    $idAdmin = htmlentities($_GET['idAdmin']);
    $idTarea = htmlentities($_GET['idTarea']);
    $idMantenimiento = htmlentities($_GET['idMantenimiento']);

    //Se realiza la eliminación de la tarea
    $resultadoEliminar = eliminarTarea($idTarea);

    //Si el resultado retornado por la función es igual a 1 indica que todo ha sido exitoso, caso contrario, ocurrió un error.
    if($resultadoEliminar === 1){
        //Se manda el mensaje de éxito y se redirigirse a la página de tareas.
        $_SESSION['status'] = "Tarea eliminada con éxito.";
        header("Location: ../../presentacion/administrador/mantenimientos/tareas.php?id=".$id."&idMantenimiento=".$idMantenimiento);
    }else{
        //Se manda el mensaje de error y se redirigirse a la página de tareas.
        $_SESSION['status'] = "Hubo un error al eliminar.";
        header("Location: ../../presentacion/administrador/mantenimientos/tareas.php?id=".$id."&idMantenimiento=".$idMantenimiento);
    }
?>