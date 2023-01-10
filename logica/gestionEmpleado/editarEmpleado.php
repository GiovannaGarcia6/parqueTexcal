<?php 
    //Insertamos código de otro archivo.
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionEmpleado/funcionesEmpleado.php';

    session_start();//Se inicia la sesión.

    //Se obtienen todos los datos que se mandaron al formulario.
    $id =  htmlentities($_POST['id']);
    $idTrabajador =  htmlentities($_POST['idTrabajador']);
    $tipoEmpleado =  htmlentities($_POST['tipoEmpleado']);
    $nombre = html_entity_decode($_POST['nombre'], ENT_QUOTES | ENT_HTML401, "UTF-8");
    $apellidoPaterno = html_entity_decode($_POST['apPaterno'], ENT_QUOTES | ENT_HTML401, "UTF-8");
    $apellidoMaterno = html_entity_decode($_POST['apMaterno'], ENT_QUOTES | ENT_HTML401, "UTF-8");
    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
    $contrasena = htmlentities($_POST['contra']);

    //Se verifica que el tipo de empleado no este vacío
    if(empty($tipoEmpleado)){
        //En caso de ser así, se crea una variable de sesió para mostrar el mensaje
        $_SESSION['status'] = "Complete todos los campos.";
        header("Location: ../../presentacion/administrador/empleado/editarEmpleado.php?idEmpleado=".$idTrabajador);
        exit();
    }else{
        //Si todos los datos estan completos, se procede a realizar la actualización del empleado
        $resultadoActualizar = actualizarEmpleado($tipoEmpleado, $nombre, $apellidoPaterno, $apellidoMaterno, $correo, $contrasena,$idTrabajador);
        
        //Si el resultado es 1, la actualización se realizó correctamente. En cambio, si fue 0, hubo un error en la ejecución.
        if($resultadoActualizar === 1){
            //Se manda el mensaje de éxito y se redirige a la página de empleados.
            $_SESSION['status'] = "Empleado actualizado con éxito.";
            header("Location: ../../presentacion/administrador/empleado/empleados.php?id=".$id);
        }else{
            //Se manda el mensaje de error y se redirigirse a la página de empleados.
            $_SESSION['status'] = "Hubo un error al actualizar el empleado.";
            header("Location: ../../presentacion/administrador/empleado/empleados.php?id=".$id);
        }
    }

?>