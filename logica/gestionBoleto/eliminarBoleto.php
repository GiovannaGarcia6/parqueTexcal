<?php
    //Archivo que contiene las funciones de los boletos
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionBoleto/funcionesBoleto.php';

    session_start();//Se inicia la sesión.
    
    //Se obtienen y limpian todos los datos que se mandaron por el método GET.
    $idAdmin = htmlentities($_GET['id']); //Id del administrador
    $idBoleto = $_GET['idBoleto']; //Id del boleto
    
    //Se manda el id del boleto a la función que eliminará al boleto
    $resultado = eliminarBoleto($idBoleto);

    //Si el resultado retornado por la función es igual a 1, la eliminación ha sido exitosa
    if($resultado === 1){
        //Por lo que, se crea la variable de sesión con el mensaje que se mostrará en la página una vez que se redirija
        $_SESSION['status'] = "Tarifa eliminada con éxito.";
        header("Location: ../../presentacion/administrador/boletos/boletos.php?id=".$idAdmin);
    }else{
        //Se manda el mensaje de error y se redirigirse a la página de los boletos.
        $_SESSION['status'] = "Hubo un error al eliminar.";
        header("Location: ../../presentacion/administrador/boletos/boletos.php?id=".$idAdmin);
    }
?>