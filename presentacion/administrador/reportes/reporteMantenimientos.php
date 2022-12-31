<?php
require('../../fpdf/fpdf.php');
require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/reportes/funcionesReportes.php';

date_default_timezone_set('Mexico/General');
class PDF extends FPDF {
  // Cabecera de página
  //Numeros de paginas
  //SetTextColor(255,255,255);es RGB extraer colores con GIMP
  //SetFillColor()
  //SetDrawColor()
  //Line(derecha-izquierda, arriba-abajo,ancho,arriba-abajo)
  //Color line setDrawColor(61,174,233)
  //GetX() || GetY() posiciones en cm
  //Grosor SetLineWidth(1)
  // SetFont(tipo{COURIER, HELVETICA,ARIAL,TIMES,SYMBOL, ZAPDINGBATS}, estilo[normal,B,I ,A], tamaño)
  // Cell(ancho , alto,texto,borde,salto(0/1),alineacion,rellenar, link)
  //AddPage(orientacion[PORTRAIT, LANDSCAPE], tamño[A3.A4.A5.LETTER,LEGAL],rotacion)
  //Image(ruta, poscisionx,pocisiony,alto,ancho,tipo,link)
  //SetMargins(10,30,20,20) luego de addpage
    
  function Header(){
    $this->Image('../../media/imagenes/plantillaHorizontal.png',-5,-1,300);
    $this->Image('../../media/imagenes/logo2.png',20,15,25);
    
    $this->SetY(40);
    $this->SetX(15);
    $this->SetFont('Arial','B',12);
    
    $this->SetTextColor(30,10,32);
    $this->Cell(89, 10, 'Parque estatal "El Texcal"',0,1);
    $this->SetY(45);
    $this->SetX(15);
    $this->SetFont('Arial','',8);
    $this->Cell(40, 10, 'Bienes Comunales del pueblo de Tejalpa');
    $this->SetY(60);
    $this->SetX(15);
    $this->SetTextColor(0,91,1);
    $this->SetFont('Arial','B',20);
    $this->Cell(40, 10, 'REPORTE DE MANTENIMIENTOS');
    $this->Ln(20);
  }

  function Footer(){
      
    $this->SetFont('helvetica', 'B', 8);
    $this->SetY(-15);
    $this->SetTextColor(255,255,255);
    $this->Cell(95,5,utf8_decode('Página ').$this->PageNo().' / {nb}',0,0,'L');
    $this->SetTextColor(0,91,1);
    $this->Cell(160,5,date('d/m/Y | g:i a') ,00,1,'R');
    $this->Line(10,287,200,287);
    $this->Cell(0,5,utf8_decode('Parque Estatal "El Texcal" © Todos los derechos reservados.'),0,0,"C");     
  }
}



$pdf = new PDF('L','mm','letter',true);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 50);
$pdf->SetTopMargin(15);
$pdf->SetLeftMargin(10);
$pdf->SetRightMargin(10);

//Datos obtenidos del formulario por medio del metodo POST
$grafico=$_POST['variableReporte'];
$fechaInicio = $_POST['fechaInicio'];
$fechaTermino = $_POST['fechaTermino'];

$pdf->SetX(15);
$pdf->SetTextColor(0,91,1);
$pdf->SetFont('Arial','',15);
$pdf->Cell(0,0,utf8_decode('Gráfica del estado de las tareas de mantenimiento'),0,0,'');

$img = explode(',',$grafico,2)[1];
$pic = 'data://text/plain;base64,'. $img;
$pdf->image($pic, 20,90,200,0,'png');
$pdf->Ln(100);

$pdf->SetX(15);
$pdf->SetTextColor(0,91,1);
$pdf->SetFont('Arial','',15);
$pdf->Cell(0,0,utf8_decode('Actividades'),0,0,'');
$pdf->Ln(10);

$pdf->SetFillColor(52,151,4);
$pdf->SetDrawColor(255, 255, 255);
$pdf->SetX(15);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(255, 255, 255);

$pdf->Cell(40, 12, utf8_decode('Mantenimiento'),1,0,'C',1);
$pdf->Cell(40, 12, utf8_decode('Actividad'),1,0,'C',1);
$pdf->Cell(50, 12, utf8_decode('Descripción'),1,0,'C',1);
$pdf->Cell(40, 12, utf8_decode('Estatus'),1,0,'C',1);
$pdf->Cell(40, 12, utf8_decode('Inicio'),1,0,'C',1);
$pdf->Cell(40, 12, utf8_decode('Termino'),1,0,'C',1);

$pdf->SetY(105);

$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',8);
$resultado=mostrarMantenimientos($fechaInicio, $fechaTermino);
if ($resultado){
  while($filas=mysqli_fetch_row($resultado)){
    $pdf->SetX(15);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetDrawColor(65, 61, 61);
    
    $pdf->MultiAlignCell( 40, 7, utf8_decode($filas[0]),0);
    $pdf->MultiAlignCell( 40, 7, utf8_decode($filas[1]),0);
    $pdf->MultiAlignCell( 50, 7, utf8_decode($filas[2]), 0);
    $pdf->MultiAlignCell( 40, 7, utf8_decode($filas[3]), '',0,'C');
    $pdf->MultiAlignCell( 40, 7, utf8_decode($filas[4]),'',0,'C');
    $pdf->MultiAlignCell( 40, 7, utf8_decode($filas[5]),'',0,'C');

    $pdf->Ln(17.5); 
  }    
}

$resultadoMejorTrabajador = mejorEmpleado($fechaInicio, $fechaTermino);



$pdf->SetX(15);
$pdf->SetTextColor(0,91,1);
$pdf->SetFont('Arial','',15);
$pdf->Cell(0,0,utf8_decode('Mejor empleado de mantenimiento'),0,0,'');
$pdf->Ln(10);
$pdf->SetX(15);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);
while ($filas = mysqli_fetch_row($resultadoMejorTrabajador)){
  $contarTareas = $filas[4];
  if($contarTareas==='0'){
    $pdf->Cell(0,0,utf8_decode('Por el momento no existe el mejor empleado, debido a que aún no finalizan las actividades.'),0,0,'');
  }else{
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
    $pdf->Ln(5);    
  }    
}
$pdf->Output();
?>