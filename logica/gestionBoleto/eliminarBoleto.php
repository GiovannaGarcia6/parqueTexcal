<?php
    //Insertamos código de otro archivo el cual contiene la conexión de la BD.
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionBoleto/funcionesBoleto.php';

    session_start();
    
    $id=$_GET['id'];//Se obtiene el id del administrador
    //Obtenemos el id del boleto
    $idTarifa = $_GET['idBoleto'];
    
    $resultado = eliminarBoleto($id,$idTarifa);

    if($resultado === 1){
        $_SESSION['status'] = "Tarifa eliminada con éxito.";
        header("Location: ../../presentacion/administrador/boletos/boletos.php?id=".$id);
    }else{
        //Se manda el mensaje de error y se redirigirse a la página de registrar.
        $_SESSION['status'] = "Hubo un error al eliminar.";
        header("Location: ../../presentacion/administrador/boletos/boletos.php?id=".$id);
    }
?>