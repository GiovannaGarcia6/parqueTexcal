<?php 
    //Insertamos código de otro archivo 
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionLocal/funcionesLocal.php';
    session_start();//Se inicia la sesión.
    //Se obtienen todos los datos que se mandaron al formulario.
    $nombreNegocio = htmlentities($_POST['nombreNegocio']);
    $id = htmlentities($_POST['id']);

    $existe = consultarLocalXNombre($nombreNegocio);
    //Si es mayor a cero significa que la clave ya existe y debe redirigirse a la página de registrar.
    if($existe > 0 ){
        $_SESSION['status'] = "El negocio ya existe.";
        header("Location: ../../presentacion/vendedor/locales/agregarLocal.php?id=".$id);
        exit();
    }else{
        $resultado = agregarLocal($nombreNegocio, $id);
        if($resultado === 1){
            $_SESSION['status'] = "Negocio registrado con éxito.";
            header("Location: ../../presentacion/vendedor/locales/agregarLocal.php?id=".$id);
        }else{
            //Se manda el mensaje de error y se redirigirse a la página de registrar.
            $_SESSION['status'] = "Hubo un error al registrar.";
            header("Location: ../../presentacion/vendedor/locales/agregarLocal.php?id=".$id);
        }
    }
    mysqli_close($conn);//Se cierra la conexión
?>

