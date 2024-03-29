<?php
include_once("modelos/compra.modelo.php");
include_once("modelos/productos.modelo.php");
include_once("modelos/proveedor.modelo.php");
///$datosad=$_SESSION["usuarioAdmin"];


if ($_SESSION["tipo_user"]=="emp" and $datosUsuario["permiso_especial"]==0)
{
  echo '<script>
        window.location="inicio";
      </script>';
}
if ($_SESSION["usuarioAdmin"]!="") 
{
   $datosUsuario=$_SESSION["usuarioAdmin"];
  $id_usuario=$datosUsuario["id_administrador"];
}
if ($_SESSION["usuarioEmp"]!="") 
{
  $datosUsuario=$_SESSION["usuarioEmp"];
  $id_usuario=$datosUsuario["id_empleado"];
}
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administrar Compras
        <small>Panel de control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active">Administrar compras</li>
        
      </ol>
    </section>


    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCompra">
            Agregar compra
          </button>
        </div>

        <div class="box-body">
          <table class="table table-bordered table-striped tablas">
             <thead>
                <tr>
                  <th style="width: 10px;">#</th>
                  <th>Nº Lote</th>
                  <th>Fecha</th>
                  <th>Producto</th>
                  <th>Cantidad</th>
                  <th>Stock actual</th>
                  <th>Costo Unitario</th>
                  <th>Costo Total</th>
                  <th>C. Facturada</th>
                  <th>Proveedor</th>
                  <th>Usuario</th>
                  <th>Acciones</th>
                </tr>
             </thead>

             <tbody>
               <?php
               $contador=1;
                $objcomp=new Compra();
                $resultado=$objcomp->listarCompras();
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
                                     $fila->stock_actual."||".
                                     $fila->monto_compra."||".
                                     $fila->precio_unit_compra."||".
                                     $fila->precio_unit_compraFacturado;
                           
              ?>
               <tr>
                 <td><?php echo $contador; ?></td>
                 <td><a target="_blank" href="impresiones/tcpdf/pdf/nota_compra.php?codcompra=<?php echo $fila->id_compra_producto ?>"><?php echo $fila->id_compra_producto; ?></a></td>
                 <td><?php echo $fila->fecha_compra; ?></td>
                 <td><?php echo $fila->nameProducto; ?></td>
                 <td><?php echo $fila->cantidad; ?></td>
                 <td><?php echo $fila->stock_actual; ?></td>
                 <td><?php echo $fila->precio_unit_compra; ?></td>

                <!--  <script type="text/javascript">
                   var montoTotal=0;
                   montoTotal=parseFloat(<?php echo $fila->precio_unit_compra; ?>);
                   var objetivo = document.getElementById('colum_total').innerHTML;
                   objetivo.innerHTML = montoTotal;
                 </script> -->
                 <?php
                $costo_float= floatval($fila->precio_unit_compra);
                $montoTotal=$costo_float*$fila->cantidad;

                 ?>
                 <td><?php echo number_format((float)$montoTotal, 2, '.', ''); ?></td>
                 <td><?php echo $fila->compra_facturada; ?></td>
                 <td><?php echo $fila->nameProveedor; ?></td>
                 <td><?php echo $fila->usuario_compra; ?></td>
                 
                 <td>
                   <div class="btn-group">
                      <button class="btn btn-warning" data-toggle="modal" data-target="#modaleditarCompra" onclick="CargarinfoCompraEnModal('<?php echo $datoscomp ?>')"><i class="fa fa-pencil"></i></button> 

                      <button class="btn btn-danger" data-toggle="modal" data-target="#modalElimComp" onclick="CargarinfoCompraEnModalElim('<?php echo $datoscomp ?>')"><i class="fa fa-times"></i></button>
                      <button class="btn btn-info" data-toggle="modal" data-target="#modalDarBajaStock" onclick="CargarinfoCompraEnModalDarBajaStock('<?php echo $datoscomp ?>')"><i class="fa fa-trash"></i></button>
                   </div>
                 </td>
               </tr>
               <?php
                 $contador++;
                 }
               ?>
             </tbody>
          </table>
        </div>

        <!-- /.box-body -->
        <div class="box-footer">
          Footer
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->  
  </div>
  <!-- /.content-wrapper -->

  <!--MODAL PARA AGREGAR USUSARIOS -->
   <!-- Modal -->
<div id="modalAgregarCompra" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      
      <div class="modal-header" style="background: #3c8dbc; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Agregar compra</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

            <div class="form-group ">
              <label>Elija producto</label>
              <div class="input-group ">
                  <input type="hidden" name="tipo_user" id="tipo_user" value="<?php echo $_SESSION["tipo_user"]; ?>" placeholder="tipo de usuario">
                   <input type="hidden" name="idadmin" id="idadmin" value="<?php echo $id_usuario; ?>">

                   <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <select class="form-control select2 input-lx" style="width: 100%;" name="selectprod" id="selectprod">
                  <?php
                    $obj=new Producto();
                    $resultado=$obj->listarProductosActivos();
                   while ($filp=mysqli_fetch_object($resultado)) 
                     {
                      ?> 
                    <option value="<?php echo $filp->id_producto; ?>"><?php echo $filp->nombre_producto." [".$filp->codigo_producto."]"; ?></option>
                      <?php
                     }
                   
                  ?>
                   
                 
                </select>
              </div>  
            </div>

            <div class="form-group">
              <label>Seleccione si es compra facturada</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa  fa-fax"></i></span>

                 <div class="checkbox">
                  <label>
                    <input type="checkbox" name="checkfact" id="checkfact" onclick="ponerReadonlyInput()"> Compra Facturada
                  </label>
                </div>
              </div>  
            </div>


             <div class="form-group ">
              <label>Elija proveedor</label>
              <div class="input-group ">
                   
                   <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <select class="form-control select2 input-lx" style="width: 100%;" name="selectprov" id="selectprov">
                  <?php
                    $objprov=new Proveedor();
                    $resultadoprov=$objprov->listarProveedoresActivos();
                   while ($filprov=mysqli_fetch_object($resultadoprov)) 
                     {
                      ?> 
                    <option value="<?php echo $filprov->id_proveedor; ?>"><?php echo $filprov->nombre_proveedor; ?></option>
                      <?php
                     }
                   
                  ?>
                   
                  
                </select>
              </div>  
            </div>


           

            <div class="form-group">
              <label>Precio de venta del producto (precio para la venta)</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa  fa-money"></i></span>
                 <input type="text" class="form-control input-lx" name="nuevoCostoVenta" id="nuevoCostoVenta" placeholder="Ingresar precio de venta" required="" autocomplete="off">
              </div>  
            </div>

            <div class="form-group">
              <label>Precio venta facturado del producto (precio para la venta)</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa  fa-money"></i></span>
                 <input type="text" class="form-control input-lx" name="nuevoCostoVFact" id="nuevoCostoVFact" placeholder="Ingresar precio de venta facturada" required="" autocomplete="off">
              </div>  
            </div>

            <div class="form-group">
              <label>Precio ultimo de producto (precio minimo para venta)</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa  fa-money"></i></span>
                 <input type="text" class="form-control input-lx" name="nuevoCostoTope" id="nuevoCostoTope" placeholder="Ingresar precio de venta tope" required="" autocomplete="off">
              </div>  
            </div>


            <div class="form-group">
              <label>Cantidad (Cantidad de productos comprados)</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-check"></i></span>
                 <input type="number" class="form-control input-lx" min="1" name="nuevoCantidad" id="nuevoCantidad" placeholder="Ingresar cantidad" required="" onkeyup="calcularCostoPorUnidad();" autocomplete="off">
              </div>  
            </div>


             <div class="form-group">
              <label>Costo de producto por unidad (costo de cada producto)</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa  fa-money"></i></span>
                 <input type="text" class="form-control input-lx" name="nuevoCostoComp" id="nuevoCostoComp" placeholder="Costo de producto por unidad" required="" readonly="" onkeyup="calcularCostoPorUnidad();" autocomplete="off">
              </div>  
            </div>

            <div class="form-group">
              <label>Costo Total de Compra</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-check"></i></span>
                 <input type="number" class="form-control input-lx" min="1" name="costoTotalcompra" id="costoTotalcompra" placeholder="Ingresar costo total" required=""  autocomplete="off">
              </div>  
            </div>

      <script type="text/javascript">
        function calcularCostoPorUnidad()
        {
          var costoTotal=0;
          var cantidadItem=document.getElementById('nuevoCantidad').value;
          var costoProducto=document.getElementById('nuevoCostoComp').value;

         // var costoTotalCompras=document.getElementById('costoTotalcompra').value;
          if (cantidadItem!='' & costoProducto!='') 
          {
            costoTotal=(cantidadItem)*(costoProducto);
          document.getElementById('costoTotalcompra').value=costoTotal
        // alert(costoPorUnidad);
          }
         
        }
      </script>    

            <div class="form-group">
              <label>Costo de producto por unidad (Facturado)</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa  fa-money"></i></span>
                 <input type="text" class="form-control input-lx" name="nuevoCostoCompFact" id="nuevoCostoCompFact" placeholder="Ingresar costo de producto facturada" required="" readonly value="0">
              </div>  
            </div>

            

         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btnguardarCompra" id="btnguardarCompra">Guardar</button>
      </div>
     
    </div>

  </div>
</div>




  <!-- Modal para editar compra-->
<div id="modaleditarCompra" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      
      <div class="modal-header" style="background: #f39c12; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modificar compra</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

            <div class="form-group ">
              <label>Elija producto</label>
              <div class="input-group ">
                <input type="hidden" name="tipo_user_edit" id="tipo_user_edit" value="<?php echo $_SESSION["tipo_user"]; ?>" placeholder="tipo de usuario">
                   <input type="hidden" name="idadmin_edit" id="idadmin_edit" value="<?php echo $id_usuario; ?>">
                   <input type="hidden" name="idcompra_edit" id="idcompra_edit" >

                   <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <select class="form-control input-lx" style="width: 100%;" name="selectprodedit" id="selectprodedit">
                  <?php
                    $obj=new Producto();
                    $resultado=$obj->listarProductosActivos();
                   while ($filp=mysqli_fetch_object($resultado)) 
                     {
                      ?> 
                    <option value="<?php echo $filp->id_producto; ?>"><?php echo $filp->nombre_producto." [".$filp->codigo_producto."]"; ?></option>
                      <?php
                     }
                   
                  ?>
                   
                 
                </select>
              </div>  
            </div>

            <div class="form-group">
              <label>Seleccione si es compra facturada</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa  fa-fax"></i></span>

                 <div class="checkbox">
                  <label>
                    <input type="checkbox" name="checkfactedit" id="checkfactedit" onclick="ponerReadonlyInputEdit()"> Compra Facturada
                  </label>
                </div>
              </div>  
            </div>


             <div class="form-group ">
              <label>Elija proveedor</label>
              <div class="input-group ">
                   
                   <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <select class="form-control input-lx" style="width: 100%;" name="selectprovedit" id="selectprovedit">
                  <?php
                    $objprov=new Proveedor();
                    $resultadoprov=$objprov->listarProveedoresActivos();
                   while ($filprov=mysqli_fetch_object($resultadoprov)) 
                     {
                      ?> 
                    <option value="<?php echo $filprov->id_proveedor; ?>"><?php echo $filprov->nombre_proveedor; ?></option>
                      <?php
                     }
                   
                  ?>
                   
                  
                </select>
              </div>  
            </div>


           

            <div class="form-group">
              <label>Costo de venta</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa  fa-money"></i></span>
                 <input type="text" class="form-control input-lx" name="nuevoCostoVentaedit" id="nuevoCostoVentaedit" placeholder="Ingresar costo de venta" required="" autocomplete="off">
              </div>  
            </div>

            <div class="form-group">
              <label>Costo venta facturado</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa  fa-money"></i></span>
                 <input type="text" class="form-control input-lx" name="nuevoCostoVFactedit" id="nuevoCostoVFactedit" placeholder="Ingresar costo de venta facturada" required="" autocomplete="off">
              </div>  
            </div>

            <div class="form-group">
              <label>Costo ultimo</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa  fa-money"></i></span>
                 <input type="text" class="form-control input-lx" name="nuevoCostoTopeedit" id="nuevoCostoTopeedit" placeholder="Ingresar costo de venta tope" required="" autocomplete="off">
              </div>  
            </div>


            <div class="form-group">
              <label>Cantidad</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-check"></i></span>
                 <input type="number" class="form-control input-lx" min="1" name="nuevoCantidadedit" id="nuevoCantidadedit" placeholder="Ingresar cantidad" required="" onkeyup="calcularCostoPorUnidadEdit();" autocomplete="off">
              </div>  
            </div>


             <div class="form-group">
              <label>Costo de producto por unidad</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa  fa-money"></i></span>
                 <input type="text" class="form-control input-lx" name="nuevoCostoCompedit" id="nuevoCostoCompedit" placeholder="Costo de producto por unidad" required="" readonly="" onkeyup="calcularCostoPorUnidadEdit();"  autocomplete="off">
              </div>  
            </div>

            <div class="form-group">
              <label>Costo Total de Compra</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-check"></i></span>
                 <input type="number" class="form-control input-lx" min="1" name="costoTotalcompraedit" id="costoTotalcompraedit" placeholder="Ingresar costo total" required=""  autocomplete="off">
              </div>  
            </div>

      <script type="text/javascript">
        function calcularCostoPorUnidadEdit()
        {
          var costoTotal=0;
          var cantidadItem=document.getElementById('nuevoCantidadedit').value;
          var costo_prod=document.getElementById('nuevoCostoCompedit').value;
          if (cantidadItem!='' & costo_prod!='') 
          {
            costoTotal=(costo_prod)*(cantidadItem);
          document.getElementById('costoTotalcompraedit').value=costoTotal
        // alert(costoPorUnidad);
          }
         
        }
      </script>    

            <div class="form-group">
              <label>Costo de producto por unidad (Facturado)</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa  fa-money"></i></span>
                 <input type="text" class="form-control input-lx" name="nuevoCostoCompFactedit" id="nuevoCostoCompFactedit" placeholder="Ingresar costo de producto facturada" required="" readonly>
              </div>  
            </div>

            

         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btnguardarCompraEdit" id="btnguardarCompraEdit">Guardar</button>
      </div>
     
    </div>

  </div>
</div>









 <!-- Modal Eliminar empleado-->
<div id="modalElimComp" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      
      <div class="modal-header" style="background: #dd4b39; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Eliminar compra</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

            <div class="form-group">
              <div class="input-group">
                  <input type="hidden" name="tipo_user_elim" id="tipo_user_elim" value="<?php echo $_SESSION["tipo_user"]; ?>" placeholder="tipo de usuario">
                   <input type="hidden" name="idadmin_elim" id="idadmin_elim" value="<?php echo $id_usuario; ?>">

                  <input type="hidden" name="idcompra" id="idcompra" placeholder="id compra">
                  <input type="hidden" name="cantCompra" id="cantCompra" placeholder="cantidad">
                  <input type="hidden" name="idproducto" id="idproducto" placeholder="id producto">
                  <input type="hidden" name="compfacturada" id="compfacturada" placeholder="compra facturada">

                 
              </div>  
            </div>

           
            <div class="form-group">
              <div class="input-group">
                  <label >Desea eliminar la compra con codigo&nbsp;  </label> <label id="labelcodigo"></label> <label>&nbsp;?</label>

              </div>  
            </div>


         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btnelimcomp" id="btnelimcomp">Eliminar</button>
      </div>
     
    </div>

  </div>
</div>

        <!-- /.modal --> 




<!-- Modal dar baja stock-->
<div id="modalDarBajaStock" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      
      <div class="modal-header" style="background: #46b8da; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Dar de baja stock</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

            <div class="form-group">
              <div class="input-group">
                  <input type="hidden" name="tipo_user_elim" id="tipo_user_elim" value="<?php echo $_SESSION["tipo_user"]; ?>" placeholder="tipo de usuario">
                  <input type="hidden" name="idadmin_elim" id="idadmin_elim" value="<?php echo $id_usuario; ?>" placeholder="id admin">
                  <input type="hidden" name="idcompra_baja" id="idcompra_baja" placeholder="id compra">
                  <input type="hidden" name="idproducto_baja" id="idproducto_baja" placeholder="id producto">
                  <input type="hidden" name="costo_unitario" id="costo_unitario" placeholder="costo unitario">
                  
              <div class="form-group">
              <label>Stock actual</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-check"></i></span>
                 <input type="number" class="form-control input-lx" min="1" name="cantCompra_actual" id="cantCompra_actual" placeholder="stock actual" readonly  >
              </div>  
            </div>
              <div class="form-group">
              <label>Ingrese la cantidad que desea reducir</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-check"></i></span>
                 <input type="number" class="form-control input-lx" min="1" name="cantidad_reducir" id="cantidad_reducir" placeholder="Ingresar cantidad" required="" >
              </div>  
            </div>
                 
              </div>  
            </div>

         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
        <button type="submit" class="btn btn-primary" name="btndarbajastock" id="btndarbajastock">Dar Baja</button>
      </div>
     
    </div>

  </div>
</div>

        <!-- /.modal -->



<script type="text/javascript">
  /*CODIGO QUE PONE READONLY AL CAMPO INPUT PRECIO FACTURADO*/
  ponerReadonlyInput();
  function ponerReadonlyInput()
  {
    var campoCostocompra = document.getElementById('nuevoCostoComp');
    var campoCostocompraFact = document.getElementById('nuevoCostoCompFact');
    var Cheq1=document.getElementById("checkfact").checked
    campoCostocompra.readOnly = false; // Se quita el atributo para que se pueda escribir 
        //  if (Cheq1==false) /*si no esta chequeado checket factura*/
        //  {   
         //   campoCostocompraFact.value=0;
         //     campoCostocompraFact.readOnly = true; // Se añade el atributo
         //     campoCostocompra.readOnly = false; // Se quita el atributo    
         // }
         // else
         // {
         //   if (Cheq1==true)/*si esta chekeado  checket factura*/ 
         //   {   
         //     campoCostocompra.value=0;
         //     campoCostocompra.readOnly = true; // Se añade el atributo
         //     campoCostocompraFact.readOnly = false; // Se quita el atributo  
         //   }
         // }*/
  }


    /*CODIGO QUE PONE READONLY AL CAMPO INPUT PRECIO FACTURADO EDIT*/
  ponerReadonlyInputEdit();
  function ponerReadonlyInputEdit()
  {
    var campoCostocompra = document.getElementById('nuevoCostoCompedit');
    var campoCostocompraFact = document.getElementById('nuevoCostoCompFactedit');
    var Cheq1=document.getElementById("checkfactedit").checked
    campoCostocompra.readOnly = false; // Se quita el atributo  para que sea de escritura
       //   if (Cheq1==false) /*si no esta chequeado checket factura*/
       //   {   
       //     campoCostocompraFact.value=0;
            //  campoCostocompraFact.readOnly = true; // Se añade el atributo
       //       campoCostocompra.readOnly = false; // Se quita el atributo    
        //  }
        //  else
        //  {
        //    if (Cheq1==true)/*si esta chekeado  checket factura*/ 
         //   {   
         //     campoCostocompra.value=0;
         //     campoCostocompra.readOnly = true; // Se añade el atributo
            //  campoCostocompraFact.readOnly = false; // Se quita el atributo  
         //   }
         // }
  }

 
  $(document).ready(function() { 
   $("#btnguardarCompra").on('click', function() {
  
   var formDataComp = new FormData(); 
   
   var btnguardarCompra=$('#btnguardarCompra').val();
   var tipo_user=$('#tipo_user').val();
   var idadmin=$('#idadmin').val();
   var selectprod=$('#selectprod').val();
   var checkfact=$('#checkfact').val();
   var selectprov=$('#selectprov').val();
   var nuevoCostoComp=$('#nuevoCostoComp').val();
   var nuevoCostoVenta=$('#nuevoCostoVenta').val();
   var nuevoCostoVFact=$('#nuevoCostoVFact').val();
   var nuevoCostoTope=$('#nuevoCostoTope').val();
   var nuevoCantidad=$('#nuevoCantidad').val();
   var nuevoCostoCompFact=$('#nuevoCostoCompFact').val();
   
   
  
   if ( (selectprod=='') ||  (checkfact=='')||  (selectprov=='')||  (nuevoCostoComp=='')||  (nuevoCostoVenta=='') ||  (nuevoCostoVFact=='') ||  (nuevoCostoTope=='') ||  (nuevoCantidad=='') ||  (nuevoCostoCompFact=='')) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     var Cheq1=document.getElementById("checkfact").checked
          if (Cheq1==false) 
          {
            formDataComp.append("checkfact",'null')
          }
          else
          {
            if (Cheq1==true) 
            {
              formDataComp.append("checkfact",'true')
            }
          }
     formDataComp.append('selectprod',selectprod);
     formDataComp.append('idadmin',idadmin);
     formDataComp.append('tipo_user',tipo_user);
     formDataComp.append('selectprov',selectprov);
     formDataComp.append('nuevoCostoComp',nuevoCostoComp);
     formDataComp.append('nuevoCostoVenta',nuevoCostoVenta);
     formDataComp.append('nuevoCostoVFact',nuevoCostoVFact);
     formDataComp.append('nuevoCostoTope',nuevoCostoTope);
     formDataComp.append('nuevoCantidad',nuevoCantidad);
     formDataComp.append('nuevoCostoCompFact',nuevoCostoCompFact);
     formDataComp.append('btnguardarCompra',btnguardarCompra);
     
      $.ajax({ url: 'controladores/compra.controlador.php', 
               type: 'post', 
               data: formDataComp, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                console.info(response);
                //    var posOk=response[1];
                //    var posIdpregunta=response[4];
                //    console.info(posIdpregunta);
                  if (response==1) 
                  {
                    
                    setTimeout(function(){ location.href='compras'; }, 2000); swal('EXELENTE','','success'); 
                     
                  }
                  else
                  {
                    setTimeout(function(){  }, 2000); swal('ERROR','Intente nuevamente','error');
                                       
                  } 
                }
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });
/*========================CARGAMOS LOS DATOS PARA ACTUALIZAR=========================*/
function CargarinfoCompraEnModal(datoscomp) 
  {
   
    f=datoscomp.split('||');
    $('#idcompra_edit').val(f[0]);
     $('#selectprodedit').val(f[1]);
      
      $('#selectprovedit').val(f[3]);
      $('#nuevoCostoVentaedit').val(f[4]);
      $('#nuevoCostoVFactedit').val(f[5]);
      $('#nuevoCostoTopeedit').val(f[6]);
      $('#nuevoCantidadedit').val(f[7]);
      $('#costoTotalcompraedit').val(f[8]);
      $('#nuevoCostoCompedit').val(f[9]); 
      $('#nuevoCostoCompFactedit').val(f[10]);

       var facturado=f[2];  
      if (facturado=='si') 
       {
         $("#checkfactedit").prop('checked', true);
       }
       else
       {
         $("#checkfactedit").prop('checked', false);
       }
           
          // $('#textidalim').text(f[0]);
  }

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

  /*========================CARGAMOS LOS DATOS PARA DAR BAJA EL STOK=========================*/
function CargarinfoCompraEnModalDarBajaStock(datoscomp) 
  {
    
    f=datoscomp.split('||');
    $('#idcompra_baja').val(f[0]);
    
    $('#labelcodigo').text(f[0]);

    $('#cantCompra_actual').val(f[8]);
    $('#idproducto_baja').val(f[1]);       
    $('#costo_unitario').val(f[10]);
          // $('#textidalim').text(f[0]);
  }

/*===================FUNCION QUE LLAMA AL ELIMINAR ===========================================*/
$(document).ready(function() { 
   $("#btnelimcomp").on('click', function() {
  
   var formDataelim = new FormData(); 
   
   var btnelimcomp=$('#btnelimcomp').val();
   var tipo_user_elim=$('#tipo_user_elim').val();
   var idadmin_elim=$('#idadmin_elim').val();
   var idcompra=$('#idcompra').val();
   var cantCompra=$('#cantCompra').val();
   var idproducto=$('#idproducto').val();
   var compfacturada=$('#compfacturada').val();
  
   
  
   if ( (idcompra=='') ||  (cantCompra=='') ||  (idproducto=='') ||  (compfacturada=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataelim.append('idcompra',idcompra);
     formDataelim.append('idadmin_elim',idadmin_elim);
     formDataelim.append('btnelimcomp',btnelimcomp);
     formDataelim.append('cantCompra',cantCompra);
     formDataelim.append('idproducto',idproducto);
     formDataelim.append('compfacturada',compfacturada);
  
     
     
      $.ajax({ url: 'controladores/compra.controlador.php', 
               type: 'post', 
               data: formDataelim, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                console.info(response);
                //    var posOk=response[1];
                //    var posIdpregunta=response[4];
                //    console.info(posIdpregunta);
                  if (response==1) 
                  {
                    
                    setTimeout(function(){ location.href='compras'; }, 2000); swal('EXELENTE','','success');        
                  }
                  else
                  {
                      if (response==2) 
                      {
                        setTimeout(function(){  }, 2000); swal('ERROR','No se puede eliminar, Hay ventas registradas de esta compra (Nº Lote), primero debe eliminar la venta','error');
                      }
                      else
                      {
                      setTimeout(function(){  }, 2000); swal('ERROR','Intente nuevamente','error');
                      }                 
                  } 
                }
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });

/********ACTUALIZAR UNA COMPRA***********/
$(document).ready(function() { 
   $("#btnguardarCompraEdit").on('click', function() {
  
   var formDataCompedit = new FormData(); 
   
   var btnguardarCompraEdit=$('#btnguardarCompraEdit').val();
   var idadmin_edit=$('#idadmin_edit').val();
   var tipo_user_edit=$('#tipo_user_edit').val();
   var idcompra_edit=$('#idcompra_edit').val();
   var selectprodedit=$('#selectprodedit').val();
   var checkfactedit=$('#checkfactedit').val();
   var selectprovedit=$('#selectprovedit').val();
   var nuevoCostoVentaedit=$('#nuevoCostoVentaedit').val();
   var nuevoCostoVFactedit=$('#nuevoCostoVFactedit').val();
   var nuevoCostoTopeedit=$('#nuevoCostoTopeedit').val();
   var nuevoCantidadedit=$('#nuevoCantidadedit').val();
   var costoTotalcompraedit=$('#costoTotalcompraedit').val(); 
   var nuevoCostoCompedit=$('#nuevoCostoCompedit').val(); 
   var nuevoCostoCompFactedit=$('#nuevoCostoCompFactedit').val();
   
   
  
   if ( (selectprodedit=='') ||  (selectprovedit=='')||  (nuevoCostoVentaedit=='')||  (nuevoCostoVFactedit=='')||  (nuevoCostoTopeedit=='') ||  (nuevoCantidadedit=='') ||  (costoTotalcompraedit=='') ||  (nuevoCostoCompedit=='') ||  (nuevoCostoCompFactedit=='')) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     var Cheq1=document.getElementById("checkfactedit").checked
          if (Cheq1==false) 
          {
            formDataCompedit.append("checkfactedit",'null')
          }
          else
          {
            if (Cheq1==true) 
            {
              formDataCompedit.append("checkfactedit",'true')
            }
          }
     formDataCompedit.append('idadmin_edit',idadmin_edit);
     formDataCompedit.append('idcompra_edit',idcompra_edit);
    
     formDataCompedit.append('selectprodedit',selectprodedit);
     formDataCompedit.append('tipo_user_edit',tipo_user_edit);
     formDataCompedit.append('selectprovedit',selectprovedit);

     formDataCompedit.append('nuevoCostoVentaedit',nuevoCostoVentaedit);
     formDataCompedit.append('nuevoCostoVFactedit',nuevoCostoVFactedit);
     formDataCompedit.append('nuevoCostoTopeedit',nuevoCostoTopeedit);
     formDataCompedit.append('nuevoCantidadedit',nuevoCantidadedit);
     formDataCompedit.append('costoTotalcompraedit',costoTotalcompraedit);
     formDataCompedit.append('nuevoCostoCompedit',nuevoCostoCompedit);
     formDataCompedit.append('nuevoCostoCompFactedit',nuevoCostoCompFactedit);
     formDataCompedit.append('btnguardarCompraEdit',btnguardarCompraEdit);
     
      $.ajax({ url: 'controladores/compra.controlador.php', 
               type: 'post', 
               data: formDataCompedit, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                console.info(response);
                //    var posOk=response[1];
                //    var posIdpregunta=response[4];
                //    console.info(posIdpregunta);
                  if (response==1) 
                  {
                    
                    setTimeout(function(){ location.href='compras'; }, 2000); swal('EXELENTE','','success'); 
                     
                  }
                  else
                  {
                      if (response==2) 
                      {
                        setTimeout(function(){  }, 2000); swal('ERROR','No se puede actualizar, Hay ventas registradas de esta compra (Nº Lote), primero debe eliminar la venta','error');
                      }
                      else
                      {
                      setTimeout(function(){  }, 2000); swal('ERROR','Intente nuevamente','error');
                      }                  
                  } 
                }
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });


/*===================FUNCION QUE LLAMA AL DAR BAJA STOCK ===========================================*/
$(document).ready(function() { 
   $("#btndarbajastock").on('click', function() {
  
   var formDatabaja = new FormData(); 
   
   var btndarbajastock=$('#btndarbajastock').val();
   var idcompra_baja=$('#idcompra_baja').val();
   var idadmin_elim=$('#idadmin_elim').val();
   var idproducto_baja=$('#idproducto_baja').val();
   var costo_unitario=$('#costo_unitario').val();
   var cantCompra_actual=$('#cantCompra_actual').val(); 
   var cantidad_reducir=$('#cantidad_reducir').val();
   
   if (parseInt(cantidad_reducir) > parseInt(cantCompra_actual)  ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','No puede dar de baja una cantidad mayor al stock actual','warning'); 
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDatabaja.append('idcompra_baja',idcompra_baja);
     formDatabaja.append('idadmin_elim',idadmin_elim);
     formDatabaja.append('idproducto_baja',idproducto_baja);
     formDatabaja.append('btndarbajastock',btndarbajastock);
     formDatabaja.append('costo_unitario',costo_unitario);
     formDatabaja.append('cantCompra_actual',cantCompra_actual);
     formDatabaja.append('cantidad_reducir',cantidad_reducir);

      $.ajax({ url: 'controladores/bajaStock.controlador.php', 
               type: 'post', 
               data: formDatabaja, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                console.info(response);
                //    var posOk=response[1];
                //    var posIdpregunta=response[4];
                //    console.info(posIdpregunta);
                  if (response==1) 
                  {
                    
                    setTimeout(function(){ location.href='compras'; }, 2000); swal('EXELENTE','','success');        
                  }
                  else
                  {

                      if (response==2) 
                      {
                        setTimeout(function(){  }, 2000); swal('ERROR','No se pudo dar baja el stock','error');
                      }
                      else
                      {
                      setTimeout(function(){  }, 2000); swal('ERROR','Intente nuevamente','error');
                      }                 
                  } 
                }
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });

</script>

