<?php
  //Archivos que se necesitan para la obtención de funciones y librerias
  require('../../fpdf/fpdf.php');
  require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
  require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/reportes/funcionesReportes.php';
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
      //Diseño de la hoja vertical- Imagen 
      $this->Image('../../media/imagenes/plantilla.png',-5,-1,250);
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
      $this->Cell(40, 10, 'REPORTE DE COMENTARIOS'); //Título del reporte
      $this->Ln(20);//Salto de línea
    }
    //Pie de página
    function Footer(){
      $this->SetFont('helvetica', 'B', 8); //Tipo y tamaño del texto
      $this->SetY(-15);
      $this->Cell(95,5,utf8_decode('Página ').$this->PageNo().' / {nb}',0,0,'L'); //No. de página
      $this->Cell(95,5,date('d/m/Y | g:i a') ,00,1,'R');  //Fecha y hora de generación del reporte
      $this->Line(10,287,200,287);
      $this->Cell(0,5,utf8_decode('Parque Estatal "El Texcal" © Todos los derechos reservados.'),0,0,"C");     
    }
  }


  //Creación del pdf
  $pdf = new PDF();
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->SetAutoPageBreak(true, 40);
  //Margenes de la hoja
  $pdf->SetTopMargin(15);
  $pdf->SetLeftMargin(10);
  $pdf->SetRightMargin(10);

  //Datos obtenidos del formulario por medio del metodo POST
  $grafico=$_POST['variableReporte']; //Imagen de la gráfica
  $idAdmin = $_POST['idAdmin']; //Id del administrador
  $seccion = $_POST['seccion']; //Sección a la que se aplican los filtros
  $servicio = $_POST['servicio']; //Servicio seleccionado
  $filtro = $_POST['filtro']; //Filtro de búsqueda de los comentarios

  $pdf->SetX(15);
  $pdf->SetTextColor(0,91,1);  //Color del texto
  $pdf->SetFont('Arial','',15); //Tipo y tamaño del texto
  $pdf->Cell(0,0,utf8_decode('Gráfica de comentarios'),0,0,'');
  $img = explode(',',$grafico,2)[1]; //Se obtiene la imagen
  $pic = 'data://text/plain;base64,'. $img; //Se pasa a base64
  $pdf->image($pic, 10,90,200,0,'png'); //Se convierte en imagen y se le da un tamaño 
  $pdf->Ln(60);//Salto de línea

  $pdf->SetX(15);
  $pdf->SetTextColor(0,91,1); //Color del texto
  $pdf->SetFont('Arial','',15); //Tipo y tamaño del texto
  $pdf->Cell(0,0,utf8_decode('Comentarios'),0,0,'');
  $pdf->Ln(10);//Salto de línea

  //Se da diseño a los registros de los comentarios
  $pdf->SetFillColor(52,151,4);
  $pdf->SetDrawColor(255, 255, 255);
  $pdf->SetX(15);
  $pdf->SetFont('Arial','B',10); //Tipo y tamaño del texto
  $pdf->SetTextColor(255, 255, 255); //Color del texto
  //Titulos de las columnas de la tabla
  $pdf->Cell(40, 12, utf8_decode('Servicio'),1,0,'C',1);
  $pdf->Cell(40, 12, utf8_decode('Calificación'),1,0,'C',1);
  $pdf->Cell(100, 12, utf8_decode('Comentario'),1,0,'C',1);
  $pdf->SetY(165);

  $pdf->SetTextColor(0,0,0); //Color del texto
  $pdf->SetFont('Arial','',10);

  //Se llama a la función para mostrara los comentarios de acuerdo al filtro que será aplicado
  $resultado = mostrarComentarios($servicio, $filtro);
  //Se verifica que no exista un error en el resultado
  if ($resultado){
    //Se muestran los resultados
    while($filas=mysqli_fetch_row($resultado)){
      $pdf->SetX(15);
      $pdf->SetFillColor(255,255,255);
      $pdf->SetDrawColor(65, 61, 61);
      $pdf->Cell(40, 8, utf8_decode($filas[0]),'',0,'C',1); //Servicio
      $pdf->Cell(40, 8, utf8_decode($filas[2]." Estrella(s)"),'',0,'C',1); //Calificación
      $pdf->MultiAlignCell(100, 8, utf8_decode($filas[1]),'',0,'',1); //Comentatio
      $pdf->Ln(15);//Salto de línea
    }
  }
  $pdf->Output(); 
?>