<?php 
    //Insertamos código de otro archivo de las funciones.
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionPublicacion/funcionesPublicacion.php';

    session_start();//Se inicia la sesión.

    //Se obtienen y se limpian todos los datos que se mandaron al formulario.
    $idAdmin = htmlentities($_POST['idAdmin']);
    $idPublicacion = htmlentities($_POST['idPublicacion']);
    $servicio = htmlentities($_POST['servicio']);
    $titulo = htmlentities($_POST['titulo']);
    $descripcion = htmlentities($_POST['publicacion']);
    $tipoPublicacion = htmlentities($_POST['tipoPublicacion']);

    //Se verifica que el textarea de la descripción no este vacío, en caso de ser así se notifica al usuario
    if(empty($descripcion)){
        //Se crea la variable de sesion con el mensaje
        $_SESSION['status'] = "Debe agregar una descripción a la publicación.";
        //Se redirige a la pagína de agregar publicación
        header("Location: ../../presentacion/administrador/publicaciones/editarPublicacion.php?id=".$idAdmin."&idPublicacion=".$idPublicacion);
        exit();
    }else{
        //Se inicializa una bandera en 0 que permitira saber si el enlace del video o de la imagen han creado correctamente el nuevo url
        $bandera = 0;

        //Se verifica el tipo de publicación con el fin de realizar acciones para cada caso
        if($tipoPublicacion === "Video"){
            //En este caso si es un video, se obtiene el dato enviado del formulario
            $urlVideo = htmlentities($_POST['video']);
            //Se cambia el valor de la bandera a 1
            $bandera = 1;
            //Se cuenta la longitud de la url del video
            $cantidad_url_video = strlen($urlVideo);
            
            // Encuentra la posición de la primera ocurrencia de un substring en un string, en este caso el substring es https://www.youtube.com/embed/ 
            //y el string es la url completa que se encuentra almacenada en la base de datos
            $urlBD = strpos($urlVideo, "https://www.youtube.com/embed/");

            //Se cambia https://www.youtube.com/embed/ por la url correspondiente a la longitud de la url
            if($urlBD !== false){
                $ruta = $urlVideo;
            }elseif ($cantidad_url_video == '28') {
                $cortar_url = str_replace ('https://youtu.be/','',$urlVideo);
                $ruta = 'https://www.youtube.com/embed/' .$cortar_url; 

            }elseif ($cantidad_url_video == '41') {
                $cortar_url = str_replace ('https://m.youtube.com/watch?v=','',$urlVideo);
                $ruta = 'https://www.youtube.com/embed/' .$cortar_url; 

            }elseif ($cantidad_url_video == '43') {
                $cortar_url = str_replace ('https://www.youtube.com/watch?v=','',$urlVideo);
                $ruta = 'https://www.youtube.com/embed/' .$cortar_url; 

            }elseif ($cantidad_url_video == '58') {
                $cortar_url = str_replace ('https://m.youtube.com/watch?v=','',$urlVideo);
                $ruta = 'https://www.youtube.com/embed/' .$cortar_url; 

            }elseif ($cantidad_url_video == '60') {
                $cortar_url = str_replace ('https://www.youtube.com/watch?v=','',$urlVideo);
                $ruta = 'https://www.youtube.com/embed/' .$cortar_url; 
            
            }else{
                //En caso de que la longitud no sea como los casos anteriores, se cambia de nuevo la bandera a 0
                $bandera = 0;
                //Se crea la variable de sesión con el mensaje de url inválida
                $_SESSION['status'] = "Url inválida.";
                //y se redirige a la página de editar publicación para mostrar el mensaje
                header("Location: ../../presentacion/administrador/publicaciones/editarPublicacion.php?id=".$idAdmin."&idPublicacion=".$idPublicacion);
            }

        }else{

            //se obtiene la imagen con files
            $imagen = $_FILES['imagen']['tmp_name'];

            //Se verifica que no sea nulo o que este vacío
            if ($imagen != '' || $imagen != null) {

                //Si el tipo de publicacón es una imagen, de la imagen obtenida se verifica el tipo de imagen
                $tipo = $_FILES['imagen']['type'];
    
                //Las imágenes que estan permitidas para almacenarlas son jpeg, jpg y png
                if (!(strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png"))) {
                    //Si se incumple la condición se manda un mensaje con la variable de sesión
                    $_SESSION['status'] = "La imagen debe ser de tipo jpeg, jpg o png.";
                    //y se redirige a la página de agregar publicación para mostrar el mensaje
                    header("Location: ../../presentacion/administrador/publicaciones/editarPublicacion.php?id=".$idAdmin."&idPublicacion=".$idPublicacion);
                }else{
                    //Si cumple con el tipo de imagen, el valor de la bandera cambia a 1
                    $bandera = 1;
                    //Se obtiene la ruta de la imagen
                    $ruta = rutaImagen($idPublicacion);
                    //Se completa la ruta con la ubicación de la imagen
                    $imagenEliminar = "../../presentacion/".$ruta['archivo'];
                    //Se elimina la imagen de la carpeta del sistema
                    unlink($imagenEliminar);
                    //Se obtiene la nueva imagen
                    $nombreImg = $_FILES['imagen']['name'];
                    //Se crea la ruta
                    $ruta = 'imagenesTemp/'.$nombreImg;
                    //Se mueve la imagen a la carpeta
                    move_uploaded_file($imagen, "../../presentacion/".$ruta);
                }  
            }else{
                //Se cambia la bandera a 0
                $bandera = 0;
            }
        }

        //Si la bandera es igual a 1 nos indica que se realizará una actualización en la ruta.
        //En caso de que la bandera sea 0 se actualizarán los demás campos excepto el de la ruta.
        if($bandera === 1){
            $resultadoEditar = editarPublicacion(1,$tipoPublicacion,$ruta,$titulo,$descripcion,$servicio,$idPublicacion);
            
        }else{
            $resultadoEditar = editarPublicacion(0,$tipoPublicacion,0,$titulo,$descripcion,$servicio,$idPublicacion);
        }

        //Si el resultado de la ejecución devuelve un 1 esté se realizo con éxito, si devuelve 0 ocurrió un error
        if($resultadoEditar === 1){
            //Se manda un mensaje con la variable de sesión
            $_SESSION['status'] = "Publicación actualizada con éxito.";
            //y se redirige a la página de editar publicación para mostrar el mensaje
            header("Location: ../../presentacion/administrador/publicaciones/publicaciones.php?id=".$idAdmin."&idPublicacion=".$idPublicacion);
        }else{
            //Se manda un mensaje con la variable de sesión
            $_SESSION['status'] = "Hubo un error al actualizar la publicación.";
            //y se redirige a la página de editar publicación para mostrar el mensaje
            header("Location: ../../presentacion/administrador/publicaciones/editarPublicacion.php?id=".$idAdmin."&idPublicacion=".$idPublicacion);
        }
        
    }

?>