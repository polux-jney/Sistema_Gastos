<!--Archivo Inicio -->
<!--al principio -->
<?php

require 'cabecero.php';

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">CATEGORIAS
           <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true);"><i class="fas fa-plus-circle"></i> Agregar</button>
         </h3>
          <div class="card-tools">
          </div>
        </div>
        <div class="card-body">
          <!--  Contenedor de listados   -->  
          <div class="panel-body  table-responsive " id="listadoregdata">
              <table id="tblistadoregdata" class="table table-striped display table-bordered table-condensed table-over nowrap" style="width:100%"> 
                  <thead> 
                    <tr>
                      <th>Opciones</th>
                      <th>Descripción</th> 
                      <th>Fecha de creación</th>
                      <th>Fecha de actualización</th>
                      <th>Status</th>
                      <th>Empleado modifico</th> 
                    </tr>
                  </thead>
                  <tbody> 
                    <tr>                      
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Opciones</th> 
                      <th>Descripción</th>
                      <th>Fecha de creación</th>
                      <th>Fecha de actualización</th>
                      <th>Status</th>
                      <th>Empleado modifico</th>
                    </tr> 
                  </tfoot>
              </table> 
          </div>
          <!--  Contenedor de formuluario --> 
          <div class="panel-body" id="formregdata">
            <form name="formulario" id="formulario" method="post">
              <div class="form-group col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <label for="descripcion">Nombre de la categoria:</label>
                <input type="hidden" name="idCategoria" id="idCategoria">
                <input type="text" name="descripcion" id="descripcion" maxlength="256" placeholder="Nombre categoria" required>
              </div>
              <div class="form-group col-xl-6 col-lg-6 col-md-12 col-sm-12">
              <!--  <button class="btn btn-primary" id="btnGuardar" type="submit">Guardar</button>
                <button class="btn btn-danger" id="btnCancelar" type="reset">Cancelar</button> -->
                 <button class="btn btn-primary" id="btnGuardar" type="submit"><i class="fas fa-save"></i>Guardar</button>
                <button class="btn btn-danger" id="btnCancelar" type="clear" onclick="cancelarform(true);"><i class="fas fa-arrow-circle-left"></i>Cancelar</button>  
              </div>
            </form>
          </div>
        </div>
        <!-- /.card-body -->

      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<!--al Final -->

<?php 
require 'piepagina.php';
?>


<script type="text/javascript" src="scripts/categoria.js"></script>