<?php
    //Insertamos código de otro archivo el cual contiene la conexión de la BD.
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionLocal/funcionesLocal.php';
    session_start();
    //Obtenemos el id del boleto
    $idNegocio = htmlentities($_GET['idNegocio']);
    $idVendedor = htmlentities($_GET['idVendedor']);
    
    $resultado = eliminarLocal($idNegocio);
    if($resultado === 1){
        $_SESSION['status'] = "Negocio y productos eliminados con éxito.";
        header("Location: ../../presentacion/vendedor/locales/locales.php?id=".$idVendedor);
    }else{
        //Se manda el mensaje de error y se redirigirse a la página de registrar.
        $_SESSION['status'] = "Hubo un error al eliminar.";
        header("Location: ../../presentacion/vendedor/locales/locales.php?id=".$idVendedor);
    }
?>