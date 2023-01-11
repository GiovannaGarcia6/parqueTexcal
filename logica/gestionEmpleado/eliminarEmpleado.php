<?php
    //Insertamos código de otro archivo .
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionEmpleado/funcionesEmpleado.php';
    session_start();//Se inicia la sesión.
    //Se obtienen todos los datos que se mandaron al formulario.
    $id =  htmlentities($_GET['id']);
    $idTrabajador =  htmlentities($_GET['idTrabajador']);

    //Se hace uso de la función mandando el id del trabajador que se quiere eliminar
    $resultadoEliminacion = eliminarEmpleado($idTrabajador);
    
    //Si el resultado retornado de la función es 1, la eliminación se realizo exitosamente. 
    //En caso de ser 0 es porque ocurrió un error
    if( $resultadoEliminacion === 1){
        //Se crea la variable de sesión que contendrá el mensaje de éxito
        $_SESSION['status'] = "Empleado eliminado con éxito.";
        //Se redirige a la página de los empleados
        header("Location: ../../presentacion/administrador/empleado/empleados.php?id=".$id);
    }else{
        //Se crea la variable de sesión que contendrá el mensaje de error
        $_SESSION['status'] = "Hubo un error al eliminar el empleado.";
        //Se redirige a la página de los empleados
        header("Location: ../../presentacion/administrador/empleado/empleados.php?id=".$id);
    }
?>