<?php
session_start();
$fechaIni=$_GET['fini'].' 00:00:00';
$fechaFin=$_GET['ffin'].' 23:59:00';
//$idemp=$_GET['idemp'];

// echo $fechaFin;
$_SESSION["frchaini"]=$fechaIni;
$_SESSION["fechafin"]=$fechaFin;
//$_SESSION["idemp"]=$idemp;
include_once("../../modelos/empleado.modelo.php");
$idemp=0;
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
?>
<!--<label>Ejecutivo de ventas: <?php  echo $nombreVendedor; ?> </label>-->
<table class="table table-bordered table-striped ">
             <thead>
                <tr>
                 
                  <th>Nº Lote</th>
                  <th>Fecha</th>
                  <th>Producto</th>
                  <th>C. Facturada</th>
                  <th>Proveedor</th>
                  <th>Cantidad de compra</th>
                  <th>Cantidad actual</th>
                  <th>Precio venta unidad</th>
                  <th>Precio venta Facturado</th>
                  <th>Precio ultimo</th>
                  <th>Costo unitario</th>
                  <th>Costo Total</th>
                  <th>Usuario</th>

                  <!--  <th>Nº. Lote</th>
                   <th>Costo Unit.</th>
                  <th>Prec. Establecido Bs.</th>
                  <th>Cantidad</th>              
                  <th>Precio Vendido Bs.</th>
                  <th>Sub. Total Bs.</th>
                  <th>Ganancia Bs.</th> -->
                  <th>Borrar</th>
           

                </tr>
             </thead>

             <tbody>
               <?php
               include_once("../../modelos/compra.modelo.php");

                
               $contador=1;
               $ganacia=0;
               $sub_costo=0;
               $GananciasTotales=0;
               $totalMontoCompras=0;
               $alertaColorfila='';
               $colorTexto='';
               $obj=new Compra();              
               $resultado=$obj->ReporteComprasActivas($fechaIni,$fechaFin); 
                while ($fila=mysqli_fetch_object($resultado)) 
                {
                  $datoscomp=$fila->idcompra."||".                            
                                     $fila->idproducto."||".
                                     $fila->compra_facturada."||".
                                     $fila->id_proveedor."||".
                                     $fila->precio_venta_prod."||".
                                     $fila->precio_venta_prod_Fact."||".
                                     $fila->precio_tope."||".
                                     $fila->cantidad."||".
                                     $fila->monto_compra."||".
                                     $fila->precio_unit_compra."||".
                                     $fila->precio_unit_compraFacturado;
                                
  
                  /*obtenemos la ganacia de total vendido del producto*/
                 /* $sub_costo=$fila->precio_compra_prod*$fila->cantidad_prod;*/   
                 $totalMontoCompras=$totalMontoCompras+$fila->monto_compra;
              ?>
               <tr >
                
                 <td><?php echo $fila->idcompra; ?></td>
                 <td><?php echo $fila->fecha_compra; ?></td>
                 <td><?php echo $fila->nameProducto; ?></td>
                <!--  <td><?php echo $fila->descripcion; ?></td> -->
                 <td><?php echo $fila->compra_facturada; ?></td>
                 <td><?php echo $fila->nameProveedor; ?></td>
                 <td><?php echo $fila->cantidad; ?></td>
                  <td><?php echo $fila->stock_actual; ?></td>
                  <td><?php echo $fila->precio_venta_prod; ?></td>
                  <td><?php echo $fila->precio_venta_prod_Fact; ?></td>
                  <td><?php echo $fila->precio_tope; ?></td>
                
                 <td><?php echo $fila->precio_unit_compra; ?></td>             
                 <td><?php echo $fila->monto_compra; ?></td>
                 <td><?php echo $fila->Usuario; ?></td>
                                
                 <td>
                   <div class="btn-group">
                      <button class="btn btn-danger" data-toggle="modal" data-target="#modalElimComp" onclick="CargarinfoCompraEnModalElim('<?php echo $datoscomp ?>')"><i class="fa fa-times"></i></button>
                   </div>
                 </td>
                
               
                 <?php
                // $costo_float= floatval($fila->precio_unit_compra);
                // $montoInvent=$costo_float*$fila->stock_actual;
                // $montoDecimal=number_format((float)$montoInvent, 2, '.', '');

                 ?>
                 <!-- <td><?php echo $montoDecimal; ?></td> -->

                 
                
              
               </tr>
               <?php
                 // $contador++; SUMA DE TOTALES
                //  $totalMontoVentas=$totalMontoVentas+$fila->subtotal_venta;
                 // $GananciasTotales=$GananciasTotales+$ganacia;

                 }
               ?>
             </tbody>
             <tfoot>
               <tr>
                 <td colspan="11" style="text-align: center;"><b>Totales</b> </td>
                
                 <td><b><?php echo number_format((float)$totalMontoCompras, 2, '.', ''); ?></b></td>
                 <td  style="text-align: center;"> </td>
                 <td  style="text-align: center;"> </td>
               </tr>
             </tfoot>
          </table>

<script type="text/javascript">

/*========================CARGAMOS LOS DATOS PARA ELIMINAR=========================*/
function CargarinfoCompraEnModalElim(datoscomp) 
  {
    
    f=datoscomp.split('||');
    $('#idcompra').val(f[0]);
    $('#labelcodigo').text(f[0]);

    $('#cantCompra').val(f[7]);
    $('#idproducto').val(f[1]);       
    $('#compfacturada').val(f[2]);
          // $('#textidalim').text(f[0]);
  }
  
</script>