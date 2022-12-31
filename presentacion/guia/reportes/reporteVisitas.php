<?php
require('../../fpdf/fpdf.php');
require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/reportes/funcionesReportes.php';
require $_SERVER['DOCUMENT_ROOT'].'/sistema web/logica/reportes/reportes.php';

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
    $this->Cell(40, 10, 'REPORTE DE VISITAS GUIADAS');
    $this->Ln(20);
  }

  function Footer(){
      
    $this->SetFont('helvetica', 'B', 8);
    $this->SetY(-15);
    $this->SetTextColor(255,255,255);
    $this->Cell(95,5,utf8_decode('Página ').$this->PageNo().' / {nb}',0,0,'L');
    $this->SetTextColor(0,91,1);
    $this->Cell(160,5,date('d/m/Y | g:i a') ,0,1,'R');
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
$idGuia = $_POST['idGuia'];
$pdf->SetX(15);
$pdf->SetTextColor(0,91,1);
$pdf->SetFont('Arial','',15);
$pdf->Cell(0,0,utf8_decode('Gráfica del estado de las visitas guiadas'),0,0,'');

$img = explode(',',$grafico,2)[1];
$pic = 'data://text/plain;base64,'. $img;
$pdf->image($pic, 20,90,200,0,'png');
$pdf->Ln(60);


$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',10);

$resVisitas = contarTodasVisitas($fechaInicio, $fechaTermino, $idGuia);
   
if ($resVisitas){
    $pdf->SetX(15);
    $pdf->Cell(0,0,utf8_decode('El total de visitas guiadas son '.$resVisitas." en un periodo de ".$fechaInicio." a ".$fechaTermino."."),0,0,'');
    
    $contarVisitas = contarVisitasXEstatus($idGuia, $fechaInicio, $fechaTermino);

   
    $pdf->Ln(10);
    $pdf->Cell(60,0,utf8_decode('* Visitas pendientes:  '.$contarVisitas[0]),0,0,'C');
    
 
    $pdf->Ln(5);
    $pdf->Cell(58,0,utf8_decode('* Visitas en espera:  '.$contarVisitas[1]),0,0,'C');
    
    $pdf->Ln(5);
    $pdf->Cell(59,0,utf8_decode('* Visitas finalizadas:  '.$contarVisitas[2]),0,0,'C');

}
$pdf->Ln(100);
$pdf->SetX(15);
$pdf->SetTextColor(0,91,1);
$pdf->SetFont('Arial','',15);
$pdf->Cell(0,0,utf8_decode('Visitas guiadas finalizadas'),0,0,'');
$pdf->Ln(10);

$pdf->SetFillColor(52,151,4);
$pdf->SetDrawColor(255, 255, 255);
$pdf->SetX(15);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(255, 255, 255);

$pdf->Cell(40, 12, utf8_decode('Fecha'),1,0,'C',1);
$pdf->Cell(50, 12, utf8_decode('Estado'),1,0,'C',1);
$pdf->Cell(80, 12, utf8_decode('Visitante'),1,0,'C',1);
$pdf->Cell(80, 12, utf8_decode('Correo'),1,0,'C',1);

$pdf->SetY(105);

$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',8);
$resultado=mostrarVisitas($idGuia, $fechaInicio, $fechaTermino);
if ($resultado){
    while($filas=mysqli_fetch_row($resultado)){
        $pdf->SetX(15);
        $pdf->SetFillColor(255,255,255);
        $pdf->SetDrawColor(65, 61, 61);
        $pdf->Cell(40, 8, utf8_decode($filas[0]),'',0,'C');
        $pdf->Cell(50, 8, utf8_decode($filas[1]),'',0,'C');
        $pdf->Cell(80, 8, utf8_decode($filas[2]." ".$filas[3]." ".$filas[4]),'',0,'C');
        $pdf->Cell(80, 8, utf8_decode($filas[5]),'',0,'C');

        $pdf->Ln(10);
    }
}
$pdf->Output();
?>