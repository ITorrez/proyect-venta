<?php
include_once("modelos/proforma.modelo.php");
include_once("modelos/productos.modelo.php");
include_once("modelos/marca.modelo.php");
include_once("modelos/categorias.modelo.php");
/*if ($_SESSION["tipo_user"]=="emp" and $datosUsuario["permiso_especial"]==0)
{
  echo '<script>
        window.location="inicio";
      </script>';
}*/
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
        Listado Proformas
        <small>Panel de control</small>
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active">Proforma</li>

      </ol>
    </section>


<!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
         
        </div>

        <div class="box-body">
          <table class="table table-bordered table-striped tablas">
             <thead>
                <tr>
                  <th style="width: 10px;">Cod. Proforma</th>
                  <th>Cliente</th>
                  <th>Fecha</th>
                  <th>Usuario</th>
                  <th>Monto</th>                   
                  <th>Acciones</th>
                </tr>
             </thead>

             <tbody>
               <?php
               $contador=1;
                $obj=new Proforma();
                $resultado=$obj->listarProformasActivos();
                while ($fila=mysqli_fetch_object($resultado)) 
                {
                  $datosProd=$fila->id_proforma;
                  
              ?>
               <tr>
                 <td><a href="impresiones/tcpdf/pdf/proforma.php?cod=<?php echo $fila->id_proforma; ?>" target="_blank"> <?php echo $fila->id_proforma; ?></a></td>
                 <td><?php echo $fila->cliente_proforma; ?></td>
                 <td><?php echo $fila->fecha_alta; ?></td>
                 <td><?php echo $fila->usuario; ?></td>
                 <td><?php echo $fila->total_costo; ?></td>
              
               
                <!--  <td><button class="btn btn-success btn-xs">Activo</button> </td> -->
                
                 <td>
                   <div class="btn-group">               
                      <button class="btn btn-danger" data-toggle="modal" data-target="#modalElimProd" onclick="CargarinfoProdEnModalElim('<?php echo $datosProd ?>')"><i class="fa fa-times"></i></button>        
                   </div>
                 </td>
                  
               </tr>

               <?php
                
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



<!-- Modal Eliminar-->
<div id="modalElimProd" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

       <input type="hidden" name="tipo_user_elim" id="tipo_user_elim" value="<?php echo $_SESSION["tipo_user"]; ?>" placeholder="tipo de usuario">
             <input type="hidden" name="idUsuario_elim" id="idUsuario_elim" value="<?php echo $id_usuario; ?>" placeholder="id usuario">

      <div class="modal-header" style="background: #dd4b39; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Eliminar proforma </h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

            <div class="form-group">
              <div class="input-group">
                  
                  <input type="hidden" name="idproforma" id="idproforma" placeholder="id proforma">
                 
              </div>  
            </div>

           
            <div class="form-group">
              <div class="input-group">
                <table>
                  <tr>
                    <th>Se eliminra la proforma con código : </th>
                    <th><h4 id="labelcodigo"> </h4></th>
                  </tr>
                </table>
                  
              </div>  
            </div>


         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btnelimprof" id="btnelimprof">Eliminar</button>
      </div>
     
    </div>

  </div>
</div>

<!-- /.modal --> 


<script type="text/javascript">
 



  /*========================CARGAMOS LOS DATOS PARA ELIMINAR=========================*/
function CargarinfoProdEnModalElim(datosProd) 
  {
    
    f=datosProd.split('||');
    $('#idproforma').val(f[0]);       
     $('#labelcodigo').text(f[0]);
  }





  /*===================FUNCION QUE LLAMA AL ELIMINAR===========================================*/
$(document).ready(function() { 
   $("#btnelimprof").on('click', function() {
  
   var formDataelim = new FormData(); 
   
   var btnelimprof=$('#btnelimprof').val();
   var idproforma=$('#idproforma').val();
   var idUsuario_elim=$('#idUsuario_elim').val();
   
  
   
  
   if ( (idproforma=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataelim.append('idproforma',idproforma);
     formDataelim.append('btnelimprof',btnelimprof);
     formDataelim.append('idUsuario_elim',idUsuario_elim);

      $.ajax({ url: 'controladores/proforma.controlador.php', 
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
                    
                    setTimeout(function(){ location.href='listado-proforma'; }, 2000); swal('EXELENTE','','success'); 
                     
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

</script>



