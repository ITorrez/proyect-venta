<?php
include_once("modelos/venta.modelo.php");
include_once("modelos/empleado.modelo.php");
ini_set('date.timezone','America/La_Paz');
$fecha=date("Y-m-d");
$hora=date("H:i");

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

/*$fechaHora=$fecha.' '.$hora;*/
if ($_SESSION["tipo_user"]!="admin")
{
  echo '<script>
        window.location="inicio";
      </script>';
}
?>


<!-- <script type="text/javascript" src = " https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.0/jspdf.umd.min.js"> </script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
 -->
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Reportes
        <small>Compras</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active">Reportes</li>
      </ol>
    </section>


    <script type="text/javascript">
      function generatePDF()
      {
        var doc =new jsPDF();
        var elementHTML=document.querySelector("#titulo").innerHTML;
        var specialElementHandlers={
          '#elemnetH': function(element,renderer){
            return true;
          }
        };
        // doc.text(20,20,'hello word');
        // doc.save('documento.pdf');
        doc.fromHTML (
          elementHTML,
          15,
          15,
          {
            'width':170,
            'elementHandlers':specialElementHandlers
          }
        );

      }








    </script>


    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          
          <!-- <h3  class="box-title">Reportes De Ventas</h3> -->
     
                 <label>Fecha Inico:</label>
                 <input type="date" name="dateInico" id="dateInico" value="<?php echo $fecha ?>">
                 <label>Fecha Fin:</label>
                 <input type="date" name="dateFinal" id="dateFinal" value="<?php echo $fecha ?>">
                <!--  <label>Vendedor:</label>
                 <select id="selectemp" name="selectemp">
                  <option value="0">Todos</option>
                 // <?php
                   // $objemp=new Empleado();
                   // $result=$objemp->listarEmpleadosActivos();
                   //  while ($fila=mysqli_fetch_object($result)) 
                   //  {
                   //// ?>
                       <option value="<?php echo $fila->id_empleado; ?>"><?php echo $fila->nombre_empleado.' '.$fila->apellido_empleado; ?></option>

                   // <?php
                   //   }
                  //?>
                 
                </select>-->
                 <button  class="btn btn-success btn-xs" onclick="generacionReporte();">Generar</button>
                 <button style="float: right;" class="btn btn-danger btn-xs" onclick="window.open('impresiones/tcpdf/pdf/reporte_compras.php')">PDF</button>
         <!--  <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div> -->
        </div>
        <div class="box-body" id="divtablareportes">
         
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
                   <input type="hidden" name="idadmin_elim" id="idadmin_elim" value="<?php echo $id_usuario; ?>" placeholder="id usuario">

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


    
  </div>
  <!-- /.content-wrapper -->
  <script type="text/javascript">
    
  </script>
  <script type='text/javascript'>
    generacionReporte();
      function generacionReporte()
      {
     var fecha_ini=$('#dateInico').val();
     var fecha_fin=$('#dateFinal').val();
     var idemp=$('#selectemp').val();
    
      $('#divtablareportes').load('vistas/modulos/tabla_reporte_compras.php?fini='+fecha_ini+'&ffin='+fecha_fin+'&idemp='+idemp);
                    // alert(response);                                      
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
                    
                    setTimeout(function(){ location.href='reporte-compras'; }, 2000); swal('EXELENTE','','success');        
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
     
</script>


