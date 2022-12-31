<?php 
    //Insertamos código de otro archivo el cual contiene la conexión de la BD.
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionPublicacion/funcionesPublicacion.php';
    session_start();//Se inicia la sesión.
    //Se obtienen todos los datos que se mandaron al formulario.
    $idUsuario = htmlentities($_POST['id']);
    $servicio = htmlentities($_POST['servicio']);
    $titulo = htmlentities($_POST['titulo']);
    $descripcion = htmlentities($_POST['publicacion']);
    $tipoPublicacion = htmlentities($_POST['tipoPublicacion']);

    if(empty($descripcion)){
        $_SESSION['status'] = "Debe agregar una descripción a la publicación.";
        header("Location: ../../presentacion/administrador/publicaciones/agregarPublicacion.php?id=".$idUsuario);
        exit();
    }else{
        $bandera = 0;
        if($tipoPublicacion === "Video"){
            $urlVideo = $_POST['video'];
            $bandera = 1;
            $cantidad_url_video 	= strlen($urlVideo);
            if ($cantidad_url_video == '28') {

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
                header("Location: ../../presentacion/administrador/publicaciones/agregarPublicacion.php?id=".$idUsuario);
            }

        }else{
            $tipo = $_FILES['imagen']['type'];
    
            if (!(strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png"))) {
                $_SESSION['status'] = "La imagen debe ser de tipo jpeg, jpg o png.";
                header("Location: ../../presentacion/administrador/publicaciones/agregarPublicacion.php?id=".$idUsuario);
            }else{
                $bandera = 1;
                $nombreImg = $_FILES['imagen']['name'];
                $imagen = $_FILES['imagen']['tmp_name'];
                $ruta = 'imagenesTemp/'.$nombreImg;
                move_uploaded_file($imagen, "../../presentacion/".$ruta);
            }    
        }

        if($bandera === 1){
            $resultadoAgregar = agregarPublicacion($tipoPublicacion,$ruta,$titulo,$descripcion,$servicio);
            if($resultadoAgregar === 1){
                $_SESSION['status'] = "Publicacion agregada con éxito.";
                header("Location: ../../presentacion/administrador/publicaciones/agregarPublicacion.php?id=".$idUsuario);
            }else{
                //Se manda el mensaje de error y se redirigirse a la página de registrar.
                $_SESSION['status'] = "Hubo un error al agregar la publicación.";
                header("Location: ../../presentacion/administrador/publicaciones/agregarPublicacion.php?id=".$idUsuario);
            }
        }
        
    }
?>