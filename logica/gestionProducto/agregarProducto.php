<?php 
    //Se requiere al archivo que contiene las funciones de los productos
    require '../../datos/gestionProducto/funcionesProducto.php';

    session_start();//Se inicia la sesión.

    //Se obtienen y limpian todos los datos que se mandaron al formulario.
    $id = htmlentities($_POST['id']);
    $idTienda = htmlentities($_POST['idTienda']);
    $nombreProducto = html_entity_decode($_POST['nombreProducto'], ENT_QUOTES | ENT_HTML401, "UTF-8");
    $precioProducto = htmlentities($_POST['precioProducto']);
    $descProducto = html_entity_decode($_POST['descProducto'], ENT_QUOTES | ENT_HTML401, "UTF-8");
    $archivo = addslashes(file_get_contents( $_FILES['archivo']['tmp_name'])); 
    $tipoImagen = $_FILES['archivo']['type'];

    //verficar que el campo de la descripción del producto no este vacía
    if(empty($descProducto)){
        //Si lo está se debe mandar un mensaje a la interfaz del usuario
        $_SESSION['status'] = "Debe agregar una descripción a la publicación.";
        header("Location: ../../presentacion/vendedor/productos/agregarProducto.php?id=".$id."&idTienda=".$idTienda);
        exit();
    }else{
        //Se verifica que el tipo de la imagen del producto sea de tipo jpeg, j`pg o png
        if (!(strpos($tipoImagen, "jpeg") || strpos($tipoImagen, "jpg") || strpos($tipoImagen, "png"))){
            //Se manda un mensaje al usuario para hacerle saber que tipos de imagen son aceptados
            $_SESSION['status'] = "La imagen debe ser de tipo jpeg, jpg o png.";
            header("Location: ../../presentacion/vendedor/productos/agregarProducto.php?id=".$id."&idTienda=".$idTienda);
        }else{
            
            $existe = consultarProductoXNombre($nombreProducto, $idTienda);
            //Si es mayor a cero significa que la clave ya existe y debe redirigirse a la página de registrar.
            if($existe > 0 ){
                $_SESSION['status'] = "El producto ya existe.";
                header("Location: ../../presentacion/vendedor/productos/agregarProducto.php?id=".$id."&idTienda=".$idTienda);
                exit();
            }else{
                
                $resultadoInsertar = agregarProducto($nombreProducto, $precioProducto, $descProducto, $archivo, $idTienda);
                if($resultadoInsertar === 1){
                    $_SESSION['status'] = "Producto agregado con éxito.";
                    header("Location: ../../presentacion/vendedor/productos/agregarProducto.php?id=".$id."&idTienda=".$idTienda);
                }else{
                    //Se manda el mensaje de error y se redirigirse a la página de registrar.
                    $_SESSION['status'] = "Hubo un error al agregar.";
                    header("Location: ../../presentacion/vendedor/productos/agregarProducto.php?id=".$id."&idTienda=".$idTienda);
                }
            }
        }
    }
    mysqli_close($conn);//Se cierra la conexión
?>