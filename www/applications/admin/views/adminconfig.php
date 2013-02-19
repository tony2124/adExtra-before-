<h2>Los datos del administrador </h2>
<hr>
<?php if(!$datosAdmin) { ?>
<div class="alert alert-block alert-error fade in">
<button class="close" data-dismiss="alert">×</button>
  <h3>Ups no se ha encontrado datos</h3>
  <p>Este error se debe a que el ID del administrador no existe</p>
  
</div>
<?php } else 
{ if (isset($errorEstado) && $errorEstado == true) { ?>
<div class="alert alert-block alert-error fade in">
<button class="close" data-dismiss="alert">×</button>
  <h3>No se puede ausentar</h3>
  <p>Por lo menos debe de estar un administrador activo, asigna vigente a otro administrador y podrá ausentarse</p>
  
</div>
<?php } if(isset($adminUpdate)) { $textos = explode(":",$adminUpdate);?>
<div class="alert alert-block alert-error fade in">
<button class="close" data-dismiss="alert">×</button>
  <h3><?php print $textos[0];?></h3>
  <p><?php print $textos[1];?></p>
</div>
<?php } ?>

<a rel="tooltip" title="Modificar datos del administrador" data-toggle="modal" href="#modalEditarAdmin" class="pull-right"><i class="icon-cog"></i></a>
<table class="table table-striped table-bordered table-condensed">
  <!-- <thead>
    <th>Descripción</th>
    <th>Valor asociado</th>
  </thead> -->
  <tbody>
    <tr>
      <td width="200">Usuario</td>
      <td><?php print $datosAdmin[0]['usuario_administrador'] ?></td>
    </tr>
    <tr>
      <td width="200">Contraseña</td>
      <td>****** </td>
    </tr>
    <tr>
      <td>Nombre</td>
      <td><?php print $datosAdmin[0]['nombre_administrador'] ?></td>
    </tr>
    <tr>
      <td>Apellido paterno</td>
      <td><?php print $datosAdmin[0]['apellido_paterno_administrador'] ?></td>
    </tr>
    <tr>
      <td>Apellido materno</td>
      <td><?php print $datosAdmin[0]['apellido_materno_administrador'] ?></td>
    </tr>
    <tr>
      <td>Profesión</td>
      <td><?php print $datosAdmin[0]['profesion_administrador'] ?></td>
    </tr>
    <tr>
      <td>Abreviatura de la profesión</td>
      <td><?php print $datosAdmin[0]['abreviatura_profesion'] ?></td>
    </tr>
    <tr>
      <td>Correo electrónico</td>
      <td><?php print $datosAdmin[0]['correo_electronico'] ?></td>
    </tr>
    <tr>
      <td>Dirección</td>
      <td><?php print $datosAdmin[0]['direccion_administrador'] ?></td>
    </tr>
    <tr>
      <td>Estado</td>
      <td><span class="label <?php print  ($datosAdmin[0]['actual']==1) ? 'label-success' : 'label-important'  ?> ?>"><?php print  ($datosAdmin[0]['actual']==1) ? 'VIGENTE' : 'NO VIGENTE'  ?></span>
        <?php if($datosAdmin[0]['actual']==1) { ?> 
          <a href="<?php print get('webURL')._sh.'admin/cambiarEstado/noVigente'?>" class="btn btn-danger pull-right" rel="popover" data-content="Cambia el estado de este administrador a NO VIGENTE" data-original-title="CAMBIAR A NO VIGENTE"><i class="icon-ban-circle icon-white"></i></a>
        <?php }else{ ?>
          <a href="<?php print get('webURL')._sh.'admin/cambiarEstado/Vigente'?>" class="btn btn-success  pull-right" rel="popover" data-content="Cambia el estado de este administrador a VIGENTE" data-original-title="CAMBIAR A VIGENTE"><i class="icon-ok icon-white"></i></a>
        <?php } ?>
      </td>
    </tr>
  </tbody>
</table>

<hr>
<?php } ?>

<h2>Registro de administradores</h2><hr>
<table>
  <thead align="left">
    <th>Fecha de registro</th>
    <th>Usuario</th>
    <th>Administrador</th>
    <th>Vigente</th>
  </thead>
  <tbody>
    <?php $cI = 0; foreach ($allAdmin as $ad) { ?>
    <tr>
      <td width="120"><?php print $ad['fecha_registro'] ?></td>
      <td width="200"><?php print $ad['usuario_administrador'] ?></td>
      <td width="470"><?php print strtoupper($ad['abreviatura_profesion'].'. '.$ad['nombre_administrador'].' '.$ad['apellido_paterno_administrador'].' '.$ad['apellido_materno_administrador']) ?></td>
      <td class="pull-right">
        <div class="btn-group" data-toggle="buttons-radio">
          <a <?php if($ad['actual'] == 1) print "class='btn btn-success active'";else print "href='".get('webURL')._sh.'admin/cambiarEstado/Vigente/'.$ad['usuario_administrador']."' class='btn'";?>><i class="icon-ok"></i></a>
          <a <?php if($ad['actual'] == 0) print "class='btn btn-danger active'";else print "href='".get('webURL')._sh.'admin/cambiarEstado/noVigente/'.$ad['usuario_administrador']."' class='btn'";?>><i class="icon-remove"></i></a>
        </div>
        <!--<a class="btn" data-toggle="collapse" href="#showAdmin_1"><i class="icon-chevron-down"></i></a>-->
      </td>
    </tr>
    <tr>
      <td colspan="4" data-toggle="collapse" href="#showAdmin_<?php print $cI;?>">
        <a class="icon-chevron-down pull-right" rel="tooltip" title="Mostrar datos"></a>
      </td>
    </tr>
    <tr>
      <td colspan="4">
        <div id="showAdmin_<?php print $cI;?>" class="collapse out">
          <table class="table table-striped">
            <tbody>
              <tr>
                <th width="200">Nombre</th>
                <td><?php print $ad['nombre_administrador'] ?></td>
              </tr>
              <tr>
                <th>Apellido paterno</th>
                <td><?php print $ad['apellido_paterno_administrador'] ?></td>
              </tr>
              <tr>
                <th>Apellido materno</th>
                <td><?php print $ad['apellido_materno_administrador'] ?></td>
              </tr> 
              <tr>
                <th>Profesión</th>
                <td><?php print $ad['profesion_administrador'] ?></td>
              </tr>
              <tr>
                <th>Abreviatura de la profesión</th>
                <td><?php print $ad['abreviatura_profesion'] ?></td>
              </tr>
              <tr>
                <th>Correo electrónico</th>
                <td><?php print $ad['correo_electronico'] ?></td>
              </tr>
              <tr>
                <th>Dirección</th>
                <td><?php print $ad['direccion_administrador'] ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </td>
    </tr>
    <?php $cI++; } ?>
  </tbody>
</table>

<div class="modal hide fade" id="modalEditarAdmin">
  <div class="modal-header">
    <button class="close" data-dismiss="modal">×</button>
    <h3>Edición de datos del administrador</h3>
  </div>
  <div class="modal-body">
    <p>En el siguiente formulario se muestran los datos del administrador, por favor edite los campos correspondientes y haga clic en guardar cambios.</p>
    <form id="editarAdmin" class="form-horizontal" method="POST" action="<?php print get('webURL')._sh.'admin/editaAdmin' ?>">
      <div class="control-group">
        <label class="control-label" for="input01">Usuario</label>
        <div class="controls">
    <!-- -->  <input type="text" name="usuario" disabled class="input-xlarge" id="input01" value="<?php print $datosAdmin[0]['usuario_administrador'] ?>">
        </div><br>
        <label class="control-label" for="input02">Contraseña <a rel="popover" data-content="Actual: Ingresa la vieja contraseña <br> Nueva: Ingresa una nueva contraseña <br> Re-nueva: Vuelve a ingresar la nueva contraseña" data-original-title="AYUDA"><i class="icon-exclamation-sign"></i></a></label>
        <div class="controls">
    <!-- -->  <input type="password" name="lastpass" class="input-xlarge" id="input02" placeholder="Actual">
        </div>
        <div class="controls">
    <!-- -->  <input type="password" name="newpass1" class="input-xlarge" id="input02" placeholder="Nueva">
        </div>
        <div class="controls">
    <!-- -->  <input type="password" name="newpass2" class="input-xlarge" id="input02" placeholder="Re-nueva">
        </div><hr>
        <label class="control-label" for="input03">Nombre(s)</label>
        <div class="controls">
    <!-- -->  <input type="text" name="nombre" class="input-xlarge" id="input03"  value="<?php print $datosAdmin[0]['nombre_administrador'] ?>">
        </div><br>
        <label class="control-label" for="input04">Apellido paterno</label>
        <div class="controls">
    <!-- -->  <input type="text" required name="adminAP" class="input-xlarge" id="input04"  value="<?php print $datosAdmin[0]['apellido_paterno_administrador'] ?>">
        </div><br>
        <label class="control-label" for="input04">Apellido materno</label>
        <div class="controls">
    <!-- -->  <input type="text" name="adminAM" class="input-xlarge" id="input04"  value="<?php print $datosAdmin[0]['apellido_materno_administrador'] ?>">
        </div><br>
        <label class="control-label" for="input06">Correo electrónico</label>
        <div class="controls">
    <!-- -->  <input type="email" name="email" class="input-xlarge" id="input06"  value="<?php print $datosAdmin[0]['correo_electronico'] ?>" required>
        </div><hr>
        <label class="control-label" for="input07">Profesión</label>
        <div class="controls">
    <!-- -->  <input type="text" name="profe" class="input-xlarge" id="input07"  value="<?php print $datosAdmin[0]['profesion_administrador'] ?>">
        </div><br>
        <label class="control-label" for="input08">Abreviatura de la profesión</label>
        <div class="controls">
    <!-- -->  <input type="text" name="abrevi" class="input-xlarge" id="input08"  value="<?php print $datosAdmin[0]['abreviatura_profesion'] ?>">
        </div><br>
        <label class="control-label" for="input08">Dirección</label>
        <div class="controls">
    <!-- -->  <input type="text" name="direc" class="input-xlarge" id="input09"  value="<?php print $datosAdmin[0]['direccion_administrador'] ?>">
        </div>
      </div>
  </div>
  <div class="modal-footer">
      <a class="btn" data-dismiss="modal">Cerrar</a>
      <input type="submit" value="Guardar cambios" name="guardarCambios" class="btn btn-primary" id="guardarCambios">
    </form>
  </div>
</div>