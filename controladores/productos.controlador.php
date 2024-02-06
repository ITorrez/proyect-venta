<?php
error_reporting(E_ERROR);
include_once("../modelos/productos.modelo.php");

	/*CONTROLADOR DE INGRESO DE USUARIOS*/
if (isset($_POST["btnguardarprod"])) 
{
  ctrlRegProducto();	
}
if (isset($_POST["btneditprod"])) 
{
	ctrlActuslizarProducto();
}

if (isset($_POST["btnelimprod"])) 
{
	ctrlDarBajaProducto();
}


	 function ctrlRegProducto()
	 {
	 	 ini_set('date.timezone','America/La_Paz');
         $fecha=date("Y-m-d");
         $hora=date("H:i");
         $fechaHora=$fecha.' '.$hora;

		 $nombreProd=ltrim(rtrim($_POST['nuevoNombre']));
		 $codigoProd=ltrim(rtrim($_POST['nuevoCodigo']));

			$obj=new Producto();
			$obj->set_nombreProducto($nombreProd);
			$obj->set_CodigoProducto($codigoProd);
			$obj->set_Descripcion($_POST["nuevoDescripcion"]);
			$obj->set_StokFacturado(0);
			$obj->set_StokSimple(0);
			
			$obj->set_estadoProducto("Activo");
			$obj->set_idMarca($_POST["selectNuevoMarca"]);
			$obj->set_idCategoria($_POST["selectNuevoCateg"]);
			$obj->set_tipo_reg($_POST["tipo_user"]);
			$obj->set_usuario_alta($_POST["idUsuario"]);
			$obj->set_fecha_alta($fechaHora);
			$obj->set_usuarioBaja(0);
			$obj->set_fecha_baja("");
			$obj->set_fecha_modificacion($fechaHora);
            /*validacion de nombre y codigo */
			validacionCamposProducto($nombreProd,$codigoProd);
			if ($obj->guardarProducto()) 
			{
				echo 1;
			}else
			{
				echo 0;
			}	
	}

	function ctrlActuslizarProducto()
	{
		     ini_set('date.timezone','America/La_Paz');
         $fecha=date("Y-m-d");
         $hora=date("H:i");
         $fechaHora=$fecha.' '.$hora;

		$tipo_user=$_POST["tipo_user_edit"];
		$id_usuario=$_POST["idUsuario_edit"];
		$idusuarioProd=0;
		$bandera=0;
   /*verifica que el producto a editar sea del usuario empleado que registro el producto, si es admin se le permite*/
		if ($tipo_user=='emp')
		{
      $obp=new Producto();
      $resultp=$obp->mostrarUnProducto($_POST["idprodedit"]);
      $filap=mysqli_fetch_object($resultp);
      $idusuarioProd=$filap->usuario_alta;
      if ($idusuarioProd==$id_usuario)
      {
        $bandera=1;/*puede editar el producto*/
      }
      else
      {
      	$bandera=2;/*puede editar el producto*/
      }

		}
		else/*cuando es un usuario admin*/
		{
     $bandera=1;/*puede editar el producto*/
		}

		    if ($bandera==1){
				$nombProductoEdit =ltrim(rtrim($_POST['editNombre']));
				$codProdEdit      =ltrim(rtrim($_POST['editCodigo']));
				$obj=new Producto();
				$obj->setid_producto($_POST["idprodedit"]);
				$obj->set_nombreProducto($nombProductoEdit);
			    $obj->set_CodigoProducto($codProdEdit);
				$obj->set_Descripcion($_POST["editDescripcion"]);
				
				$obj->set_idMarca($_POST["selecteditMarca"]);
				$obj->set_idCategoria($_POST["selecteditCateg"]);
				$obj->set_fecha_modificacion($fechaHora);
				/*validacion de nombre y codigo */
			    validacionCamposProductoEdit($nombProductoEdit,$codProdEdit,$_POST["idprodedit"]);

				if ($obj->actualizarProducto()) 
					{
						echo 1;
					}else
					{
						echo 0;
					}
			 }	
			 else
			 {
			 	echo 2;
			 }
	}

	function ctrlDarBajaProducto()
	{
		     ini_set('date.timezone','America/La_Paz');
         $fecha=date("Y-m-d");
         $hora=date("H:i");
         $fechaHora=$fecha.' '.$hora;
         
		$tipo_user=$_POST["tipo_user_elim"];
		$id_usuario=$_POST["idUsuario_elim"];
		$idusuarioProd=0;//codigo del usuario que dio de alta el producto
		$bandera=0;//bandera que indica si puede eliminar o no
   /*verifica que el producto a eliminar sea del usuario empleado que registro el producto, si es admin se le permite*/
		if ($tipo_user=='emp')
		{
      $obp=new Producto();
      $resultp=$obp->mostrarUnProducto($_POST["idprodelim"]);
      $filap=mysqli_fetch_object($resultp);
      $idusuarioProd=$filap->usuario_alta;
      if ($idusuarioProd==$id_usuario)
      {
        $bandera=1;/*puede editar el producto*/
      }
      else
      {
      	$bandera=2;/*puede editar el producto*/
      }

		}
		else/*cuando es un usuario admin*/
		{
     $bandera=1;/*puede editar el producto*/
		}


		  if ($bandera==1) 
		  {
				$obj=new Producto();
				$obj->setid_producto($_POST["idprodelim"]);
				$obj->set_estadoProducto("Inactivo");
				$obj->set_fecha_baja($fechaHora);
				if ($obj->DarBajaProducto()) 
					{
						echo 1;
					}else
					{
						echo 0;
					}
			}
	}

	function validacionCamposProducto($nombreProd,$codigoProd)
	{
		$objpr=new Producto();
		/*VERIFICACION DE NOMBRE */
		$resultp=$objpr->verificaNombProd($nombreProd);
        $filap=mysqli_fetch_object($resultp);
		if ($filap->id_producto>0) {
			echo 3;
			exit();
		}

		/*VERIFICACION DE CODIGO */
		$resultpr=$objpr->verificaCodProd($codigoProd);
        $filapr=mysqli_fetch_object($resultpr);
		if ($filapr->id_producto>0) {
			echo 4;
			exit();
		}    
	}/* fin de funcion de validacion*/

	function validacionCamposProductoEdit($nombreProd,$codigoProd,$idprod)
	{
		$objpr=new Producto();
		/*VERIFICACION DE NOMBRE */
		$resultp=$objpr->verificaNombProd_exeptoID($nombreProd,$idprod);
        $filap=mysqli_fetch_object($resultp);
		if ($filap->id_producto>0) {
			echo 3;
			exit();
		}

		/*VERIFICACION DE CODIGO */
		$resultpr=$objpr->verificaCodProd_exeptoID($codigoProd,$idprod);
        $filapr=mysqli_fetch_object($resultpr);
		if ($filapr->id_producto>0) {
			echo 4;
			exit();
		}    
	}
?>