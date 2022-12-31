<?php 
    //Insertamos código de otro archivo de las funciones.
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionPublicacion/funcionesPublicacion.php';
    session_start();//Se inicia la sesión.
    //Se obtienen todos los datos que se mandaron al formulario.
    $idAdmin = htmlentities($_POST['idAdmin']);
    $idPublicacion = htmlentities($_POST['idPublicacion']);
    $servicio = htmlentities($_POST['servicio']);
    $titulo = htmlentities($_POST['titulo']);
    $descripcion = htmlentities($_POST['publicacion']);
    $tipoPublicacion = htmlentities($_POST['tipoPublicacion']);

    if(empty($descripcion)){
        $_SESSION['status'] = "Debe agregar una descripción a la publicación.";
        header("Location: ../../presentacion/administrador/publicaciones/editarPublicacion.php?id=".$idAdmin."&idPublicacion=".$idPublicacion);
        exit();
    }else{
        $bandera = 0;
        if($tipoPublicacion === "Video"){
            $urlVideo = $_POST['video'];
            $bandera = 1;
            $cantidad_url_video = strlen($urlVideo);
            $urlBD = strpos($urlVideo, "https://www.youtube.com/embed/");
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
                $bandera = 0;
                $_SESSION['status'] = "Url inválida.";
                header("Location: ../../presentacion/administrador/publicaciones/editarPublicacion.php?id=".$idAdmin."&idPublicacion=".$idPublicacion);
            }

        }else{
            $imagen = $_FILES['imagen']['tmp_name'];

            if ($imagen != '' || $imagen != null) {

                $tipo = $_FILES['imagen']['type'];
    
                if (!(strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png"))) {
                    $_SESSION['status'] = "La imagen debe ser de tipo jpeg, jpg o png.";
                    header("Location: ../../presentacion/administrador/publicaciones/editarPublicacion.php?id=".$idAdmin."&idPublicacion=".$idPublicacion);
                }else{
                    $bandera = 1;
                    
                    $filas= rutaImagen($idPublicacion);
                    //Se obtienen la imagen almacenada en la bd
                    $imagenEliminar = "../../presentacion/".$filas['archivo'];
                    unlink($imagenEliminar);
                    $nombreImg = $_FILES['imagen']['name'];
                    $ruta = 'imagenesTemp/'.$nombreImg;
                    move_uploaded_file($imagen, "../../presentacion/".$ruta);
                }  
            }else{
                $bandera = 0;
            }
        }

        if($bandera === 1){
            $resultadoEditar = editarPublicacion(1,$tipoPublicacion,$ruta,$titulo,$descripcion,$servicio,$idPublicacion);
            
        }else{
            $resultadoEditar = editarPublicacion(0,$tipoPublicacion,0,$titulo,$descripcion,$servicio,$idPublicacion);
        }

        if($resultadoEditar === 1){
            $_SESSION['status'] = "Publicación actualizada con éxito.";
            header("Location: ../../presentacion/administrador/publicaciones/publicaciones.php?id=".$idAdmin."&idPublicacion=".$idPublicacion);
        }else{
            //Se manda el mensaje de error y se redirigirse a la página de registrar.
            $_SESSION['status'] = "Hubo un error al actualizar la publicación.";
            header("Location: ../../presentacion/administrador/publicaciones/editarPublicacion.php?id=".$idAdmin."&idPublicacion=".$idPublicacion);
        }
        
    }

?>