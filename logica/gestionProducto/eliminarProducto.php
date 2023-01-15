<?php
    //Requerimos del archivo para usar las funciones de los productos
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionProducto/funcionesProducto.php';

    session_start();//Se inicia la sesión.

    //Se obtienen todos los datos que se mandaron por el método GET
    $id = htmlentities($_GET['id']);
    $idProd = htmlentities($_GET['idProducto']);

    //Se verifica si existe el producto
    $existe = buscarProductoXId($idProd);

    //Si existe se debe ser eliminado
    if($existe > 0 ){
      
        //Se obtiene el id de la tienda a la que corresponde el producto
        $idTienda = obtenerIdTienda($idProd);

        //Se realiza la eliminación del producto
        $resultadoEliminar = eliminarProducto($idProd);

        //Si el resultado retornado es 1 indica que se elimino correctamente
        if($resultadoEliminar === 1){
            //Se envia el mensaje de exito y se dirige a la página de productos
            $_SESSION['status'] = "Producto eliminado con éxito.";
            header("Location: ../../presentacion/vendedor/productos/productos.php?id=".$id."&idTienda=".$idTienda);
        }else{
            //Se envia el mensaje de error y se dirige a la página de productos
            $_SESSION['status'] = "Hubo un error al eliminar.";
            header("Location: ../../presentacion/vendedor/productos/productos.php?id=".$id."&idTienda=".$idTienda);
        }
    }
?>