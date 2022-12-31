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
    $this->Image('../../media/imagenes/plantilla.png',-5,-1,250);
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
    $this->Cell(40, 10, 'REPORTE DE COMENTARIOS');
    $this->Ln(20);
  }

  function Footer(){
      
    $this->SetFont('helvetica', 'B', 8);
    $this->SetY(-15);
    $this->Cell(95,5,utf8_decode('Página ').$this->PageNo().' / {nb}',0,0,'L');
    $this->Cell(95,5,date('d/m/Y | g:i a') ,00,1,'R');
    $this->Line(10,287,200,287);
    $this->Cell(0,5,utf8_decode('Parque Estatal "El Texcal" © Todos los derechos reservados.'),0,0,"C");     
  }
}



$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 40);
$pdf->SetTopMargin(15);
$pdf->SetLeftMargin(10);
$pdf->SetRightMargin(10);

//Datos obtenidos del formulario por medio del metodo POST
$grafico=$_POST['variableReporte'];
$idAdmin = $_POST['idAdmin'];
$seccion = $_POST['seccion'];
$servicio = $_POST['servicio'];
$filtro = $_POST['filtro'];

$pdf->SetX(15);
$pdf->SetTextColor(0,91,1);
$pdf->SetFont('Arial','',15);
$pdf->Cell(0,0,utf8_decode('Gráfica de comentarios'),0,0,'');

$img = explode(',',$grafico,2)[1];
$pic = 'data://text/plain;base64,'. $img;
$pdf->image($pic, 10,90,200,0,'png');
$pdf->Ln(60);

$pdf->SetX(15);
$pdf->SetTextColor(0,91,1);
$pdf->SetFont('Arial','',15);
$pdf->Cell(0,0,utf8_decode('Comentarios'),0,0,'');
$pdf->Ln(10);


$pdf->SetFillColor(52,151,4);
$pdf->SetDrawColor(255, 255, 255);
$pdf->SetX(15);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(40, 12, utf8_decode('Servicio'),1,0,'C',1);
$pdf->Cell(40, 12, utf8_decode('Calificación'),1,0,'C',1);
$pdf->Cell(100, 12, utf8_decode('Comentario'),1,0,'C',1);
$pdf->SetY(165);

$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',10);
$resultado=mostrarComentarios($servicio, $filtro);
if ($resultado){
  while($filas=mysqli_fetch_row($resultado)){
    $pdf->SetX(15);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetDrawColor(65, 61, 61);
    $pdf->Cell(40, 8, utf8_decode($filas[0]),'',0,'C',1);
    $pdf->Cell(40, 8, utf8_decode($filas[2]." Estrella(s)"),'',0,'C',1);
    $pdf->MultiAlignCell(100, 8, utf8_decode($filas[1]),'',0,'',1);
    $pdf->Ln(15);
  }
}
// for ($i = 0; $i <40 ; $i++) {
//   $pdf->SetX(15);
//   $pdf->SetFillColor(255,255,255);
//   $pdf->SetDrawColor(65, 61, 61);
//   $pdf->Cell(40, 8, utf8_decode('$20.50'),'B',0,'C',1);
//   $pdf->Cell(40, 8, utf8_decode('4'),'B',0,'C',1);
//   $pdf->Cell(100, 8, utf8_decode('$82.00'),'B',1,'C',1);
//   $pdf->Ln(0.5);
// }

$pdf->Output();
?>