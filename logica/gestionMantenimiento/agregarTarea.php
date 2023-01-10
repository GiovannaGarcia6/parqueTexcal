<?php 
    //Insertamos código de otro archivo el cual contiene la conexión de la BD.
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionMantenimiento/funcionesMantenimiento.php';
    session_start();//Se inicia la sesión.
    $id = htmlentities($_GET['id']);
    $idMantenimiento = htmlentities($_GET['idMantenimiento']);
    //Se obtienen todos los datos que se mandaron al formulario.
    $titulo = html_entity_decode($_POST['titulo'], ENT_QUOTES | ENT_HTML401, "UTF-8");
    $desc = html_entity_decode($_POST['desc'], ENT_QUOTES | ENT_HTML401, "UTF-8");
    $estado = htmlentities($_POST['estado']);
    $fechInic = strtotime($_POST['inic']);
    $fechTerm = strtotime($_POST['term']);
    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);

    if(empty($desc)){
        $_SESSION['status'] = "Debe agregar una descripción al mantenimiento.";
        header("Location: ../../presentacion/administrador/mantenimientos/agregarTarea.php?id=".$id."&idMantenimiento=".$idMantenimiento);
        exit();
    }else{
        $existeTarea = contarTareasXTituloID($titulo, $idMantenimiento);

        $idTrab = obtenerIdTrabajadorXCorreo($correo);

        if($existeTarea > 0 ){
            $_SESSION['status'] = "Ya hay una tarea con este título.";
            header("Location: ../../presentacion/administrador/mantenimientos/agregarTarea.php?id=".$id."&idMantenimiento=".$idMantenimiento);
            exit();
        }else{
            
            $resultadoAgregar = agregarTarea($titulo, $desc, $estado, $fechInic, $fechTerm, $idTrab, $idMantenimiento);

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