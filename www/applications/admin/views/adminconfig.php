<h2>Los datos del administrador </h2>
<hr>
<?php if(!$datosAdmin) { ?>
<div class="alert alert-block alert-error fade in">
<button class="close" data-dismiss="alert">×</button>
  <h3>Ups no se ha encontrado datos</h3>
  <p>Este error se debe a que el ID del administrador no existe</p>
  
</div>
<?php }else{ ?>
<table class="table table-striped table-bordered table-condensed">
  <thead>
    <th>Descripción</th>
    <th>Valor asociado</th>
    <th>Acción</th>
  </thead>
  <tbody>
    <tr>
      <td width="200">Usuario</td>
      <td><?php print $datosAdmin[0]['usuario_administrador'] ?></td>
      <td width="100"></td>
    </tr>
    <tr>
      <td width="200">Contraseña</td>
      <td>****** </td>
      <td><a href="#">Editar</a></td>
    </tr>
    <tr>
      <td>Nombre</td>
      <td><?php print $datosAdmin[0]['nombre_administrador'] ?></td>
      <td><a href="#">Editar</a></td>
    </tr>
    <tr>
      <td>Apellido paterno</td>
      <td><?php print $datosAdmin[0]['apellido_paterno_administrador'] ?></td>
      <td><a href="#">Editar</a></td>
    </tr>
    <tr>
      <td>Apellido materno</td>
      <td><?php print $datosAdmin[0]['apellido_materno_administrador'] ?></td>
      <td><a href="#">Editar</a></td>
    </tr>
    <tr>
      <td>Profesión</td>
      <td><?php print $datosAdmin[0]['profesion_administrador'] ?></td>
      <td><a href="#">Editar</a></td>
    </tr>
    <tr>
      <td>Abreviatura de la profesión</td>
      <td><?php print $datosAdmin[0]['abreviatura_profesion'] ?></td>
      <td><a href="#">Editar</a></td>
    </tr>
    <tr>
      <td>Correo electrónico</td>
      <td><?php print $datosAdmin[0]['correo_electronico'] ?></td>
      <td><a href="#">Editar</a></td>
    </tr>
    <tr>
      <td>Dirección</td>
      <td><?php print $datosAdmin[0]['direccion_administrador'] ?></td>
      <td><a href="#">Editar</a></td>
    </tr>
    <tr>
      <td>Estado</td>
      <td><span class="label <?php print  ($datosAdmin[0]['actual']==1) ? 'label-success' : 'label-important'  ?> ?>"><?php print  ($datosAdmin[0]['actual']==1) ? 'VIGENTE' : 'NO VIGENTE'  ?></span></td>
      <td>
        <?php if($datosAdmin[0]['actual']==1) { ?> 
          <a href="#" class="btn btn-danger" rel="popover" data-content="Cambia el estado de este administrador a NO VIGENTE" data-original-title="CAMBIAR A NO VIGENTE">NO VIGENTE</a>
        <?php }else{ ?>
          <a href="#" class="btn btn-success" rel="popover" data-content="Cambia el estado de este administrador a VIGENTE" data-original-title="CAMBIAR A VIGENTE">VIGENTE</a>
        <?php } ?>
      </td>
    </tr>

  </tbody>
</table>

<hr>
<?php } ?>

<h2>Historial de registro de administradores</h2><hr>
<table class="table table-striped ">
  <thead>
    <th>Fecha de registro</th>
    <th>Usuario</th>
    <th>Nombre</th>
    <th>Acción</th>
  </thead>
  <tbody>
    <?php foreach ($allAdmin as $ad) {
    ?>
    <tr>
      <td width="120"><?php print $ad['fecha_registro'] ?></td>
      <td width="200"><?php print $ad['usuario_administrador'] ?></td>
      <td><?php print strtoupper($ad['nombre_administrador'].' '.$ad['apellido_paterno_administrador'].' '.$ad['apellido_materno_administrador']) ?></td>
      <td width="50"><a class="btn btn-primary" href="<?php print get('webURL') . _sh . 'admin/adminconfig/'.$ad['id_administrador'] ?>">Ver</a></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
<h2>Registro de un nuevo administrador</h2><hr>
