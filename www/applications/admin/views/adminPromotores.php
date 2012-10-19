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
   <div class="btn-group ">
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
  <form class="well span2 pull-right" style="text-align: center" method="post" action="<?php print get('webURL')._sh."admin/buscar_promotor" ?>">
    <label><i class="icon-search"></i>&nbsp;Búsqueda </label>
    <input type="text" name="nombre" class="input-small">
    <input type="submit" value="Buscar" class="btn btn-primary">
  </form>
  <hr>
<?php foreach ($promotores as $promotor) { ?>
<table class="table table-striped table-condensed">
  <thead>
    <tr>
      <th>Foto</th>
      <th>Datos</th>
    </tr>
  </thead>
  <tbody>
      
      <tr>
        <td width="200" rowspan="11">
          <img src="http://localhost/dropbox/extraescolares/IMAGENES/cargando/logo.png" width="200" >
        </td>
      </tr>
      <tr>
        <td width="200">USUARIO</td>
        <td><?php print $promotor['usuario_promotor']?></td>
      </tr>
      <tr>
        <td>CONTRASEÑA</td>
        <td  align="center"><a href="#" rel="tooltip" title="<?php print $promotor['contrasena_promotor']?>">Ver</a> </td>
        </tr>
      <tr>
         <td>NOMBRE</td>
        <td><?php print $promotor['apellido_paterno_promotor'].' '.$promotor['apellido_materno_promotor'].' '.$promotor['nombre_promotor'] ?></td>
        </tr>
      <tr>
         <td>CLUB</td>
        <td><?php print $promotor['nombre_club'] ?></td>
        </tr>
      <tr>
         <td>SEXO</td>
        <td><?php print ($promotor['sexo_promotor'] == 1) ? 'HOMBRE' : 'MUJER' ?></td>
        </tr>
      <tr>
         <td>CORREO ELECTRÓNICO</td>
        <td><?php print $promotor['correo_electronico_promotor'] ?></td>
        </tr>
      <tr>
         <td>FECHA DE NACIMIENTO</td>
        <td><?php print edad($promotor['fecha_nacimiento_promotor']) ?></td>
        </tr>
      <tr>
         <td>OCUPACIÓN</td>
        <td><?php print $promotor['ocupacion_promotor']?></td>
        </tr>
      <tr>
         <td>DIRECCIÓN</td>
        <td><?php print $promotor['direccion_promotor'].' Teléfono: '.$promotor['telefono_promotor'] ?></td>
        </tr>
      <tr>
         <td>ACCIÓN</td>
        <td>
          <a rel="tooltip" title="Editar" class="pull-right" href="<?php print get('webURL'). _sh . 'admin/formEdicionPromotor/'.$promotor['usuario_promotor'] ?>">
            <i class="icon-edit"></i>
          </a>
          <a rel="tooltip" title="Eliminar" class="pull-right" onclick="promotor('<?php print $promotor['usuario_promotor'] ?>','<?php print strtoupper($promotor['apellido_paterno_promotor'].' '.$promotor['apellido_materno_promotor'].' '.$promotor['nombre_promotor'])  ?>')" data-toggle="modal" href="#confirmModal">
            <i class="icon-trash"></i>
          </a>

        </td>
      </tr>
  </tbody>
</table>
<hr>
 <?php } ?>

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