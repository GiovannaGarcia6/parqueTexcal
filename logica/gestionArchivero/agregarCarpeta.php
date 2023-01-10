<?php 
    //Archivo que nos permite acceder a las funciones del archivero
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionArchivero/funcionesArchivero.php';
    
    session_start();//Se inicia la sesión.

    //Se obtienen todos los datos que se mandaron al formulario.
    $nombreCarpeta =  htmlentities($_POST['nombreCarpeta']);
    $id =  htmlentities($_POST['id']);

    //Se verifica que no exista otra carpeta con ese nombre
    $existe = contarCarpetasXNombre($nombreCarpeta);

    //Si existe se crea una variable de sesión con el mensaje a mostrar en la página del formulario para agregar
    if($existe > 0 ){
        $_SESSION['status'] = "La carpeta ya existe.";
        header("Location: ../../presentacion/administrador/archivero/carpetas/agregarCarpeta.php?id=".$id);
        exit();
    }else{
        //Se realiza la inserción de la nueva carpeta
        $resultadoAgregar = agregarCarpeta($nombreCarpeta);

        //Si el resultado retornado por la función es igual a 1, la carpeta fue regristrada con éxito
        if($resultadoAgregar === 1){
            $_SESSION['status'] = "Carpeta agregada con éxito.";
            //se redirige a la página de agregar carpeta
            header("Location: ../../presentacion/administrador/archivero/carpetas/agregarCarpeta.php?id=".$id);
        }else{
            //Se crea la variable de sesión con el mensaje de error y se redirige a la página de agregar carpeta
            $_SESSION['status'] = "Hubo un error al registrar.";
            header("Location: ../../presentacion/administrador/archivero/carpetas/agregarCarpeta.php?id=".$id);
        }
    }
?>

