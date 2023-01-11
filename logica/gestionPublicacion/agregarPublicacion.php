<?php 
    //Insertamos código de otro archivo el cual contiene la conexión de la BD.
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionPublicacion/funcionesPublicacion.php';
    session_start();//Se inicia la sesión.

    //Se obtienen y se limpian todos los datos que se mandaron al formulario.
    $idUsuario = htmlentities($_POST['id']);
    $servicio = htmlentities($_POST['servicio']);
    $titulo = html_entity_decode($_POST['titulo'], ENT_QUOTES | ENT_HTML401, "UTF-8"); 
    $descripcion = html_entity_decode($_POST['publicacion'], ENT_QUOTES | ENT_HTML401, "UTF-8"); 
    $tipoPublicacion = htmlentities($_POST['tipoPublicacion']);

    //Se verifica que el textarea de la descripción no este vacío, en caso de ser así se notifica al usuario
    if(empty($descripcion)){
        //Se crea la variable de sesion con el mensaje
        $_SESSION['status'] = "Debe agregar una descripción a la publicación.";
        //Se redirige a la pagína de agregar publicación
        header("Location: ../../presentacion/administrador/publicaciones/agregarPublicacion.php?id=".$idUsuario);
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
            $cantidad_url_video 	= strlen($urlVideo);

            //Dependiendo de la longitud se realizará una acortación del url que nos permitirá posteriormente ver el video
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
                //En caso de que la longitud no sea como los casos anteriores, se cambia de nuevo la bandera a 0
                $bandera = 0;
                //Se crea la variable de sesión con el mensaje de url inválida
                $_SESSION['status'] = "Url inválida.";
                //y se redirige a la página de agregar publicación para mostrar el mensaje
                header("Location: ../../presentacion/administrador/publicaciones/agregarPublicacion.php?id=".$idUsuario);
            }
        }else{

            //Si el tipo de publicacón es una imagen, de la imagen obtenida se verifica el tipo de imagen
            $tipo = $_FILES['imagen']['type'];
    
            //Las imágenes que estan permitidas para almacenarlas son jpeg, jpg y png
            if (!(strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png"))) {
                //Si se incumple la condición se manda un mensaje con la variable de sesión
                $_SESSION['status'] = "La imagen debe ser de tipo jpeg, jpg o png.";
                //y se redirige a la página de agregar publicación para mostrar el mensaje
                header("Location: ../../presentacion/administrador/publicaciones/agregarPublicacion.php?id=".$idUsuario);
            }else{
                //Si cumple con el tipo de imagen, el valor de la bandera cambia a 1
                $bandera = 1;
                //Se obtiene el nombre de la imagen
                $nombreImg = $_FILES['imagen']['name'];
                //Se obtiene el nombre temporal de la imagen
                $imagen = $_FILES['imagen']['tmp_name'];
                //Se crea la variable ruta que almacena la ublicación de la carpeta junto a el nombre de la imagen
                $ruta = 'imagenesTemp/'.$nombreImg;
                //Posteriormente, la imagen es movida a la carpeta 
                move_uploaded_file($imagen, "../../presentacion/".$ruta);
            }    
        }

        //Aquí verificamos el valor de la bandera, si esta es igual a 1 procederá a realizar la inserción de la publicación
        if($bandera === 1){

            //Se llama a la función para agregar la publicación con los datos obtenido
            $resultadoAgregar = agregarPublicacion($tipoPublicacion,$ruta,$titulo,$descripcion,$servicio);

            //si el resultado es igual a 1, ha sido una ejecución exitosa
            if($resultadoAgregar === 1){
                //Se manda un mensaje con la variable de sesión
                $_SESSION['status'] = "Publicacion agregada con éxito.";
                //y se redirige a la página de agregar publicación para mostrar el mensaje
                header("Location: ../../presentacion/administrador/publicaciones/agregarPublicacion.php?id=".$idUsuario);
            }else{
                //Caso contrario, hubo un error en la ejecución
                //Se manda el mensaje de error y se redirigirse a la página de agregar publicación.
                $_SESSION['status'] = "Hubo un error al agregar la publicación.";
                header("Location: ../../presentacion/administrador/publicaciones/agregarPublicacion.php?id=".$idUsuario);
            }
        }
        
    }
?>