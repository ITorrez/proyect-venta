<?php
include_once("../modelos/bajaStock.modelo.php");
include_once("../modelos/compraProducto.modelo.php");
include_once("../modelos/compra.modelo.php");

	/*CONTROLADOR DE INGRESO DE USUARIOS*/
if (isset($_POST["btndarbajastock"])) 
{
	ctrlRegBajaStock();
}

	 function ctrlRegBajaStock()
	 {
	 	ini_set('date.timezone','America/La_Paz');
         $fecha=date("Y-m-d");
         $hora=date("H:i");
         $fechaHora=$fecha.' '.$hora;

		$costounitario=$_POST["costo_unitario"];
		$montoreducido=$costounitario*$_POST["cantidad_reducir"];
			$obj=new Baja_stock();
			$obj->setid_compra($_POST["idcompra_baja"]);
			$obj->set_cantidadBaja($_POST["cantidad_reducir"]);
			$obj->setid_productoBaja($_POST["idproducto_baja"]);
			$obj->set_montoReducido($montoreducido);
			$obj->set_fechaBajaStock($fechaHora);
			$obj->set_usuarioAlta($_POST["idadmin_elim"]);
			$obj->set_estado("Activo");
			
			if ($obj->guardarBajaStock()) 
			{
				$objcp=new Compra_Producto();
				$result=$objcp->mostrarUnaCompraProductoDeCompra($_POST["idcompra_baja"]);
				$fila=mysqli_fetch_object($result);
				$nuevacantidad=$fila->cantidad_compra-($_POST["cantidad_reducir"]);
				$nuevoStock=$fila->stock_actual-($_POST["cantidad_reducir"]);
				$nuevomontototal=$fila->subtotal_compra-$montoreducido;

				$objcp->set_cantidadCompra($nuevacantidad);
				$objcp->set_stockActual($nuevoStock);
				$objcp->set_subtotalCompra($nuevomontototal);
				if($objcp->darBajaStockCompraProducto($_POST["idcompra_baja"]))
				{
					$objc=new Compra();
					$objc->set_montoCompra($nuevomontototal);
					if($objc->actualizarMontoCompra($_POST["idcompra_baja"]))
					{
						echo 1;
					}
					else{
                       echo 3;
					}
				}
				else{
					echo 2;
				}

                
			}else
			{
				echo 0;
			}	
	}

	
?>