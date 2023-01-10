<?php
  require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionEvento/funcionesEvento.php';
  session_start();//Se inicia la sesión.

  $id                = htmlentities($_POST['idAdmin']);
  $evento            = html_entity_decode($_POST['nombreEvento'], ENT_QUOTES | ENT_HTML401, "UTF-8");
  $f_inicio          = $_POST['fechaInicio'];
  $f_fin             = $_POST['fechaFin']; 
  $h_inicio          = $_POST['horaInicio'];
  $h_fin             = $_POST['horaFin']; 
  $color_evento      = htmlentities($_POST['color']);
  $descripcion =  html_entity_decode($_POST['descripcionEvento'], ENT_QUOTES | ENT_HTML401, "UTF-8");

  $fechaI = "".$f_inicio." ".$h_inicio;
  $fechaF = "".$f_fin." ".$h_fin;

  $resultadoInsertar = agregarEvento($evento, $descripcion, $color_evento, $fechaI, $fechaF);

  if($resultadoInsertar === 1){
    $_SESSION['status'] = "Evento agregado con éxito.";
    header("Location: ../../presentacion/administrador/eventos/eventos.php?id=".$id);
  }else{
    //Se manda el mensaje de error y se redirigirse a la página de registrar.
    $_SESSION['status'] = "Hubo un error al registrar.";
    header("Location: ../../presentacion/administrador/eventos/eventos.php?id=".$id);
  }
?>