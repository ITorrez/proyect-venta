<?php
error_reporting(E_ERROR);
session_start();
$idproforma=$_GET["cod"];

require_once('tcpdf_include.php');

include_once('../../../modelos/proforma.modelo.php');
include_once('../../../modelos/itemProforma.modelo.php');
class PDF extends TCPDF
{
   //Cabecera de página
   function Header()
   {
    $idproforma=$_GET["cod"];
      //$this->Image('images/logo-sonido2.png',5,3, 70, 20, '', '', '', false, 300, '', false, false, 0, false,false,false);

     // $this->SetFont('','B',12);
     $this->Ln(5);
     $mascaracod="";
     $cant=strlen($idproforma); 
     switch ($cant) {
      case 1:$mascaracod="000000".$idproforma;
        break;
      case 2:$mascaracod="00000".$idproforma;
        break;
      case 3:$mascaracod="0000".$idproforma;
        break;
      case 4:$mascaracod="000".$idproforma;
        break;
      case 5:$mascaracod="00".$idproforma;
        break;
      case 6:$mascaracod="0".$idproforma;
        break;
      case 7:$mascaracod=$idproforma;
        break;
      
      default:
        # code...
        break;
     }
     $this->SetTextColor(250, 48, 54);
      $this->Cell(30,10,$mascaracod,1,0,'C');
    
   }

   function Footer()
   {


    
	$this->SetY(-10);

	$this->SetFont('','I',8);
   // $this->Image('images/footer3.png',120,200,'', 10, '', '', '', false, 300, '', false, false, 0, false,false,false);
	//$this->Cell(0,10,'Dir. Calle Arenales entre Avaroa y Antofagasta ',0,0,'C', 0, '',0);
  //$this->Cell(0,10,'Teléfono. 73627166 ',0,0,'C');
  $this->Cell(0,0, 'Dir. Calle Arenales entre Avaroa y Antofagasta', 0, 6, 'C', 0, '', 0);
  $this->Cell(0,0, 'Teléfono. 73627166', 0, 6, 'C', 0, '', 0);
   }
}




$pdf = new PDF('H', 'mm', 'A4', true, 'UTF-8', false);/*PARA HOJA TAMAÑO LEGAL SE PONE LEGAL EN MAYUSCULA*/


$pdf->startPageGroup();
$pdf->AddPage();
$pdf->SetFont('','',10);
#Establecemos los márgenes izquierda, arriba y derecha:
$pdf->SetMargins(3, 30 ,2.5);
#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,10);


 


/*===============================================================
TAMAÑO TOTAL DE LA HOJA OFICIO ECHADA(ORIZONTAL)=905px DISPONIBLE PARA OCUPAR CON DATOS, RESPETANDO LOSMARGENES ESTABLECIDOS POR CODIGO EN LA FUNCION ->SetMargins(34, 30 ,2.5)
/*===============================================================*/

$obj2=new Proforma();
$resultado2=$obj2->MostrarProformaActivos($idproforma);
$fila1=mysqli_fetch_object($resultado2);

 $cliente=$fila1->cliente_proforma;
 $montotalproforma=$fila1->total_costo;

$fechaventa=$fila1->fecha_proceso;
$fechaComoEntero = strtotime($fechaventa);
        
$pdf->Ln(2);

$pdf->SetFont('','',8);

#Establecemos el margen inferior:

$pdf->SetMargins(150, 30 ,2.5);
$anio = date("Y", $fechaComoEntero);
         $mes = date("m", $fechaComoEntero);
         $dia = date("d", $fechaComoEntero);
$pdf->Ln(1);
#Establecemos los márgenes izquierda, arriba y derecha:
$bloqueFecha=<<<EOF

<table  style="width: 150px; " border="0.1px" >
  <thead>
     <tr style="background-color:#e8e8e8;">
                  <th style="text-align:center; ">Lugar</th>
                  <th style="text-align:center; ">Dia</th>
                  <th style="text-align:center; ">Mes</th>  
                  <th style="text-align:center; ">Año</th>               
    </tr>
  </thead>
  <tbody>
    <tr >
      <th style="text-align:center; ">Montero</th>
      <th style="text-align:center; ">$dia</th>
      <th style="text-align:center; ">$mes</th>  
      <th style="text-align:center; ">$anio</th>               
    </tr>
  </tbody>
</table>
EOF;
$pdf->writeHTML($bloqueFecha,false,false,false,false,'');

#Establecemos los márgenes izquierda, arriba y derecha:
$pdf->SetMargins(75, 30 ,2.5);
$bloqueFecha=<<<EOF
<div  style="width: 150px; "  >
   <img src="images/logo-sonido2.png" style="width: 180px;height:80px; ">
</div>
EOF;
$pdf->writeHTML($bloqueFecha,false,false,false,false,'');
$pdf->SetMargins(3, 30 ,2.5);
$pdf->Ln(2);
$pdf->SetFont('','B',12);
$pdf->Cell(0,0, 'PROFORMA', 0, 6, 'C', 0, '', 1);
$pdf->Ln(2);
$pdf->SetFont('','',10);
$pdf->Cell(0,0, 'Señor(es): '.$cliente, 0, 6, 'L', 0, '', 1);
$pdf->Ln(2);

$bloqueCabeceraDetalle=<<<EOF
<table border="0.1px">
  <thead>
     <tr id="fila1" style="background-color:#e8e8e8;">
                  <th style="text-align:center;width: 10%; ">CANTIDAD</th>
                  <th style="text-align:center;width: 70%; ">DETALLE</th>
                  <th style="text-align:center;width: 10%; ">P/U</th>
                  <th style="text-align:center;width: 10%; ">SUB TOTAL</th>                         
    </tr>
  </thead>
</table>
EOF;
$pdf->writeHTML($bloqueCabeceraDetalle,false,false,false,false,'');

               
                $contador=1;
               $totalVenta=0;
                $obj=new Item_Proforma();
                $resultado=$obj->listarItemProformasActivosDeProforma($idproforma);
                while ($fila=mysqli_fetch_object($resultado)) 
                {            
                    $bloqueDatosDetalle=<<<EOF
                                  <table border="0.1px">
                                  <thead>
                                  <tr style="page-break-inside: avoid; " nobr="true">
                                     <th style="text-align:center; width: 10%;">$fila->cantidad</th>
                                     <th style="text-align:left; width: 70%;">$fila->producto</th>
                                     <th style="text-align:center; width: 10%;">$fila->costo_unitario</th>
                                     <th style="text-align:center;width: 10%; ">$fila->subtotal</th>                                
                                  </tr>
                                  </thead>
                                  </table>
                                  EOF;
                     $pdf->writeHTML($bloqueDatosDetalle,false,false,false,false,'');
                     $pdf->SetMargins(34, 30 ,2.5);

                 }
                 /***************************TABLA TOTAL EGRESOS DE LAS ORDENES*************/
                 // $totalventasDecimal=number_format((float)$totalMontoVentas, 2, '.', '');
$bloqueTotal=<<<EOF
<table border="0.1px" cellpadding="1" >
<tr style="page-break-inside: avoid;" nobr="true">
   <td style="text-align:center; width:90%;">TOTAL</td>
   <td style="text-align:center; width:10%;">$montotalproforma</td>
</tr>
</table>
EOF;

$pdf->writeHTML($bloqueTotal,false,false,false,false,'');


$nameFile='proforma_'.$idproforma.'.pdf';
ob_end_clean(); //LIMPIA ESPACIOS EN BLANCO PARA NO GENERAR ERROREA
$pdf->Output($nameFile);

?>