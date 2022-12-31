<?php 
    require '../../datos/gestionMantenimiento/funcionesMantenimiento.php';
    session_start();//Se inicia la sesión.
    //Se obtienen todos los datos que se mandaron al formulario.
    $id = htmlentities($_POST['id']);
    $idMantenimiento = htmlentities($_POST['idMantenimiento']);
    $idTarea = htmlentities($_POST['idTarea']);
    $titulo = htmlentities($_POST['titulo']);
    $desc = htmlentities($_POST['desc']);
    $estado = htmlentities($_POST['estado']);
    $fechInic = strtotime($_POST['inic']);
    $fechTerm = strtotime($_POST['term']);
    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
    
    if(empty($desc)){
        $_SESSION['status'] = "Debe agregar una descripción a la tarea.";
        header("Location: ../../presentacion/administrador/mantenimientos/editarTarea.php?id=".$id."&idMantenimiento=".$idMantenimiento."&idTarea=".$idTarea);
        exit();
    }else{

        $idTrab = obtenerIdTrabajadorXCorreo($correo);

        $resultadoEditar = editarTarea($titulo, $desc, $estado, $fechInic, $fechTerm, $idTrab, $idTarea);
        if($resultadoEditar === 1){
            $_SESSION['status'] = "Tarea actualizada con éxito.";
            header("Location: ../../presentacion/administrador/mantenimientos/Tareas.php?id=".$id."&idMantenimiento=".$idMantenimiento);
        }else{
            //Se manda el mensaje de error y se redirigirse a la página de registrar.
            $_SESSION['status'] = "Hubo un error al actualizar la tarea.";
            header("Location: ../../presentacion/administrador/mantenimientos/editarTarea.php?id=".$id."&idMantenimiento=".$idMantenimiento."&idTarea=".$idTarea);
        }
    
    
    }
    mysqli_close($conn);//Se cierra la conexión
?>