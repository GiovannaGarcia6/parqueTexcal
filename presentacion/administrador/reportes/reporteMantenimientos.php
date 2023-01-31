<?php
  require('../../fpdf/fpdf.php');
  require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
  require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/reportes/funcionesReportes.php';

  date_default_timezone_set('Mexico/General');
  class PDF extends FPDF {
    /* 
      ---------------------------------------------------------------------
      Funcionamiento de algunas funciones de FPDF utilizados para el reporte
      ---------------------------------------------------------------------
      SetTextColor(255,255,255) - es en RGB
      SetFillColor()
      SetDrawColor()
      Line(derecha-izquierda, arriba-abajo,ancho,arriba-abajo)
      Color line setDrawColor(61,174,233)
      GetX() || GetY() posiciones en cm
      Grosor - SetLineWidth(1)
      SetFont(tipo{COURIER, HELVETICA,ARIAL,TIMES,SYMBOL, ZAPDINGBATS}, estilo[normal,B,I ,A], tamaño)
      Cell(ancho , alto,texto,borde,salto(0/1),alineacion,rellenar, link)
      AddPage(orientacion[PORTRAIT, LANDSCAPE], tamño[A3.A4.A5.LETTER,LEGAL],rotacion)
      Image(ruta, poscisionx,pocisiony,alto,ancho,tipo,link)
      SetMargins(10,30,20,20) luego de addpage
    */
      
    // Cabecera de página
    function Header(){
      $this->Image('../../media/imagenes/plantillaHorizontal.png',-5,-1,300);
      $this->Image('../../media/imagenes/logo2.png',20,15,25);
      
      $this->SetY(40);
      $this->SetX(15);
      $this->SetFont('Arial','B',12); //Tipo y tamaño del texto
      $this->SetTextColor(30,10,32); //Color del texto
      $this->Cell(89, 10, 'Parque estatal "El Texcal"',0,1); //Nombre del parque
      $this->SetY(45);
      $this->SetX(15);
      $this->SetFont('Arial','',8); //Tipo y tamaño del texto
      $this->Cell(40, 10, 'Bienes Comunales del pueblo de Tejalpa'); //Nombre de la unidad
      $this->SetY(60);
      $this->SetX(15);
      $this->SetTextColor(0,91,1); //Color del texto
      $this->SetFont('Arial','B',20); //Tipo y tamaño del texto
      $this->Cell(40, 10, 'REPORTE DE MANTENIMIENTOS'); //Título del reporte
      $this->Ln(20);//Salto de línea
    }
    //Pie de página
    function Footer(){
      $this->SetFont('helvetica', 'B', 8); //Tipo y tamaño del texto
      $this->SetY(-15);
      $this->SetTextColor(255,255,255); //Color del texto
      $this->Cell(95,5,utf8_decode('Página ').$this->PageNo().' / {nb}',0,0,'L');  //No. de página
      $this->SetTextColor(0,91,1);
      $this->Cell(160,5,date('d/m/Y | g:i a') ,00,1,'R'); //Fecha y hora de generación del reporte
      $this->Line(10,287,200,287);
      $this->Cell(0,5,utf8_decode('Parque Estatal "El Texcal" © Todos los derechos reservados.'),0,0,"C");     
    }
  }


  //Creación del pdf
  $pdf = new PDF('L','mm','letter',true);
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->SetAutoPageBreak(true, 50);
  //Margenes de la hoja
  $pdf->SetTopMargin(15);
  $pdf->SetLeftMargin(10);
  $pdf->SetRightMargin(10);

  //Datos obtenidos del formulario por medio del metodo POST
  $grafico=$_POST['variableReporte']; //Imagen de la gráfica
  $fechaInicio = $_POST['fechaInicio']; //Fecha de inicio de las tareas de mantenimiento
  $fechaTermino = $_POST['fechaTermino']; //Fecha de término de las tareas de mantenimiento

  $pdf->SetX(15);
  $pdf->SetTextColor(0,91,1); //Color del texto
  $pdf->SetFont('Arial','',15); //Tipo y tamaño del texto
  $pdf->Cell(0,0,utf8_decode('Gráfica del estado de las tareas de mantenimiento'),0,0,''); //Título de la gráfica
  $img = explode(',',$grafico,2)[1]; //Se obtiene la imagen
  $pic = 'data://text/plain;base64,'. $img; //Se pasa a base64
  $pdf->image($pic, 20,90,200,0,'png'); //Se convierte en imagen y se le da un tamaño 
  $pdf->Ln(100);

  $pdf->SetX(15);
  $pdf->SetTextColor(0,91,1); //Color del texto
  $pdf->SetFont('Arial','',15); //Tipo y tamaño del texto
  $pdf->Cell(0,0,utf8_decode('Actividades'),0,0,'');
  $pdf->Ln(10);//Salto de línea

  //Se da diseño a los registros de las tares de mantenimiento en el rango de fechas que se obtuvieron
  $pdf->SetFillColor(52,151,4);
  $pdf->SetDrawColor(255, 255, 255);
  $pdf->SetX(15);
  $pdf->SetFont('Arial','B',10); //Tipo y tamaño del texto
  $pdf->SetTextColor(255, 255, 255); //Color del texto
  //Titulos de las columnas de la tabla
  $pdf->Cell(40, 12, utf8_decode('Mantenimiento'),1,0,'C',1);
  $pdf->Cell(40, 12, utf8_decode('Actividad'),1,0,'C',1);
  $pdf->Cell(50, 12, utf8_decode('Descripción'),1,0,'C',1);
  $pdf->Cell(40, 12, utf8_decode('Estatus'),1,0,'C',1);
  $pdf->Cell(40, 12, utf8_decode('Inicio'),1,0,'C',1);
  $pdf->Cell(40, 12, utf8_decode('Termino'),1,0,'C',1);

  $pdf->SetY(105);
  $pdf->SetTextColor(0,0,0); //Color del texto
  $pdf->SetFont('Arial','',8); //Tipo y tamaño del texto

  //Se realiza la consulta de los mantenimentos concluidos en ese rango de fechas
  $resultado = mostrarMantenimientos($fechaInicio, $fechaTermino);

  //Si el resultado no tiene ningún error se realiza un ciclo para mostrar los datos de las tareas de mantenimiento
  if($resultado){
    while($filas=mysqli_fetch_row($resultado)){
      $pdf->SetX(15);
      $pdf->SetFillColor(255,255,255);
      $pdf->SetDrawColor(65, 61, 61);
      $pdf->MultiAlignCell( 40, 7, utf8_decode($filas[0]),0); //Titulo del mantenimiento 
      $pdf->MultiAlignCell( 40, 7, utf8_decode($filas[1]),0); //Título de la tarea
      $pdf->MultiAlignCell( 50, 7, utf8_decode($filas[2]), 0); //Descripción de la tarea
      $pdf->MultiAlignCell( 40, 7, utf8_decode($filas[3]), '',0,'C'); //Estatus de la tarea
      $pdf->MultiAlignCell( 40, 7, utf8_decode($filas[4]),'',0,'C'); //Fecha de inicio de la tarea
      $pdf->MultiAlignCell( 40, 7, utf8_decode($filas[5]),'',0,'C'); //Fecha de término de la tarea
      $pdf->Ln(17.5); //Salto de línea
    }    
  }

  //Se llama a la función para obtener los datos del mejor empleado
  $resultadoMejorTrabajador = mejorEmpleado($fechaInicio, $fechaTermino);

  $pdf->SetX(15);
  $pdf->SetTextColor(0,91,1);
  $pdf->SetFont('Arial','',15); //Tipo y tamaño del texto
  $pdf->Cell(0,0,utf8_decode('Mejor empleado de mantenimiento'),0,0,'');
  $pdf->Ln(10);
  $pdf->SetX(15);
  $pdf->SetFont('Arial','',10); //Tipo y tamaño del texto
  $pdf->SetTextColor(0,0,0); //Color del texto

  //Se realiza el ciclo para mostrar los datos del mejor empleado
  while ($filas = mysqli_fetch_row($resultadoMejorTrabajador)){
    $contarTareas = $filas[4]; //Se obtiene el total de tareas finalizadas por el empleado

    //Si el total de tareas es igual a 0 es que no hay mejor empleado debido a que no tienen tareas finalizadas
    if($contarTareas==='0'){
      $pdf->Cell(0,0,utf8_decode('Por el momento no existe el mejor empleado, debido a que aún no finalizan las actividades.'),0,0,'');
    }else{
      //En cambio, si el total es mayor, se muestran los datos del trabajador con el total de tareas finalizadas
      $pdf->SetX(15);
      $pdf->SetFillColor(255,255,255);
      $pdf->SetDrawColor(65, 61, 61);
      $pdf->Cell(0, 0, utf8_decode("Nombre del empleado: ".$filas[0]." ".$filas[1]." ".$filas[2]),'',0,'L',1);
      $pdf->Ln(5);
      $pdf->SetX(15);
      $pdf->Cell(0, 0, utf8_decode("Correo electrónico: ".$filas[3]),'',0,'L',1);
      $pdf->Ln(5);
      $pdf->SetX(15);
      $pdf->Cell(0, 0, utf8_decode("Perido de consulta: ".$fechaInicio." a ".$fechaTermino),'',0,'L',1);
      $pdf->Ln(5);
      $pdf->SetX(15);
      $pdf->Cell(0, 0, utf8_decode("Total de tareas finalizadas en este periodo:".$filas[4]),'',1,'L',1);
      $pdf->Ln(5); //Salto de línea
    }    
  }
  $pdf->Output(); //Salida del pdf
?>