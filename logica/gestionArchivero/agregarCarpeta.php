<?php 
    //Insertamos código de otro archivo el cual contiene la conexión de la BD.
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionArchivero/funcionesArchivero.php';
    
    session_start();//Se inicia la sesión.
    //Se obtienen todos los datos que se mandaron al formulario.
    $nombreCarpeta =  htmlentities($_POST['nombreCarpeta']);
    $id =  htmlentities($_POST['id']);

    $existe = contarCarpetasXNombre($nombreCarpeta);

    if($existe > 0 ){
        $_SESSION['status'] = "La carpeta ya existe.";
        header("Location: ../../presentacion/administrador/archivero/carpetas/agregarCarpeta.php?id=".$id);
        exit();
    }else{
       
        $resultadoAgregar = agregarCarpeta($nombreCarpeta);
        if($resultadoAgregar === 1){
            $_SESSION['status'] = "Carpeta agregada con éxito.";
            header("Location: ../../presentacion/administrador/archivero/carpetas/agregarCarpeta.php?id=".$id);
        }else{
            //Se manda el mensaje de error y se redirigirse a la página de registrar.
            $_SESSION['status'] = "Hubo un error al registrar.";
            header("Location: ../../presentacion/administrador/archivero/carpetas/agregarCarpeta.php?id=".$id);
        }
    }
    mysqli_close($conn);//Se cierra la conexión
?>

