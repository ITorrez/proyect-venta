<?php
include_once("../modelos/itemProforma.modelo.php");

if (isset($_POST["idproforma"])) 
{
	ctrlguardarItemProforma();
}

   function ctrlguardarItemProforma()
   {
   	     ini_set('date.timezone','America/La_Paz');
         $fecha=date("Y-m-d");
         $hora=date("H:i");
         $fechaHora=$fecha.' '.$hora;

	   	$objprof=new Item_Proforma();
	   	$objprof->setid_proforma($_POST['idproforma']);
	   	$objprof->set_cantidad($_POST['cantidadprod']);
	   	$objprof->set_producto($_POST['producto']);
	   	$objprof->set_costo_unitario($_POST['precioprod']);
	   	$objprof->set_subtotal($_POST['subtotalprod']);/*QUE TIPO DE USUARIO HIZO LA PROFORMA*/
	   
	   	if ($objprof->guardarItemProforma()) 
	   	{
	   		
	   		echo 1;/*devuelve el codigo de la proforma para registrar el detalle*/
	   	}
	   	else
	   	{
	   		echo 0;
	   	}
   }




?>