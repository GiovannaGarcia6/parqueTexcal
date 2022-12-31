<?php
    require '../../datos/gestionMantenimiento/funcionesMantenimiento.php';

    session_start();//Se inicia la sesión.
    //Se obtienen todos los datos que se mandaron al formulario.

    $id = htmlentities($_GET['id']);
    $idTarea = htmlentities($_GET['idTarea']);
    $estado = htmlentities($_GET['estado']);


    $resultadoCambiarEstadoTarea = cambiarEstadoTarea($idTarea,$estado);
    if($resultadoCambiarEstadoTarea === 1){
        $_SESSION['status'] = "Cambio de estado exitoso.";
        header("Location: ../../presentacion/mantenimiento/tareasEmpleado.php?id=".$id);
    }else{
        //Se manda el mensaje de error y se redirigirse a la página de registrar.
        $_SESSION['status'] = "Hubo un error al actualizar.";
        header("Location: ../../presentacion/mantenimiento/tareasEmpleado.php?id=".$id);
    }
        




    
?>