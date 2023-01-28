<?php 
    //Archivo que contiene las funciones de los mantenimientos y que permiten realizar consultas u operaciones a la base de datos.
    require '../../datos/gestionMantenimiento/funcionesMantenimiento.php';

    session_start();//Se inicia la sesión.

    //Se obtienen y limpian todos los datos que se mandaron al formulario.
    $id = htmlentities($_POST['id']);
    $idMantenimiento = htmlentities($_POST['idMantenimiento']);
    $nombre = html_entity_decode($_POST['nombre'], ENT_QUOTES | ENT_HTML401, "UTF-8");
    $descripcion = html_entity_decode($_POST['desc'], ENT_QUOTES | ENT_HTML401, "UTF-8");

    //Se verifica que el textArea no se encuentre vacío ¡, ya que es necesario para la inserción del mantenimiento.
    if(empty($descripcion)){
        $_SESSION['status'] = "Debe agregar una descripción a la tarea.";
        header("Location: ../../presentacion/administrador/mantenimientos/editarMantenimiento.php?idMantenimiento=".$idMantenimiento."&id=".$id);
        exit();
    }else{

        //Se realiza la actualización del mantenimiento
        $resultadoEditar = editarMantenimiento($nombre, $descripcion,$idMantenimiento);

        //Si el resultado retornado por la función es igual a 1 indica que todo ha sido exitoso, caso contrario, ocurrió un error.
        if($resultadoEditar === 1){
            //Se manda el mensaje de éxito y se redirige a la página de mantenimientos.
            $_SESSION['status'] = "Mantenimiento actualizado con éxito.";
            header("Location: ../../presentacion/administrador/mantenimientos/mantenimientos.php?id=".$id);
        }else{
            //Se manda el mensaje de error y se redirige a la página de mantenimientos.
            $_SESSION['status'] = "Hubo un error al actualizar el mantenimiento.";
            header("Location: ../../presentacion/administrador/mantenimientos/mantenimientos.php?id=".$id);
        }
    
    }
?>