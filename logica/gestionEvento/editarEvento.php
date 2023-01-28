<?php
    //Archivo que contiene las funciones de los eventos
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionEvento/funcionesEvento.php';

    session_start();//Se inicia la sesión.
    
    //Se obtienen y limpian todos los datos que se mandaron al formulario.
    $idAdmin           = htmlentities($_POST['idAdmin']);
    $idEvento          = htmlentities($_POST['idEvento']);
    $evento            = $_POST['nombreEventoM'];
    $f_inicio          = $_POST['fechaInicioM'];
    $f_fin             = $_POST['fechaFinM']; 
    $h_inicio          = $_POST['horaInicioM'];
    $h_fin             = $_POST['horaFinM']; 
    $color_evento      = htmlentities($_POST['colorM']);
    $descripcion       = html_entity_decode($_POST['descripcionEventoM'], ENT_QUOTES | ENT_HTML401, "UTF-8");

    //Se concatenan las fechas para ser enviadas de manera correcta a la base de datos
    $fechaI = "".$f_inicio." ".$h_inicio;
    $fechaF = "".$f_fin." ".$h_fin;

    //Se le envían los datos a la función para que se realice la actualización con los nuevos datos
    $resultadoEditar = editarEvento($evento, $descripcion, $color_evento, $fechaI, $fechaF,$idEvento);

    //Si el resultado es 1, la actualización se realizó correctamente. En cambio, si fue 0, hubo un error en la ejecución.
    if($resultadoEditar === 1){
        //Se manda el mensaje de éxito y se redirige a la página de eventos
        $_SESSION['status'] = "Evento actualizado con éxito.";
        header("Location: ../../presentacion/administrador/eventos/eventos.php?id=".$idAdmin);
    }else{
        //Se manda el mensaje de error y se redirigirse a la página de eventos.
        $_SESSION['status'] = "Hubo un error al registrar.";
        header("Location: ../../presentacion/administrador/eventos/eventos.php?id=".$idAdmin);
    }

?>