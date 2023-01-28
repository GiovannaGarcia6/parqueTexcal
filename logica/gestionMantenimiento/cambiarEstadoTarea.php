<?php
    //Archivo que contiene las funciones de los mantenimientos y que permiten realizar consultas u operaciones a la base de datos.
    require '../../datos/gestionMantenimiento/funcionesMantenimiento.php';

    session_start();//Se inicia la sesión.

    //Se obtienen y limpin todos los datos que se enviaron por el método GET
    $id = htmlentities($_GET['id']);
    $idTarea = htmlentities($_GET['idTarea']);
    $estado = htmlentities($_GET['estado']);

    //Se realiza la actualización del estado de la tarea
    $resultadoCambiarEstadoTarea = cambiarEstadoTarea($idTarea,$estado);

    //Si el resultado retornado por la función es igual a 1 indica que todo ha sido exitoso, caso contrario, ocurrió un error.
    if($resultadoCambiarEstadoTarea === 1){
        //Se manda el mensaje de éxito y se redirige a la página de tareas
        $_SESSION['status'] = "Cambio de estado exitoso.";
        header("Location: ../../presentacion/mantenimiento/tareasEmpleado.php?id=".$id);
    }else{
        //Se manda el mensaje de error y se redirigirse a la página de tareas.
        $_SESSION['status'] = "Hubo un error al actualizar.";
        header("Location: ../../presentacion/mantenimiento/tareasEmpleado.php?id=".$id);
    }
?>