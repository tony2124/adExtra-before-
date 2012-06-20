<?php if($promotores==NULL) { ?>
<div class="alert alert-error">
  <!--<a class="close" data-dismiss="alert" href="#">×</a>-->
  <p>No se encuentra ningún promotor registrado, por favor vaya al apartado promotores para registrar uno.</p>
  <a href="<?php print get('webURL'). _sh . 'admin/registroPromotor' ?>" class="">Registrar promotor</a>
</div>
<?php return; } ?>

<script>
function promotor(usuario, name)
{
   $('#nombre_promotor').html(name);
   $('#usuario_promotor').val(usuario);
}
</script>
   <div class="btn-group">
    <a class="btn dropdown-toggle btn-primary" data-toggle="dropdown" href="#">
      OPCIONES
      <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
      <li>
        <a href="<?php print get('webURL'). _sh .'admin/adminconfig/' ?>">
          <b class="icon-envelope"></b> Enviar email a todos</a></li>
      <li class="divider"></li>
      <li>
        <a href="<?php print get('webURL') .  _sh .'admin/logout' ?>">
          <b class="icon-ban-circle"></b> Bloquear acceso a todos
        </a>
      </li>
    </ul>
  </div>
  <hr>
<table class="table table-striped table-condensed">
  <thead>
    <tr>
      <th>Usuario</th>
      <th>Contr.</th>
      <th>Nombre</th>
      <th>Club</th>
      <th>Sex</th>
      <th>Correo electrónico</th>
      <th>Edad</th>
      <th>Ocupación</th>
      <th>Dirección</th>
      <th>Acción</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($promotores as $promotor) { ?>
      <tr>
        <td><?php print $promotor['usuario_promotor']?></td>
        <td  align="center"><a href="#" rel="tooltip" title="<?php print $promotor['contrasena_promotor']?>">Ver</a> </td>
        <td><?php print $promotor['apellido_paterno_promotor'].' '.$promotor['apellido_materno_promotor'].' '.$promotor['nombre_promotor'] ?></td>
        <td><?php print $promotor['nombre_club'] ?></td>
        <td><?php print ($promotor['sexo_promotor'] == 1) ? 'H' : 'M' ?></td>
        <td><?php print $promotor['correo_electronico_promotor'] ?></td>
        <td><?php print edad($promotor['fecha_nacimiento_promotor']) ?></td>
        <td><?php print $promotor['ocupacion_promotor']?></td>
        <td><?php print $promotor['direccion_promotor'].' Teléfono: '.$promotor['telefono_promotor'] ?></td>
        <td>
          <a rel="tooltip" title="Editar" href="<?php print get('webURL'). _sh . 'admin/formEdicionPromotor/'.$promotor['usuario_promotor'] ?>">
            <i class="icon-edit"></i>
          </a>
          <a rel="tooltip" title="Eliminar" class="pull-right" onclick="promotor('<?php print $promotor['usuario_promotor'] ?>','<?php print strtoupper($promotor['apellido_paterno_promotor'].' '.$promotor['apellido_materno_promotor'].' '.$promotor['nombre_promotor'])  ?>')" data-toggle="modal" href="#confirmModal">
            <i class="icon-trash"></i>
          </a>
        </td>
      </tr>
    <?php } ?>
    
  </tbody>
</table>

<hr>
<a href="<?php print get('webURL'). _sh . 'admin/formRegistroPromotor' ?>">Agregar un nuevo promotor</a>

<div class="modal hide fade" id="confirmModal">
  <div class="modal-header">
    <button class="close" data-dismiss="modal">×</button>
    <h3>Confirmación</h3>
  </div>
  <div class="modal-body">
    <p>¿Está seguro que desea eliminar a <span class="label label-important" id="nombre_promotor"></span> de la lista de promotores?</p>
   
    <form id="elimPromo" method="post" action="<?php print get('webURL')._sh.'admin/elimPromotor' ?>">
      <input name="usuario_promotor" id="usuario_promotor" type="hidden" value="">
    </form> 
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Cancelar</a>
    <a href="#" class="btn btn-danger" onclick="$('#elimPromo').submit()">Eliminar</a>
  </div>
</div>