<?php 

    //Archivo que contiene las funciones de los mantenimientos y que permiten realizar consultas u operaciones a la base de datos.
    require '../../datos/gestionMantenimiento/funcionesMantenimiento.php';

    session_start();//Se inicia la sesión.

    //Se obtiene y se limpian los datos enviados
    $id = htmlentities($_GET['id']);
    $nombre = html_entity_decode($_POST['nombre'], ENT_QUOTES | ENT_HTML401, "UTF-8");
    $descripcion = html_entity_decode($_POST['desc'], ENT_QUOTES | ENT_HTML401, "UTF-8");
    
    //Se verifica que el textArea no se encuentre vacío ¡, ya que es necesario para la inserción del mantenimiento.
    if(empty($descripcion)){
        //Se envía un mensaje en la variable de sesión, el cuál es mostrado una vez que se redirija a la página de agregar mantenimientos.
        $_SESSION['status'] = "Debe agregar una descripción al mantenimiento.";
        header("Location: ../../presentacion/administrador/mantenimientos/agregarMantenimiento.php?id=".$id);
        exit();
    }else{

        //Se verifica si existe un manteniento con ese nombre
        $existe = contarMantenimientosXNombre($nombre);

        //Si existe debe ser mayor a 0, por lo que se debe enviar el mensaje pertinente.
        if($existe > 0 ){
            $_SESSION['status'] = "Ya hay un mantenimiento con este nombre.";
            header("Location: ../../presentacion/administrador/mantenimientos/agregarMantenimiento.php?id=".$id);
            exit();
        }else{
            //En otro caso, nos indica que el nombre del mantenimiento no ha sido registrado.
            //Por lo que, se llama a la función para enviarle los datos y que se realice la inserción.
            $resultadoAgregar = agregarMantenimiento($nombre, $descripcion);

            //Si el resultado retornado por la función es igual a 1 indica que todo ha sido exitoso, caso contrario, ocurrió un error.
            if($resultadoAgregar === 1){
                //Se manda el mensaje de éxito y se redirige a la página de agregar mantenimiento.
                $_SESSION['status'] = "Mantenimiento registrado con éxito.";
                header("Location: ../../presentacion/administrador/mantenimientos/agregarMantenimiento.php?id=".$id);
            }else{
                //Se manda el mensaje de error y se redirigirse a la página de agregar mantenimiento.
                $_SESSION['status'] = "Hubo un error al registrar.";
                header("Location: ../../presentacion/administrador/mantenimientos/agregarMantenimiento.php?id=".$id);
            }
        }
 
    }
?>