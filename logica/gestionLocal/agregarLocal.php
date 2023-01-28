<?php 
    //Archivo que contiene las funciones de los locales y que permiten realizar consultas u operaciones a la base de datos.
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionLocal/funcionesLocal.php';

    session_start();//Se inicia la sesión.

    //Se obtienen y se limpian todos los datos que se mandaron al formulario.
    $nombreNegocio = htmlentities($_POST['nombreNegocio']);
    $id = htmlentities($_POST['id']);

    //Se realiza un llamado a la función para verificar si el nombre del negocio existe en la base de datos.
    $existe = consultarLocalXNombre($nombreNegocio);
    ç
    //Si es mayor a cero significa que el nombre del negocio ya existe y debe redirigirse a la página de agregar local.
    if($existe > 0 ){
        $_SESSION['status'] = "El negocio ya existe.";
        header("Location: ../../presentacion/vendedor/locales/agregarLocal.php?id=".$id);
        exit();
    }else{
        //De otra manera, esto indica que el negocio no existe.
        //Por lo que, se llama a la función agregarLocal y se le mandan los datos necesarios para realizar la inserción.
        $resultado = agregarLocal($nombreNegocio, $id);

        //Si el resultado retornado por la función es igual a 1 indica que todo ha sido exitoso, caso contrario, ocurrió un error.
        if($resultado === 1){
            //Se manda el mensaje de éxito y se redirige a la página de agregarLocal
            $_SESSION['status'] = "Negocio registrado con éxito.";
            header("Location: ../../presentacion/vendedor/locales/agregarLocal.php?id=".$id);
        }else{
            //Se manda el mensaje de error y se redirige a la página de agregarLocal.
            $_SESSION['status'] = "Hubo un error al registrar.";
            header("Location: ../../presentacion/vendedor/locales/agregarLocal.php?id=".$id);
        }
    }
    mysqli_close($conn);//Se cierra la conexión
?>

