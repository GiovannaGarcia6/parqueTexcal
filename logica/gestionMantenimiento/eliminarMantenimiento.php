<?php 
    require '../../datos/gestionMantenimiento/funcionesMantenimiento.php';
    session_start();//Se inicia la sesión.
    //Se obtienen todos los datos que se mandaron al formulario.
    $id = htmlentities($_GET['id']);
    $idMantenimiento = htmlentities($_GET['idMantenimiento']);

    $resultadoEliminar = eliminarMantenimiento($idMantenimiento);
        if($resultadoEliminar){
            $_SESSION['status'] = "Mantenimiento eliminado con éxito.";
            header("Location: ../../presentacion/administrador/mantenimientos/mantenimientos.php?id=".$id);
        }else{
            //Se manda el mensaje de error y se redirigirse a la página de registrar.
            $_SESSION['status'] = "Hubo un error al eliminar el mantenimiento.";
            header("Location: ../../presentacion/administrador/mantenimientos/mantenimientos.php?id=".$id);
        }

    mysqli_close($conn);//Se cierra la conexión
?>