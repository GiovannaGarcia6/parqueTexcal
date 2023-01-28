<?php 
    //Insertamos código de otro archivo el cual contiene la conexión de la BD.
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionMantenimiento/funcionesMantenimiento.php';
    session_start();//Se inicia la sesión.

    //Se obtiene y se limpian los datos enviados
    $id = htmlentities($_GET['id']);
    $idMantenimiento = htmlentities($_GET['idMantenimiento']);
    $titulo = html_entity_decode($_POST['titulo'], ENT_QUOTES | ENT_HTML401, "UTF-8");
    $desc = html_entity_decode($_POST['desc'], ENT_QUOTES | ENT_HTML401, "UTF-8");
    $estado = htmlentities($_POST['estado']);
    $fechInic = strtotime($_POST['inic']);
    $fechTerm = strtotime($_POST['term']);
    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);

    //Se verifica que el textArea no se encuentre vacío ¡, ya que es necesario para la inserción del mantenimiento.
    if(empty($desc)){
        $_SESSION['status'] = "Debe agregar una descripción al mantenimiento.";
        header("Location: ../../presentacion/administrador/mantenimientos/agregarTarea.php?id=".$id."&idMantenimiento=".$idMantenimiento);
        exit();
    }else{
        
        //Se verifica si existe una tarea con ese titulo y que perteneza a ese id del mantenimiento.
        $existeTarea = contarTareasXTituloID($titulo, $idMantenimiento);

        //Se obtiene el id del trabajador con el correo electrónico.
        $idTrab = obtenerIdTrabajadorXCorreo($correo);

        //Si existe debe ser mayor a 0, por lo que se debe enviar el mensaje pertinente.
        if($existeTarea > 0 ){
            $_SESSION['status'] = "Ya hay una tarea con este título.";
            header("Location: ../../presentacion/administrador/mantenimientos/agregarTarea.php?id=".$id."&idMantenimiento=".$idMantenimiento);
            exit();
        }else{
            //En otro caso, nos indica que la tarea no ha sido registrada.
            //Por lo que, se llama a la función para enviarle los datos y que se realice la inserción.
            $resultadoAgregar = agregarTarea($titulo, $desc, $estado, $fechInic, $fechTerm, $idTrab, $idMantenimiento);

            //Si el resultado retornado por la función es igual a 1 indica que todo ha sido exitoso, caso contrario, ocurrió un error.
            if($resultadoAgregar === 1){
                $_SESSION['status'] = "Tarea registrada con éxito.";
                header("Location: ../../presentacion/administrador/mantenimientos/agregarTarea.php?id=".$id."&idMantenimiento=".$idMantenimiento);
            }else{
                $_SESSION['status'] = "Hubo un error al registrar.";
                header("Location: ../../presentacion/administrador/mantenimientos/agregarTarea.php?id=".$id."&idMantenimiento=".$idMantenimiento);
            }
        }
    
    }
?>