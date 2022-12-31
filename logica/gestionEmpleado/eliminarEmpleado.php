<?php
    //Insertamos código de otro archivo .
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionEmpleado/funcionesEmpleado.php';
    session_start();//Se inicia la sesión.
    //Se obtienen todos los datos que se mandaron al formulario.
    $id =  htmlentities($_GET['id']);
    $idTrabajador =  htmlentities($_GET['idTrabajador']);

    $resultadoEliminacion = eliminarEmpleado($idTrabajador);
    
    if( $resultadoEliminacion === 1){
        $_SESSION['status'] = "Empleado eliminado con éxito.";
        header("Location: ../../presentacion/administrador/empleado/empleados.php?id=".$id);
    }else{
        //Se manda el mensaje de error y se redirigirse a la página de registrar.
        $_SESSION['status'] = "Hubo un error al eliminar el empleado.";
        header("Location: ../../presentacion/administrador/empleado/empleados.php?id=".$id);
    }
   
?>