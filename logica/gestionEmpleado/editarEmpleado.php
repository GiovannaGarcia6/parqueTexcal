<?php 
    //Insertamos código de otro archivo.
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionEmpleado/funcionesEmpleado.php';

    session_start();//Se inicia la sesión.
    //Se obtienen todos los datos que se mandaron al formulario.
    $id =  htmlentities($_POST['id']);
    $idTrabajador =  htmlentities($_POST['idTrabajador']);
    $tipoEmpleado =  htmlentities($_POST['tipoEmpleado']);
    $nombre =  htmlentities($_POST['nombre']);
    $apellidoPaterno = htmlentities($_POST['apPaterno']);
    $apellidoMaterno = htmlentities($_POST['apMaterno']);
    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
    $contrasena = htmlentities($_POST['contra']);

    if(empty($tipoEmpleado)){
        $_SESSION['status'] = "Complete todos los campos.";
        header("Location: ../../presentacion/administrador/empleado/editarEmpleado.php?idEmpleado=".$idTrabajador);
        exit();
    }else{
        $resultadoActualizar = actualizarEmpleado($tipoEmpleado, $nombre, $apellidoPaterno, $apellidoMaterno, $correo, $contrasena,$idTrabajador);
        if($resultadoActualizar === 1){
            $_SESSION['status'] = "Empleado actualizado con éxito.";
            header("Location: ../../presentacion/administrador/empleado/empleados.php?id=".$id);
        }else{
            //Se manda el mensaje de error y se redirigirse a la página de registrar.
            $_SESSION['status'] = "Hubo un error al actualizar el empleado.";
            header("Location: ../../presentacion/administrador/empleado/empleados.php?id=".$id);
        }
    }

?>