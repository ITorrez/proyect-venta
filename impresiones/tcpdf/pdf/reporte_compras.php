<?php
error_reporting(E_ERROR);
session_start();
if ($_SESSION["usuarioAdmin"]!="") 
{
  $datosUsuario=$_SESSION["usuarioAdmin"];
  $_SESSION["nombuser"]=$datosUsuario["nombre_administrador"];
  $iduseractual=$datosUsuario["id_administrador"];
  $_SESSION["tipouser"]="admin";
}
if ($_SESSION["usuarioEmp"]!="") 
{
  $datosUsuario=$_SESSION["usuarioEmp"];
  $_SESSION["nombuser"]=$datosUsuario["nombre_empleado"];
  $iduseractual=$datosUsuario["id_empleado"];
  $_SESSION["tipouser"]="empl";
}

$fechaIni=$_SESSION["frchaini"];
$fechaFin=$_SESSION["fechafin"];
$idemp=$_SESSION["idemp"];
require_once('tcpdf_include.php');

include_once('../../../modelos/compra.modelo.php');
include_once('../../../modelos/empleado.modelo.php');
class PDF extends TCPDF
{
   //Cabecera de página
   function Header()
   { $nombreUser=$_SESSION["nombuser"];

       $this->Image('images/logo-sonido2.png',5,3, 70, 20, '', '', '', false, 300, '', false, false, 0, false,false,false);
     // $this->SetFont('','B',12);
     // $this->Cell(30,10,'Title',1,0,'C');
    $this->SetFont('','B',9);
      $this->Ln(3);
      ini_set('date.timezone','America/La_Paz');
         //$fecha=date("Y-m-d");
          $fecha=date("d-m-Y");
         $hora=date("H:i");
         $fechaHora=$fecha.' '.$hora;
        $this->Cell(100,5, '                                                                                                                                                                                                                                     '.$fechaHora, 0, 0, 'C', 0, '', 0);
        $this->Ln(3);
      $this->Cell(00,0, ' Usuario: '.$nombreUser, 0, 0, 'R', 0, '', 0);
    
   }

   function Footer()
   {


    
	$this->SetY(-1000);

	$this->SetFont('','I',8);
   // $this->Image('images/footer3.png',120,200,'', 10, '', '', '', false, 300, '', false, false, 0, false,false,false);
	$this->Cell(0,10,'Pagina '.$this->PageNo().'/'.$this->getAliasNbPages(),0,0,'R');
   }
}




$pdf = new PDF('H', 'mm', 'A4', true, 'UTF-8', false);/*PARA HOJA TAMAÑO LEGAL SE PONE LEGAL EN MAYUSCULA*/


$pdf->startPageGroup();
$pdf->AddPage();
$pdf->SetFont('','',10);
#Establecemos los márgenes izquierda, arriba y derecha:
$pdf->SetMargins(3, 30 ,5);
#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,10);


 


/*===============================================================
TAMAÑO TOTAL DE LA HOJA OFICIO ECHADA(ORIZONTAL)=905px DISPONIBLE PARA OCUPAR CON DATOS, RESPETANDO LOSMARGENES ESTABLECIDOS POR CODIGO EN LA FUNCION ->SetMargins(34, 30 ,2.5)
/*===============================================================*/
if ($idemp==0) 
{
  $nombreVendedor='Todos';
}
else
{
  
  $objemep=new Empleado();
 $resultEmp=$objemep->mostarUnEmpleadosActivos($idemp);
 $filaemp=mysqli_fetch_object($resultEmp);
 $nombreEmp=$filaemp->nombre_empleado;
 $apellido=$filaemp->apellido_empleado;
 $nombreVendedor=$nombreEmp.' '.$apellido;
 }


        //$pdf->Image('images/logoserrate3.jpg',10, 10, 70, 15, '', '', '', false, 300, '', false, false, 0, false,false,false);

$pdf->Ln(10);    
        $pdf->Cell(100, 0, '                                                                                       REPORTE DE COMPRAS EN EL RANGO DE FECHAS', 0, 0, 'C', 0, '', 0);
        $pdf->Ln(4); 
        $pdf->Cell(95, 0, 'Desde: '.$fechaIni.'      Hasta: '.$fechaFin, 0, 0, 'C', 0, '', 0);
        $pdf->Ln(4);
       // $pdf->Cell(0, 0, 'Ejecutivo de venta :'.$nombreVendedor, 0, 0, 'L', 0, '', 0);




        
$pdf->Ln(5);


$pdf->SetFont('','',8);
/*===============================================================
CABECERA DE LA TABLA
/*===============================================================*/
$bloqueCabeceraDetalle=<<<EOF
<table border="0.1px">
  <thead>
     <tr id="fila1" style="background-color:#e8e8e8;">
                  <th style="text-align:center; width:35px;">Nº Lote</th>
                  <th style="text-align:center; ">Fecha</th>
                  <th style="text-align:center; width:70px;">Producto</th>
                  <th style="text-align:center; ">C. Facturada</th>
                  <th style="text-align:center; width:50px;">Proveedor</th>
                  <th style="text-align:center; width:30px;">Cant. de compra</th>
                  <th style="text-align:center; width:30px;">Cant. actual</th>     
                  <th style="text-align:center; ">Precio venta unidad</th>
                  <th style="text-align:center; ">Precio venta Facturado</th>
                  <th style="text-align:center; ">Precio ultimo</th>
                  <th style="text-align:center; ">Costo unitario</th>              
                  <th style="text-align:center; ">Costo Total</th>
                  <th style="text-align:center; width:49px;">Usuario</th>                
    </tr>

  </thead>

  

</table>
EOF;
$pdf->writeHTML($bloqueCabeceraDetalle,false,false,false,false,'');

               
               $contador=1;
               $totalMontoCompras=0;
                $sub_costo=0;
                $ganacia=0;
                $GananciasTotales=0;
                $ganaciaDecimal=0;
               $alertaColorfila='';
               $colorTexto='';
                $obj=new Compra();

                if ($idemp==0)/*reporte de todos los que realizaron ventas*/
                {
                  $resultado=$obj->ReporteComprasActivas($fechaIni,$fechaFin);
                }
                else/*reporte de un ventero especifico*/
                {
                 //$resultado=$obj->reporteVentasDeUnEmpleado($fechaIni,$fechaFin,$idemp); 
                }

                ///$resultado=$obj->reporteVentas($fechaIni,$fechaFin);
                while ($fila=mysqli_fetch_object($resultado)) 
                {
                 
      
                   /*obtenemos la ganacia de total vendido del producto*/
                  //$sub_costo=$fila->precio_compra_prod*$fila->cantidad_prod;   
                  //  $ganacia=$fila->subtotal_venta-$sub_costo;
                  //  $ganaciaDecimal=number_format((float)$ganacia, 2, '.', '');
              
              $bloqueDatosDetalle=<<<EOF
                                  <table border="0.1px">
                                  <thead>
                                  <tr style="page-break-inside: avoid;background-color:$alertaColor; color:$colorTexto; " nobr="true">
                                     <th style="text-align:center; width:35px;">$fila->idcompra</th>
                                     <th style="text-align:center; ">$fila->fecha_compra</th>
                                     <th style="text-align:center; width:70px;">$fila->nameProducto</th>
                                     <th style="text-align:center; ">$fila->compra_facturada</th>
                                     <th style="text-align:center; width:50px;">$fila->nameProveedor</th>
                                     <th style="text-align:center; width:30px;">$fila->cantidad</th>
                                     <th style="text-align:center; width:30px;">$fila->stock_actual</th>
                                     <th style="text-align:center; ">$fila->precio_venta_prod</th>
                                     <th style="text-align:center; ">$fila->precio_venta_prod_Fact</th>
                                     <th style="text-align:center; ">$fila->precio_tope</th>
                                     <th style="text-align:center; ">$fila->precio_unit_compra</th>
                                     <th style="text-align:center; ">$fila->monto_compra</th>
                                     <th style="text-align:center; width:49px;">$fila->Usuario</th>                                
                                  </tr>
                                  </thead>
                                  </table>
                                  EOF;

$pdf->writeHTML($bloqueDatosDetalle,false,false,false,false,'');
$pdf->SetMargins(34, 30 ,5);

             
                 // $contador++;
                  $totalMontoCompras=$totalMontoCompras+$fila->monto_compra;

                 // $GananciasTotales=$GananciasTotales+$ganacia;
                 }
                 /***************************TABLA TOTALES*************/
                 $totalComprasDecimal=number_format((float)$totalMontoCompras, 2, '.', '');
               //  $GanaciasDecimal=number_format((float)$GananciasTotales, 2, '.', '');
$bloqueTotalesCostosOrdenes=<<<EOF
<table border="0.1px" cellpadding="1" >
<tr style="page-break-inside: avoid;" nobr="true">
   <td style="text-align:center; width:479px;">TOTALES</td>
   <td style="text-align:center; width:45px;">$totalComprasDecimal</td>
   <td style="text-align:center; width:48px;"></td>

</tr>

</table>
EOF;

$pdf->writeHTML($bloqueTotalesCostosOrdenes,false,false,false,false,'');

               
         








$nameFile='reporte_de_ventas.pdf';
ob_end_clean(); //LIMPIA ESPACIOS EN BLANCO PARA NO GENERAR ERROREA
$pdf->Output($nameFile);

?>