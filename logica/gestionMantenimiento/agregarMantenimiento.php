<?php 

    require '../../datos/gestionMantenimiento/funcionesMantenimiento.php';

    session_start();//Se inicia la sesión.

    $id = htmlentities($_GET['id']);
    //Se obtienen todos los datos que se mandaron al formulario.
    $nombre = htmlentities($_POST['nombre']);
    $descripcion = htmlentities($_POST['desc']);
    
    if(empty($descripcion)){
        $_SESSION['status'] = "Debe agregar una descripción al mantenimiento.";
        header("Location: ../../presentacion/administrador/mantenimientos/agregarMantenimiento.php?id=".$id);
        exit();
    }else{
        $existe = contarMantenimientosXNombre($nombre);

        if($existe > 0 ){
            $_SESSION['status'] = "Ya hay un mantenimiento con este nombre.";
            header("Location: ../../presentacion/administrador/mantenimientos/agregarMantenimiento.php?id=".$id);
            exit();
        }else{
            
            $resultadoAgregar = agregarMantenimiento($nombre, $descripcion);
            if($resultadoAgregar === 1){
                $_SESSION['status'] = "Mantenimiento registrado con éxito.";
                header("Location: ../../presentacion/administrador/mantenimientos/agregarMantenimiento.php?id=".$id);
            }else{
                //Se manda el mensaje de error y se redirigirse a la página de agregarEmpleado.
                $_SESSION['status'] = "Hubo un error al registrar.";
                header("Location: ../../presentacion/administrador/mantenimientos/agregarMantenimiento.php?id=".$id);
            }
        }
 
    }
?>