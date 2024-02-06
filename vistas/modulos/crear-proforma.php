<?php
$_SESSION['arrayIdprodCompra']=array();
include_once("modelos/productos.modelo.php");
include_once("modelos/marca.modelo.php");
include_once("modelos/categorias.modelo.php");
include_once("modelos/clientes.modelo.php");
include_once("modelos/compraProducto.modelo.php");
?>
<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       <a href="listado-proforma">Listado de Proformas</a> 
        <small>Panel de control</small><input type="hidden" name="texttipouser" id="texttipouser" placeholder="tipo user" value="<?php echo $_SESSION['tipouser'] ?>">
        <input type="hidden" name="textiduser" id="textiduser" placeholder="id user" value="<?php echo $iduseractual; ?>">
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active">Proformas</li>
      </ol>
    </section>


<!-- Main content -->
    <section class="content">
    <input type="text" class="form-control input-lx" name="nuevoNombre" id="nuevoNombre" placeholder="Ingresar nombre del cliente" required="" autocomplete="off" >
      <!-- Default box -->
     
   <!-- /.div scrool -->

    <div class="form-group row " id="" >

     
       <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Productos </h3>

              <!-- <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover formularioVenta" border="1">
                <tr style="background: #d2d6de">
                  <th style="width:10%;">Cantidad</th>
                  <th style="width:70%;">Detalle</th>
                  <th style="width:10%;">P/U</th>
                  <th style="width:8%;">Sub total</th>
                </tr>
                <tbody id="nuevoProducto" class="nuevoProducto">
                 <tr>
                  <td><input     name="cant1"   id="cant1" style="whith:100%;" type="number" autocomplete="off" oninput="calculosubtotalnuevo(1)" > </td>
                  <td> <textarea name="prod1"   id="prod1" style="height: 40px; max-width: 750px; min-width: 750px;" autocomplete="off"></textarea> </td>
                  <td><input     name="precio1" id="precio1" type="text"  value="" autocomplete="off" oninput="calculosubtotalnuevo(1)"> </td>
                  <td><input     name="sub1"    id="sub1" type="text"  value="" readonly ></td>
                </tr>
                <tr>
                  <td><input     name="cant2"   id="cant2" style="whith:100%;" type="number" autocomplete="off" oninput="calculosubtotalnuevo(2)"> </td>
                  <td> <textarea name="prod2"   id="prod2" style="height: 40px; max-width: 750px; min-width: 750px;" autocomplete="off"></textarea> </td>
                  <td><input     name="precio2" id="precio2" type="text"  value="" autocomplete="off" oninput="calculosubtotalnuevo(2)"> </td>
                  <td><input     name="sub2"    id="sub2" type="text"  value="" readonly></td>
                </tr> 
                <tr>
                  <td><input     name="cant3"   id="cant3" style="whith:100%;" type="number" autocomplete="off" oninput="calculosubtotalnuevo(3)" > </td>
                  <td> <textarea name="prod3"   id="prod3" style="height: 40px; max-width: 750px; min-width: 750px;" autocomplete="off"></textarea> </td>
                  <td><input     name="precio3" id="precio3" type="text"  value="" autocomplete="off" oninput="calculosubtotalnuevo(3)"> </td>
                  <td><input     name="sub3"    id="sub3" type="text"  value="" readonly></td> 
                </tr>
                <tr>
                  <td><input     name="cant4"   id="cant4" style="whith:100%;" type="number" oninput="calculosubtotalnuevo(4)" autocomplete="off"> </td>
                  <td> <textarea name="prod4"   id="prod4" style="height: 40px; max-width: 750px; min-width: 750px;" autocomplete="off"></textarea> </td>
                  <td><input     name="precio4" id="precio4" type="text"  value="" oninput="calculosubtotalnuevo(4)" autocomplete="off"> </td>
                  <td><input     name="sub4"    id="sub4" type="text"  value="" readonly></td>  
                </tr>
                <tr>
                  <td><input     name="cant5"   id="cant5" style="whith:100%;" type="number" oninput="calculosubtotalnuevo(5)" autocomplete="off"> </td>
                  <td> <textarea name="prod5"   id="prod5" style="height: 40px; max-width: 750px; min-width: 750px;" autocomplete="off"></textarea> </td>
                  <td><input     name="precio5" id="precio5" type="text"  value="" oninput="calculosubtotalnuevo(5)" autocomplete="off"> </td>
                  <td><input     name="sub5"    id="sub5" type="text"  value="" readonly></td>  
                </tr>
                <tr>
                  <td><input     name="cant6"   id="cant6" style="whith:100%;" type="number" oninput="calculosubtotalnuevo(6)" autocomplete="off"> </td>
                  <td> <textarea name="prod6"   id="prod6" style="height: 40px; max-width: 750px; min-width: 750px;" autocomplete="off"></textarea> </td>
                  <td><input     name="precio6" id="precio6" type="text"  value="" oninput="calculosubtotalnuevo(6)" autocomplete="off"> </td>
                  <td><input     name="sub6"    id="sub6" type="text"  value="" readonly></td>  
                </tr>
                <tr>
                  <td><input     name="cant7"   id="cant7" style="whith:100%;" type="number" oninput="calculosubtotalnuevo(7)" autocomplete="off"> </td>
                  <td> <textarea name="prod7"   id="prod7" style="height: 40px; max-width: 750px; min-width: 750px;" autocomplete="off"></textarea> </td>
                  <td><input     name="precio7" id="precio7" type="text"  value="" oninput="calculosubtotalnuevo(7)" autocomplete="off"> </td>
                  <td><input     name="sub7"    id="sub7" type="text"  value="" readonly></td>
                </tr>
                <tr>
                  <td><input     name="cant8"   id="cant8" style="whith:100%;" type="number" oninput="calculosubtotalnuevo(8)" autocomplete="off"> </td>
                  <td> <textarea name="prod8"   id="prod8" style="height: 40px; max-width: 750px; min-width: 750px;" autocomplete="off"></textarea> </td>
                  <td><input     name="precio8" id="precio8" type="text"  value="" oninput="calculosubtotalnuevo(8)" autocomplete="off"> </td>
                  <td><input     name="sub8"    id="sub8" type="text"  value="" readonly></td>
                </tr>
                <tr>
                  <td><input     name="cant9"   id="cant9" style="whith:100%;" type="number" oninput="calculosubtotalnuevo(9)" autocomplete="off"> </td>
                  <td> <textarea name="prod9"   id="prod9" style="height: 40px; max-width: 750px; min-width: 750px;" autocomplete="off"></textarea> </td>
                  <td><input     name="precio9" id="precio9" type="text"  value="" oninput="calculosubtotalnuevo(9)" autocomplete="off"> </td>
                  <td><input     name="sub9"    id="sub9" type="text"  value="" readonly></td> 
                </tr>
                <tr>
                  <td><input     name="cant10"   id="cant10" style="whith:100%;" type="number" oninput="calculosubtotalnuevo(10)" autocomplete="off"> </td>
                  <td> <textarea name="prod10"   id="prod10" style="height: 40px; max-width: 750px; min-width: 750px;" autocomplete="off"></textarea> </td>
                  <td><input     name="precio10" id="precio10" type="text"  value="" oninput="calculosubtotalnuevo(10)" autocomplete="off"> </td>
                  <td><input     name="sub10"    id="sub10" type="text"  value="" readonly></td>  
                </tr>
                <tr>
                  <td><input     name="cant11"   id="cant11" style="whith:100%;" type="number" oninput="calculosubtotalnuevo(11)" autocomplete="off"> </td>
                  <td> <textarea name="prod11"   id="prod11" style="height: 40px; max-width: 750px; min-width: 750px;" autocomplete="off"></textarea> </td>
                  <td><input     name="precio11" id="precio11" type="text"  value="" oninput="calculosubtotalnuevo(11)" autocomplete="off"> </td>
                  <td><input     name="sub11"    id="sub11" type="text"  value="" readonly></td>  
                </tr>
                <tr>
                  <td><input     name="cant12"   id="cant12" style="whith:100%;" type="number" oninput="calculosubtotalnuevo(12)" autocomplete="off"> </td>
                  <td> <textarea name="prod12"   id="prod12" style="height: 40px; max-width: 750px; min-width: 750px;" autocomplete="off"></textarea> </td>
                  <td><input     name="precio12" id="precio12" type="text"  value="" oninput="calculosubtotalnuevo(12)" autocomplete="off"> </td>
                  <td><input     name="sub12"    id="sub12" type="text"  value="" readonly ></td>
                </tr>
                
               
                

                </tbody>
                <tfoot>
                  <tr>
                  <td colspan="3" style="text-align: center; "><b> Total</b></td>
                  <td><input type="text"  id="totalMontoproforma" name="totalMontoproforma" readonly=""></td>  
                  
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col-xs-12 -->
      </div>
      <!-- /.row -->
      <button class="btn btn-primary" id="btnguardarproforma" name="btnguardarproforma" style="float: right;">Guardar proforma</button>
                

    </div>
  <!-- /div nuevoProducto -->


    </section>
    <!-- /.content -->  
    
  </div>
  <!-- /.content-wrapper -->


<script type="text/javascript">
  
  /*=============================FUNCION QUE GUARDA LA PROFORMA=================================*/
   $(document).ready(function() { 
   $("#btnguardarproforma").on('click', async function() {
   var formDataVenta = new FormData(); 
   var btnguardarproforma=$('#btnguardarproforma').val();
   var nuevoNombre=$('#nuevoNombre').val();
   var totalMontoproforma=$("#totalMontoproforma").val();
   var textiduser=$("#textiduser").val();
   var texttipouser=$("#texttipouser").val();
   var cantidadfila1=$("#cant1").val();

   
/* preguntamos si los id son menor a cero(osea si no hay producto seleccionado para la venta)*/
   if ( (nuevoNombre=="") ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Debe colocar el cliente','warning'); 
     
     
   }
   else/*por falso guardamos la proforma*/
   {
    if ((cantidadfila1=="")) {
        setTimeout(function(){  }, 2000); swal('ATENCION','Debe colocar datos en la fila 1','warning'); 
        //break;
        return;
      }
     formDataVenta.append('btnguardarproforma',btnguardarproforma);
     formDataVenta.append('nuevoNombre',nuevoNombre);
     formDataVenta.append('totalMontoproforma',totalMontoproforma);
     formDataVenta.append('textiduser',textiduser);
     formDataVenta.append('texttipouser',texttipouser);
      $.ajax({ url: 'controladores/proforma.controlador.php', 
               type: 'post', 
               data: formDataVenta, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                //console.info(response);
        /*PREGUNTAMOS SI LA RESPUESTA ES MAYOR A CERO, OSEA ES EL ID DE LA VENTA, SE REGISTRA EL DETALLE VENTA*/
                  if (response>0) 
                  {
                           var contador=1;
                           var totalfilas=12; 
                           var idproforma=response;
                          
                           while(contador<=totalfilas)
                           {
                            var textcantidad="cant"+contador;/*obtenemos el id del txt identificador*/
                            var textproducto="prod"+contador;/*obtenemos el id del txt cantidad*/
                            var textprecio="precio"+contador;/*obtenemos el id del txt subtotal venta*/
                            var textsubtotal="sub"+contador;

                            var cantidadprod=$("#"+textcantidad+"").val();
                            var producto=$("#"+textproducto+"").val();
                            var precioprod=$("#"+textprecio+"").val();
                            var subtotalprod=$("#"+textsubtotal+"").val();
                            if (cantidadprod>0) {
                              
                            var formDataVentaProd = new FormData();   
                            formDataVentaProd.append('cantidadprod',cantidadprod);
                            formDataVentaProd.append('producto',producto);
                            formDataVentaProd.append('precioprod',precioprod);
                            formDataVentaProd.append('subtotalprod',subtotalprod);
                            formDataVentaProd.append('idproforma',idproforma);
                          
                            
                               $.ajax({ url: 'controladores/itemProforma.controlador.php', 
                                     type: 'post', 
                                     data: formDataVentaProd, 
                                     contentType: false, 
                                     processData: false, 
                                     success: function(response) { 
                                      //console.info(response);
                                     
                                        // if (response==1) 
                                        // {
                                          
                                        //   setTimeout(function(){ location.href='marcas'; }, 2000); swal('EXELENTE','','success'); 
                                           
                                        // }
                                        // else
                                        // {
                                        //   setTimeout(function(){  }, 2000); swal('ERROR','Intente nuevamente','error');
                                                             
                                        // } 
                                      }
                                  }); 

                             contador++;
                             }/*fin cuando pregunta si hay valor en el campo cantidad */
                             else{
                              break;
                             }
                           }/*fin del while*/

                    
                  setTimeout(function(){ location.href='impresiones/tcpdf/pdf/proforma.php?cod='+idproforma; }, 1000); swal('EXELENTE','','success');    
                  }/*FIN DEL IF QUE INSERTA EL DETALLE DE VENTA*/
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
/*=========================================================================================*/
/*========================================================================================*/


 /*FUNCION PARA EL CALCULO DE SUBTOTALES DE LA PROFORMA */
function calculosubtotalnuevo(fila)
  {
   // var idtextcantidad="txtcantidad"+idprod;
   var textprecio="precio"+fila;/*obtenemos el id del input subtotal*/
   var textsubtotal="sub"+fila;
   var textcantidad="cant"+fila;

   var precioprod=$("#"+textprecio+"").val();
   var cantidad=$("#"+textcantidad+"").val();

   var subtotalprod=cantidad*precioprod;
   $("#"+textsubtotal+"").val(subtotalprod.toFixed(2));
   
       calculoTotalnuevo();
  }

  function calculoTotalnuevo()
  {
    var totalfilas=12;
    var contadorfila=1;
    var totalmontoproforma=0;
    while (contadorfila<=totalfilas) {
      var textsubtotal="sub"+contadorfila;/*obtenemos el id del input subtotal*/
      var textcantidad="cant"+contadorfila;

      var cantidad=$("#"+textcantidad+"").val();
      var subtotal=$("#"+textsubtotal+"").val();
      if (cantidad>0) {
        totalmontoproforma=parseInt(totalmontoproforma)+parseInt(subtotal);
      }
      else{
        $("#totalMontoproforma").val(totalmontoproforma.toFixed(2));
      }
      contadorfila++;
    }
    
  }
</script>



