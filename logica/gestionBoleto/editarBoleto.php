<?php
    //Archivo que contiene las funciones de los boletos
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionBoleto/funcionesBoleto.php';

    session_start();//Se inicia la sesión.
    
    //Se obtienen y limpian todos los datos que se mandaron al formulario.
    $id = htmlentities($_POST['id']);
    $idTarifa = htmlentities($_POST['idTarifa']);
    $nombre = html_entity_decode($_POST['nombreTar'], ENT_QUOTES | ENT_HTML401, "UTF-8");
    $precio = htmlentities($_POST['precioTar']);
    $servicio = htmlentities($_POST['servicio']);

    //Se llama a la función consultarBoletosXServicio para saber si el nombre del boleto ya existe en el servicio
    $existe = consultarBoletoXServicio($servicio, $nombre, $idTarifa);

    //Si existe el resultado debe ser mayor a 0
    if( $existe > 0 ){
        //Por lo que, se crea la variable de sesión con el mensaje que se mostrará en la página una vez que se redirija
        $_SESSION['status'] = "No se ha podido modificar debido al nombre del boleto.";
        header("Location: ../../presentacion/administrador/boletos/editarBoleto.php?id=".$id."&idBoleto=".$idTarifa."");
        exit();
    }else{

        //En caso de que no existan se mandan los datos a la función que se encargará de realizar la actualización de los nuevos datos
        $resultado = editarBoleto($precio, $nombre, $servicio, $idTarifa);
       
        //Si el resultado retornado por la función es igual a 1, el proceso ha sido exitoso
        if($resultado === 1){
            //Se almacena el mensaje en la variable de sesión
            $_SESSION['status'] = "Tarifa actualizada con éxito.";
            //Se dirige a la página de boletos
            header("Location: ../../presentacion/administrador/boletos/boletos.php?id=".$id);

        }else{
            //Se manda el mensaje de error y se redirigirse a la página de editar.
            $_SESSION['status'] = "Hubo un error al actualizar.";
            header("Location: ../../presentacion/administrador/boletos/editarBoleto.php?id=".$id."&idBoleto=".$idTarifa."");
        }
    }
?>