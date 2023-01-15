<?php 
    //Archivo que contiene las funciones de los boletos
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionBoleto/funcionesBoleto.php';

    session_start();//Se inicia la sesión.
    
    //Se obtienen y limpian todos los datos que se mandaron al formulario.
    $id = htmlentities($_POST['id']);
    $nombre = html_entity_decode(htmlentities($_POST['nombre']), ENT_QUOTES | ENT_HTML401, "UTF-8");
    $precio = htmlentities($_POST['precio']);
    $servicio = htmlentities($_POST['servicio']);

    //Se llama a la función consultarBoletosXNombre para saber si el nombre del boleto ya existe
    $existe = consultarBoletosXNombre($nombre);

    //Si existe el resultado debe ser mayor a 0
    if($existe > 0 ){
        //Por lo que, se crea la variable de sesión con el mensaje que se mostrará en la página una vez que se redirija
        $_SESSION['status'] = "El boleto ya existe.";
        header("Location: ../../presentacion/administrador/boletos/agregarBoleto.php?id=".$id);
        exit();
    }else{
       
        //En caso de que no existan se mandan los datos a la función que se encargará de realizar la inserción del nuevo registro
        $resultado = agregarBoleto($precio,$nombre,$servicio);

        //Si el resultado retornado por la función es igual a 1, el proceso ha sido exitoso
        if($resultado === 1){
            //Se almacena el mensaje en la variable de sesión
            $_SESSION['status'] = "Tarifa registrada con éxito.";
            //Se dirige a la página de agregar boleto
            header("Location: ../../presentacion/administrador/boletos/agregarBoleto.php?id=".$id);
        }else{
            //Se manda el mensaje de error y se redirigirse a la página de agregar boleto.
            $_SESSION['status'] = "Hubo un error al registrar.";
            header("Location: ../../presentacion/administrador/boletos/agregarBoleto.php?id=".$id);
        }
    }
?>
