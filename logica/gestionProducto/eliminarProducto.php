<?php
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionProducto/funcionesProducto.php';

    session_start();//Se inicia la sesión.
    //Se obtienen todos los datos que se mandaron al formulario.

    $id = htmlentities($_GET['id']);
    $idProd = htmlentities($_GET['idProducto']);

    $existe = buscarProductoXId($idProd);

    if($existe > 0 ){
      
        $idTienda = obtenerIdTienda($idProd);

        $resultadoEliminar = eliminarProducto($idProd);

        if($resultadoEliminar === 1){
            $_SESSION['status'] = "Producto eliminado con éxito.";
            header("Location: ../../presentacion/vendedor/productos/productos.php?id=".$id."&idTienda=".$idTienda);
        }else{
            $_SESSION['status'] = "Hubo un error al eliminar.";
            header("Location: ../../presentacion/vendedor/productos/productos.php?id=".$id."&idTienda=".$idTienda);
        }
    }
?>