<?php
    //Requerimos del archivo para realizar la conexión.
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionProducto/funcionesProducto.php';
    session_start();
    //Se obtiene los datos que se enviaron del formulario.
    $idProducto = htmlentities($_POST['idProducto']);
    $idTienda = htmlentities($_POST['idTienda']);
    $idTrabajador = htmlentities($_POST['idTrabajador']);
    $nombreProducto = html_entity_decode($_POST['nombreProducto'], ENT_QUOTES | ENT_HTML401, "UTF-8");
    $precioProducto = htmlentities($_POST['precioProducto']);
    $descProducto = html_entity_decode($_POST['descProducto'], ENT_QUOTES | ENT_HTML401, "UTF-8");;
    $archivo = $_FILES['archivo']['tmp_name']; 
   
    $existe = consultarProductoID($nombreProducto, $idTienda);
    if($existe > 0 ){
        $_SESSION['status'] = "No se ha podido modificar debido al nombre del producto.";
        header("Location: ../../presentacion/vendedor/productos/editarProducto.php?id=".$idProducto."&idTrab=".$idTrabajador);
        exit();
    }else{
        if(empty($descProducto)){
            $_SESSION['status'] = "Debe agregar una descripción a la publicación.";
            header("Location: ../../presentacion/vendedor/productos/editarProducto.php?id=".$idProducto."&idTrab=".$idTrabajador);
            exit();
        }else{
            $bandera = 0;

            if ($archivo != '' || $archivo != null) {
                $tipoImagen = $_FILES['archivo']['type'];

                echo "".$tipoImagen;
                $archivo = addslashes(file_get_contents($_FILES['archivo']['tmp_name'])); 
                if (!(strpos($tipoImagen, "jpeg") || strpos($tipoImagen, "jpg") || strpos($tipoImagen, "png"))) {
                    $_SESSION['status'] = "La imagen debe ser de tipo jpeg, jpg o png.";
                    header("Location: ../../presentacion/vendedor/productos/editarProducto.php?id=".$idProducto."&idTrab=".$idTrabajador);
                    exit();
                    
                }else{
                    $bandera = 1;
                }  
    
            }else{
                $bandera = 0;
            }
             

            if($bandera === 1){
                $resultadoEditar =editarProducto(1, $nombreProducto, $precioProducto, $descProducto, $archivo, $idProducto);
                
            }else{
                $resultadoEditar = editarProducto(0, $nombreProducto, $precioProducto, $descProducto, 0, $idProducto);
            }
    
            if($resultadoEditar === 1){
                $_SESSION['status'] = "Producto actualizado con éxito.";
                header("Location: ../../presentacion/vendedor/productos/productos.php?id=".$idTrabajador."&idTienda=".$idTienda);
            }else{
                //Se manda el mensaje de error y se redirigirse a la página de registrar.
                $_SESSION['status'] = "Hubo un error al actualizar.";
                header("Location: ../../presentacion/vendedor/productos/productos.php?id=".$idTrabajador."&idTienda=".$idTienda);
            }
        }
    }
?>