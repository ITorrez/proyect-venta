<?php
include_once("../modelos/proforma.modelo.php");

if (isset($_POST["btnguardarproforma"])) 
{
	ctrlguardarProforma();
}
 if (isset($_POST["btnelimprof"])) 
 {
   ctrlElimProforma();	
 }



   function ctrlguardarProforma()
   {
   	     ini_set('date.timezone','America/La_Paz');
         $fecha=date("Y-m-d");
         $hora=date("H:i");
         $fechaHora=$fecha.' '.$hora;

	   	$objprof=new Proforma();
	   	$objprof->set_clienteproforma($_POST['nuevoNombre']);
	   	$objprof->set_fecha_proceso($fecha);
	   	$objprof->set_fecha_alta($fechaHora);
	   	$objprof->set_usuario_alta($_POST['textiduser']);
	   	$objprof->set_tipo_usuario($_POST['texttipouser']);/*QUE TIPO DE USUARIO HIZO LA PROFORMA*/
	   	$objprof->set_usuario_baja(0);
	   	$objprof->set_total_costo($_POST['totalMontoproforma']);
	   	$objprof->set_estado('A');
	   	if ($objprof->guardarProforma()) 
	   	{
	   		$resultultprof=$objprof->mostrarultimaproformausuario($_POST['textiduser']);
	   		$filult=mysqli_fetch_object($resultultprof);
	   		echo $filult->id_proforma;/*devuelve el codigo de la proforma para registrar el detalle*/
	   	}
	   	else
	   	{
	   		echo 0;
	   	}
   }



/*DAR BAJA UNA PROFORMS*/
   function ctrlElimProforma()
   {
	 $objprof=new Proforma();
	 $objprof->set_estado('N');
	 $objprof->set_usuario_baja($_POST['idUsuario_elim']);
	 $objprof->setid_proforma($_POST['idproforma']);
	 if ($objprof->DarBajaProforma()) {
		echo 1;
	 }
	 else {
		echo 0;
	 }
   }

  


?>