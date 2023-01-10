<?php
    //Requerimos del archivo para realizar la conexión.
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionBoleto/funcionesBoleto.php';
    session_start();
    $id=$_POST['id'];//Se obtiene el id del administrador
    //Se obtiene los datos que se enviaron del formulario.
    $idTarifa = $_POST['idTarifa'];
    $nombre = html_entity_decode($_POST['nombreTar'], ENT_QUOTES | ENT_HTML401, "UTF-8");
    $precio = $_POST['precioTar'];
    $servicio = $_POST['servicio'];
    $existe = consultarBoletoXServicio($servicio, $nombre, $idTarifa);
    //Si es mayor a cero significa que la clave ya existe y debe redirigirse a la página de registrar.
    if( $existe > 0 ){
  
        $_SESSION['status'] = "No se ha podido modificar debido al nombre del boleto.";
        header("Location: ../../presentacion/administrador/boletos/editarBoleto.php?id=".$id."&idBoleto=".$idTarifa."");
        exit();
    }else{
        $resultado = editarBoleto($precio, $nombre, $servicio, $idTarifa);
       
        if($resultado === 1){
            $_SESSION['status'] = "Tarifa actualizada con éxito.";
            header("Location: ../../presentacion/administrador/boletos/boletos.php?id=".$id);

        }else{
            //Se manda el mensaje de error y se redirigirse a la página de editar.
            $_SESSION['status'] = "Hubo un error al actualizar.";
            header("Location: ../../presentacion/administrador/boletos/editarBoleto.php?id=".$id."&idBoleto=".$idTarifa."");
        }
    }
?>