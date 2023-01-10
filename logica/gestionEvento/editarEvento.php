<?php
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionEvento/funcionesEvento.php';

    session_start();//Se inicia la sesión.
    
    $idAdmin           = htmlentities($_POST['idAdmin']);
    $idEvento          = htmlentities($_POST['idEvento']);
    $evento            = $_POST['nombreEventoM'];
    $f_inicio          = $_POST['fechaInicioM'];
    $f_fin             = $_POST['fechaFinM']; 
    $h_inicio          = $_POST['horaInicioM'];
    $h_fin             = $_POST['horaFinM']; 
    $color_evento      = htmlentities($_POST['colorM']);
    $descripcion       = html_entity_decode($_POST['descripcionEventoM'], ENT_QUOTES | ENT_HTML401, "UTF-8");


    $fechaI = "".$f_inicio." ".$h_inicio;
    $fechaF = "".$f_fin." ".$h_fin;

    $resultadoEditar = editarEvento($evento, $descripcion, $color_evento, $fechaI, $fechaF,$idEvento);

    if($resultadoEditar === 1){
        $_SESSION['status'] = "Evento actualizado con éxito.";
        header("Location: ../../presentacion/administrador/eventos/eventos.php?id=".$idAdmin);
    }else{
        //Se manda el mensaje de error y se redirigirse a la página de registrar.
        $_SESSION['status'] = "Hubo un error al registrar.";
        header("Location: ../../presentacion/administrador/eventos/eventos.php?id=".$idAdmin);
    }

?>