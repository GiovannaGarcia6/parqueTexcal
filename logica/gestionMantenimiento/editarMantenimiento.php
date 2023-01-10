<?php 
    require '../../datos/gestionMantenimiento/funcionesMantenimiento.php';
    session_start();//Se inicia la sesión.
    //Se obtienen todos los datos que se mandaron al formulario.
    $id = htmlentities($_POST['id']);
    $idMantenimiento = htmlentities($_POST['idMantenimiento']);
    $nombre = html_entity_decode($_POST['nombre'], ENT_QUOTES | ENT_HTML401, "UTF-8");
    $descripcion = html_entity_decode($_POST['desc'], ENT_QUOTES | ENT_HTML401, "UTF-8");

    if(empty($descripcion)){
        $_SESSION['status'] = "Debe agregar una descripción a la tarea.";
        header("Location: ../../presentacion/administrador/mantenimientos/editarMantenimiento.php?idMantenimiento=".$idMantenimiento."&id=".$id);
        exit();
    }else{

        $resultadoEditar = editarMantenimiento($nombre, $descripcion,$idMantenimiento);

        if($resultadoEditar === 1){
            $_SESSION['status'] = "Mantenimiento actualizado con éxito.";
            
            header("Location: ../../presentacion/administrador/mantenimientos/mantenimientos.php?id=".$id);
        }else{
            $_SESSION['status'] = "Hubo un error al actualizar el mantenimiento.";
            header("Location: ../../presentacion/administrador/mantenimientos/mantenimientos.php?id=".$id);
        }
    
    }
?>