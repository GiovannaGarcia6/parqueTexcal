<?php 
    //Archivo que contiene las funciones de los mantenimientos y que permiten realizar consultas u operaciones a la base de datos.
    require '../../datos/gestionMantenimiento/funcionesMantenimiento.php';

    session_start();//Se inicia la sesión.

    //Se obtienen y limpian todos los datos que se enviaron por método GET
    $id = htmlentities($_GET['id']);
    $idMantenimiento = htmlentities($_GET['idMantenimiento']);

    //Se realiza la eliminación del mantenimiento y sus tareas
    $resultadoEliminar = eliminarMantenimiento($idMantenimiento);

    //Si el resultado retornado por la función es igual a 1 indica que todo ha sido exitoso, caso contrario, ocurrió un error.
    if($resultadoEliminar){
        //Se manda el mensaje de éxito y se redirigirse a la página de mantenimientos.
        $_SESSION['status'] = "Mantenimiento eliminado con éxito.";
        header("Location: ../../presentacion/administrador/mantenimientos/mantenimientos.php?id=".$id);
    }else{
        //Se manda el mensaje de error y se redirigirse a la página de mantenimientos.
        $_SESSION['status'] = "Hubo un error al eliminar el mantenimiento.";
        header("Location: ../../presentacion/administrador/mantenimientos/mantenimientos.php?id=".$id);
    }        
?>