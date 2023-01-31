<?php
  //Archivos que se necesitan para la obtención de funciones y librerias
  require('../../fpdf/fpdf.php');
  require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
  require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/reportes/funcionesReportes.php';
  require $_SERVER['DOCUMENT_ROOT'].'/sistema web/logica/reportes/reportes.php';
  // Se establece la zona horaria predeterminada del script
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
      //Diseño de la hoja horizontal- Imagen 
      $this->Image('../../media/imagenes/plantillaHorizontal.png',-5,-1,300);
      //Logo de la unidad
      $this->Image('../../media/imagenes/logo2.png',20,15,25);
      //Posiciones XY para el texto
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
      $this->Cell(40, 10, 'REPORTE DE VISITAS GUIADAS'); //Título del reporte
      $this->Ln(20);
    }

    //Pie de página
    function Footer(){
      $this->SetFont('helvetica', 'B', 8); //Tipo y tamaño del texto
      $this->SetY(-15);
      $this->SetTextColor(255,255,255); //Color del texto
      $this->Cell(95,5,utf8_decode('Página ').$this->PageNo().' / {nb}',0,0,'L'); //No. de página
      $this->SetTextColor(0,91,1); //Color del texto
      $this->Cell(160,5,date('d/m/Y | g:i a') ,0,1,'R');  //Fecha y hora de generación del reporte
      $this->Line(10,287,200,287); //Linea
      $this->Cell(0,5,utf8_decode('Parque Estatal "El Texcal" © Todos los derechos reservados.'),0,0,"C");     
    }
  }

  //Creación del pdf en horizontal
  $pdf = new PDF('L','mm','letter',true);
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->SetAutoPageBreak(true, 50);
  //Margenes de la hoja
  $pdf->SetTopMargin(15); 
  $pdf->SetLeftMargin(10);
  $pdf->SetRightMargin(10);

  //Datos obtenidos del formulario por medio del metodo POST
  $grafico = $_POST['variableReporte'];  //Imagen de la gráfica
  $fechaInicio = $_POST['fechaInicio'];  //Fecha de inicio
  $fechaTermino = $_POST['fechaTermino']; //Fecha de término
  $idGuia = $_POST['idGuia']; //Id del guía
  $pdf->SetX(15);
  $pdf->SetTextColor(0,91,1); //Color del texto
  $pdf->SetFont('Arial','',15); //Tipo y tamaño del texto
  $pdf->Cell(0,0,utf8_decode('Gráfica del estado de las visitas guiadas'),0,0,''); //Título de la gráfica
  $img = explode(',',$grafico,2)[1]; //Se obtiene la imagen
  $pic = 'data://text/plain;base64,'. $img; //Se pasa a base64
  $pdf->image($pic, 20,90,200,0,'png'); //Se convierte en imagen y se le da un tamaño 
  $pdf->Ln(60); //Salto de línea
  $pdf->SetTextColor(0,0,0); //Color del texto
  $pdf->SetFont('Arial','',10); //Tipo y tamaño del texto

  //Se realiza el conteo de todas las visitas guiadas
  $resVisitas = contarTodasVisitas($fechaInicio, $fechaTermino, $idGuia);
  //Si no tienen ningún error entrará a esté if para mostrar los resultados
  if ($resVisitas){

    //Se muestra el total de visitas guiadas
    $pdf->SetX(15);
    $pdf->Cell(0,0,utf8_decode('El total de visitas guiadas son '.$resVisitas." en un periodo de ".$fechaInicio." a ".$fechaTermino."."),0,0,'');
      

    //Se realiza el conteo de las visitas guiadas pero ahora por estatus 
    $contarVisitas = contarVisitasXEstatus($idGuia, $fechaInicio, $fechaTermino);

    //Se muestra el conteo de cada estatus de acuerdo al array retornado por la función
    $pdf->Ln(10);//Salto de línea
    $pdf->Cell(60,0,utf8_decode('* Visitas pendientes:  '.$contarVisitas[0]),0,0,'C');
      
    $pdf->Ln(5);//Salto de línea
    $pdf->Cell(58,0,utf8_decode('* Visitas en espera:  '.$contarVisitas[1]),0,0,'C');
      
    $pdf->Ln(5);//Salto de línea
    $pdf->Cell(59,0,utf8_decode('* Visitas finalizadas:  '.$contarVisitas[2]),0,0,'C');
  }

  $pdf->Ln(100);//Salto de línea
  $pdf->SetX(15);
  $pdf->SetTextColor(0,91,1); //Color del texto
  $pdf->SetFont('Arial','',15); //Tipo y tamaño del texto
  $pdf->Cell(0,0,utf8_decode('Visitas guiadas finalizadas'),0,0,'');
  $pdf->Ln(10);//Salto de línea

  //Se da diseño a los registros de las visitas guiadas finalizadas en el rango de fechas que se obtuvieron
  $pdf->SetFillColor(52,151,4);
  $pdf->SetDrawColor(255, 255, 255);
  $pdf->SetX(15);
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(255, 255, 255);
  //Titulos de las columnas de la tabla
  $pdf->Cell(40, 12, utf8_decode('Fecha'),1,0,'C',1);
  $pdf->Cell(50, 12, utf8_decode('Estado'),1,0,'C',1);
  $pdf->Cell(80, 12, utf8_decode('Visitante'),1,0,'C',1);
  $pdf->Cell(80, 12, utf8_decode('Correo'),1,0,'C',1);

  $pdf->SetY(105);

  $pdf->SetTextColor(0,0,0);
  $pdf->SetFont('Arial','',8);
  //Se llama a la funión para obtener los registros que concidan con las visitas guiadas finalizadas pr el guía
  $resultado=mostrarVisitas($idGuia, $fechaInicio, $fechaTermino);

  //Se verifica que sino existe un error
  if ($resultado){
    //Se muestra la información de las visitas finalizadas
    while($filas=mysqli_fetch_row($resultado)){
      $pdf->SetX(15);
      $pdf->SetFillColor(255,255,255);
      $pdf->SetDrawColor(65, 61, 61);
      $pdf->Cell(40, 8, utf8_decode($filas[0]),'',0,'C'); //Fecha de la visita
      $pdf->Cell(50, 8, utf8_decode($filas[1]),'',0,'C'); //Estado de la visita
      $pdf->Cell(80, 8, utf8_decode($filas[2]." ".$filas[3]." ".$filas[4]),'',0,'C'); //Nombre del visitante
      $pdf->Cell(80, 8, utf8_decode($filas[5]),'',0,'C'); //Correo del visitante
      $pdf->Ln(10); //Salto de línea
    }
  }
  $pdf->Output(); //Salida del pdf
?>