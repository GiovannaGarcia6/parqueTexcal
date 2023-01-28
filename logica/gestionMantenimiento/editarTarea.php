<?php 
    //Archivo que contiene las funciones de los mantenimientos y que permiten realizar consultas u operaciones a la base de datos.
    require '../../datos/gestionMantenimiento/funcionesMantenimiento.php';

    session_start();//Se inicia la sesión.

    //Se obtienen y limpian todos los datos que se mandaron al formulario.
    $id = htmlentities($_POST['id']);
    $idMantenimiento = htmlentities($_POST['idMantenimiento']);
    $idTarea = htmlentities($_POST['idTarea']);
    $titulo =  html_entity_decode($_POST['titulo'], ENT_QUOTES | ENT_HTML401, "UTF-8");
    $descripcion = html_entity_decode($_POST['desc'], ENT_QUOTES | ENT_HTML401, "UTF-8");
    $estado = htmlentities($_POST['estado']);
    $fechInic = strtotime($_POST['inic']);
    $fechTerm = strtotime($_POST['term']);
    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
    
    //Se verifica que el textArea no se encuentre vacío ¡, ya que es necesario para la inserción del mantenimiento.
    if(empty($desc)){
        $_SESSION['status'] = "Debe agregar una descripción a la tarea.";
        header("Location: ../../presentacion/administrador/mantenimientos/editarTarea.php?id=".$id."&idMantenimiento=".$idMantenimiento."&idTarea=".$idTarea);
        exit();
    }else{

        //Se obtiene el id del trabajador
        $idTrab = obtenerIdTrabajadorXCorreo($correo);

        //Se realiza la actualización con los datos obtenidos de la capa de presentación
        $resultadoEditar = editarTarea($titulo, $desc, $estado, $fechInic, $fechTerm, $idTrab, $idTarea);

        //Si el resultado retornado por la función es igual a 1 indica que todo ha sido exitoso, caso contrario, ocurrió un error.
        if($resultadoEditar === 1){
            //Se manda el mensaje de ÉXITO y se redirige a la página de TAREAS
            $_SESSION['status'] = "Tarea actualizada con éxito.";
            header("Location: ../../presentacion/administrador/mantenimientos/Tareas.php?id=".$id."&idMantenimiento=".$idMantenimiento);
        }else{
            //Se manda el mensaje de error y se redirige a la página de editar tarea.
            $_SESSION['status'] = "Hubo un error al actualizar la tarea.";
            header("Location: ../../presentacion/administrador/mantenimientos/editarTarea.php?id=".$id."&idMantenimiento=".$idMantenimiento."&idTarea=".$idTarea);
        }
    }
?>