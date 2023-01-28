<?php
  //Archivo que contiene las funciones de los eventos
  require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionEvento/funcionesEvento.php';

  session_start();//Se inicia la sesión.

  //Se obtienen y limpian todos los datos que se mandaron al formulario.
  $id                = htmlentities($_POST['idAdmin']);
  $evento            = html_entity_decode($_POST['nombreEvento'], ENT_QUOTES | ENT_HTML401, "UTF-8");
  $f_inicio          = $_POST['fechaInicio'];
  $f_fin             = $_POST['fechaFin']; 
  $h_inicio          = $_POST['horaInicio'];
  $h_fin             = $_POST['horaFin']; 
  $color_evento      = htmlentities($_POST['color']);
  $descripcion =  html_entity_decode($_POST['descripcionEvento'], ENT_QUOTES | ENT_HTML401, "UTF-8");

  //Se concatenan las fechas para ser enviadas de manera correcta a la base de datos
  $fechaI = "".$f_inicio." ".$h_inicio;
  $fechaF = "".$f_fin." ".$h_fin;

  //Se le envían los datos a la función para que se realice la inserción
  $resultadoInsertar = agregarEvento($evento, $descripcion, $color_evento, $fechaI, $fechaF);

  //Si el resultado es 1, la inserción se realizó correctamente. En cambio, si fue 0, hubo un error en la ejecución.
  if($resultadoInsertar === 1){
    //Se manda el mensaje de éxito y se redirige a la página de eventos
    $_SESSION['status'] = "Evento agregado con éxito.";
    header("Location: ../../presentacion/administrador/eventos/eventos.php?id=".$id);
  }else{
    //Se manda el mensaje de error y se redirigirse a la página de everntos.
    $_SESSION['status'] = "Hubo un error al registrar.";
    header("Location: ../../presentacion/administrador/eventos/eventos.php?id=".$id);
  }
?>