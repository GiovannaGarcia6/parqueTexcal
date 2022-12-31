<?php
    //Requerimos del archivo para realizar la conexión.
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionLocal/funcionesLocal.php';
    session_start();
    //Se obtiene los datos que se enviaron del formulario.
    $idNegocio = htmlentities($_POST['idNegocio']);
    $nombreNegocio = htmlentities($_POST['nombreNegocio']);
    $idVendedor = htmlentities($_POST['idVendedor']);
    
    $existe = existeLocalIgual($idNegocio,$nombreNegocio);
    //Si es mayor a cero significa que la clave ya existe y debe redirigirse a la página de registrar.
    if($existe > 0 ){
        $_SESSION['status'] = "No se ha podido modificar debido al nombre del negocio.";
        header("Location: ../../presentacion/vendedor/locales/editarLocal.php?id=".$idNegocio."");
        exit();
    }else{
        $resultado = editarLocal($nombreNegocio,$idNegocio);

        if($resultado === 1){
            $_SESSION['status'] = "Negocio actualizado con éxito.";
            header("Location: ../../presentacion/vendedor/locales/locales.php?id=".$idVendedor);
        }else{
            //Se manda el mensaje de error y se redirigirse a la página de registrar.
            $_SESSION['status'] = "Hubo un error al actualizar.";
            header("Location: ../../presentacion/vendedor/locales/editarLocal.php?id=".$idNegocio."");
        }
    }
?>