<?php 
    //Insertamos código de otro archivo el cual contiene la conexión de la BD.
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionBoleto/funcionesBoleto.php';
    session_start();//Se inicia la sesión.
    $id=$_POST['id'];//Se obtiene el id del administrador
    //Se obtienen todos los datos que se mandaron al formulario.
    $nombre = html_entity_decode($_POST['nombre'], ENT_QUOTES | ENT_HTML401, "UTF-8");
    $precio = $_POST['precio'];
    $servicio = $_POST['servicio'];

    $existe = consultarBoletosXNombre($nombre);

    if($existe > 0 ){
        $_SESSION['status'] = "El boleto ya existe.";
        header("Location: ../../presentacion/administrador/boletos/agregarBoleto.php?id=".$id);
        exit();
    }else{
       
        $resultado = agregarBoleto($precio,$nombre,$servicio);

        if($resultado === 1){
            $_SESSION['status'] = "Tarifa registrada con éxito.";
            header("Location: ../../presentacion/administrador/boletos/agregarBoleto.php?id=".$id);
        }else{
            //Se manda el mensaje de error y se redirigirse a la página de registrar.
            $_SESSION['status'] = "Hubo un error al registrar.";
            header("Location: ../../presentacion/administrador/boletos/agregarBoleto.php?id=".$id);
        }
    }
?>
