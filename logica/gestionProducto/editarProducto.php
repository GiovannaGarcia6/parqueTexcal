<?php
    //Requerimos del archivo para usar las funciones de los productos
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionProducto/funcionesProducto.php';

    session_start(); //Se inicia sesión

    //Se obtienen y limpian los datos que se enviaron del formulario.
    $idProducto = htmlentities($_POST['idProducto']);
    $idTienda = htmlentities($_POST['idTienda']);
    $idTrabajador = htmlentities($_POST['idTrabajador']);
    $nombreProducto = html_entity_decode($_POST['nombreProducto'], ENT_QUOTES | ENT_HTML401, "UTF-8");
    $precioProducto = htmlentities($_POST['precioProducto']);
    $descProducto = html_entity_decode($_POST['descProducto'], ENT_QUOTES | ENT_HTML401, "UTF-8");;
    $archivo = $_FILES['archivo']['tmp_name']; 
   
    //Se verifica si existe ese producto en la tienda
    $existe = consultarProductoID($nombreProducto, $idTienda);

    //Si el resultado es mayor a 0, indica que si existe un procuto con el mismo nombre
    if($existe > 0 ){
        //Se envía el mensaje correspondiente al usuario
        $_SESSION['status'] = "No se ha podido modificar debido al nombre del producto.";
        header("Location: ../../presentacion/vendedor/productos/editarProducto.php?id=".$idProducto."&idTrab=".$idTrabajador);
        exit();
    }else{
        //En otro caso se continúa con la siguiente verificación que es revisar si el campo de la descripción esta vacío
        if(empty($descProducto)){
            //Se envía el mensaje correspondiente al usuario
            $_SESSION['status'] = "Debe agregar una descripción a la publicación.";
            header("Location: ../../presentacion/vendedor/productos/editarProducto.php?id=".$idProducto."&idTrab=".$idTrabajador);
            exit();
        }else{
            //Inicializa una bandera para saber cuando se debe actualizar la imagen o no
            $bandera = 0;

            //Se verifica que el archivo no este vacío o no sea nulo
            if ($archivo != '' || $archivo != null) {
                //se almacena el tipo de imagen
                $tipoImagen = $_FILES['archivo']['type'];

                //Se añaden slashes al archivo
                $archivo = addslashes(file_get_contents($_FILES['archivo']['tmp_name'])); 

                //Se verifica el tipo de imagen
                if (!(strpos($tipoImagen, "jpeg") || strpos($tipoImagen, "jpg") || strpos($tipoImagen, "png"))) {
                    //Se envía el mensaje correspondiente al usuario
                    $_SESSION['status'] = "La imagen debe ser de tipo jpeg, jpg o png.";
                    header("Location: ../../presentacion/vendedor/productos/editarProducto.php?id=".$idProducto."&idTrab=".$idTrabajador);
                    exit();
                }else{
                    //Se cambia el valor de la bandera
                    $bandera = 1;
                }  
            }else{
                $bandera = 0;
            }
             
            //Dependiendo del valor de la variable se envían los datos 
            if($bandera === 1){
                $resultadoEditar =editarProducto(1, $nombreProducto, $precioProducto, $descProducto, $archivo, $idProducto);
                
            }else{
                $resultadoEditar = editarProducto(0, $nombreProducto, $precioProducto, $descProducto, 0, $idProducto);
            }
    
            //Si el resultado retornado es 1 indica que el producto fue actualizado correctamente
            if($resultadoEditar === 1){
                //Se envía el mensaje correspondiente al usuario
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