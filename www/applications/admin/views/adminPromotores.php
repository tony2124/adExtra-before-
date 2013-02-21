<script>
function promotor(usuario, name)
{
   $('#nombre_promotor').html(name);
   $('#usuario_promotor').val(usuario);
}

function guardar(posicion)
{
    var request = $.ajax({
      type: "POST",
      url: "<?php print get('webURL')._sh.'admin/guardarHorario/'.$periodo ?>",
      data: { club: $('#club'+posicion).val(), promotor: $('#promotor'+posicion).val(), lugar : $('#lugar'+posicion).val(), horario: $('#horario'+posicion).val() }
      });

    request.done(function( msg ) {
      alert( "Data Saved: "+posicion + $('#promotor'+posicion).val() );
    });

    request.fail(function(jqXHR, textStatus) {
     alert( "Request failed: " + textStatus );
    });
}
</script>

<div >
  <h2>Horarios de los promotores</h2>
  <p>Para el mejor funcionamiento del sistema considere las siguientes recomendaciones:</p>
  <ul>
    <li>No tenga activo a más de un promotor en un club, dé primero de baja el actual y después inscriba al nuevo promotor.</li>
    <li>El usuario y contraseña que estén asignadas son las que utilizará el promotor para iniciar sesión en su apartado: <a href="http://serviciosextraescolares.itsapatzingan.net/loginAdministrador/adExtra/promotor">http://serviciosextraescolares.itsapatzingan.net/loginAdministrador/adExtra/promotor</a></li>
  </ul>
</div>
<!--
   <div class="well span6 pull-right" >
   <div class="btn-group pull-right">
    <a class="btn dropdown-toggle btn-primary pull-right" data-toggle="dropdown" href="#">
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
  <p>Se han encontrado <?php print sizeof($promotores) ?> promotores</p>
  <p><a href="<?php print get('webURL'). _sh . 'admin/formRegistroPromotor' ?>">Agregar un nuevo promotor</a></p>

  </div>
 -->
  <hr>  
  PERIODO
 <select onchange="location.href='<?php print get("webURL").'/admin/promotores/' ?>'+$(this).val()">
  <?php 
    $bandera = false;
    foreach ($periodos as $per ) 
    {
      print "<option  id='".$per."' ";
      if(strcmp($per,$periodo)==0) 
      { 
          print "selected='selected'"; 
          $bandera=true; 
      }
      ?>
      >
      
      <?php print $per . "</option>";
    }

    if($bandera == false)
      print "<option id='".$periodo."' selected='selected'> ".$periodo."</option>";
    
  ?>
</select>
<hr>
<?php if($promotores==NULL) { ?>
<div class="alert alert-error">
  <!--<a class="close" data-dismiss="alert" href="#">×</a>-->
  <p>No se encuentra ningún promotor ASIGNADO en este periodo, por favor asigne los promotores correspondientes a cada club y su horario de participación. Debe tener en cuenta que si es un periodo pasado solo podra hacer esta configuración UNA VEZ, es necesario que cuente con el horario correspondiente al periodo.</p>
  
</div>
 <?php } ?>
<hr>


<table class="table">
  <thead align="left">
    <th>NOMBRE DEL CLUB</th>
    <th>PROMOTOR</th>
    <th>LUGAR</th>
    <th>HORARIO</th>
    <th width="50"></th>
  </thead>
  <tbody>

<?php $cI = 0; foreach ($clubes as $club) {  $b = false; ?>
  
  <tr>
      <td ><?php print $club['nombre_club'] ?><input id="club<?php print $cI ?>" type="hidden" value="<?php print $club['id_club'] ?>" /></td>
     <?php if($promotores != NULL) foreach ($promotores as $promotor) 
      if($club['id_club'] == $promotor['id_club'])
      {
         if(strcmp( $periodo , periodo_actual()) == 0)
         {
      ?>
        <td>
          <select id="promotor<?php print $cI ?>"> 
            <?php foreach ($promotores_actuales as $prom) { ?>
            <option value="<?php print $prom['usuario_promotor'] ?>"  <?php if(strcmp($prom['usuario_promotor'], $promotor['usuario_promotor']) == 0) print "selected='selected'" ?>>
              <?php print strtoupper($prom['nombre_promotor'].' '.$prom['apellido_paterno_promotor'].' '.$prom['apellido_materno_promotor']) ?>
            </option>
            <?php } ?>
          </select>
        </td>
        <td><textarea id="lugar<?php print $cI ?>"><?php print $promotor['lugar'] ?></textarea></td>
        <td><textarea id="horario<?php print $cI ?>"><?php print $promotor['horario'] ?></textarea></td>
        <td><button class="btn" onclick="guardar(<?php print $cI ?>)">Guardar</button></td>
        <?php 
          }
          else
          { ?>

          <td><?php print strtoupper($promotor['nombre_promotor'].' '.$promotor['apellido_paterno_promotor'].' '.$promotor['apellido_materno_promotor']) ?></td>
          <td><?php print $promotor['lugar'] ?></td>
          <td><?php print $promotor['horario'] ?></td>
          <td></td>
          <?php }
        $b = true; 
        break; 

      } 

      if($b == false)
      {  ?>
      <td>
        <select id="promotor<?php print $cI ?>"> 
          <option>Elige un promotor</option>
          <?php foreach ($promotores_actuales as $prom) { ?>
          
          <option value="<?php print $prom['usuario_promotor'] ?>" >
            <?php print strtoupper($prom['nombre_promotor'].' '.$prom['apellido_paterno_promotor'].' '.$prom['apellido_materno_promotor']) ?>
          </option>
          <?php } ?>
        </select>
      </td>
      <td ><textarea id="lugar<?php print $cI ?>"></textarea></td>
      <td ><textarea id="horario<?php print $cI ?>"></textarea></td>
      <td><button class="btn" onclick="guardar(<?php print $cI ?>)">Guardar</button></td>
      <?php }  ?>

    </tr>
    <?php if($b == true)  { ?>
    <tr bgcolor="#eee">
      <td colspan="5" data-toggle="collapse" href="#showAdmin_<?php print $cI;?>">
        <a class="icon-chevron-down pull-right" rel="tooltip" title="Mostrar datos"></a>
      </td>
    </tr>
    <?php } ?>
    <tr>
      <td colspan="5">
        <div id="showAdmin_<?php print $cI;?>" class="collapse out">

          <table class="table table-striped table-condensed">
            <thead>
              <tr>
                <th>Foto</th>
                <th>Datos</th>
              </tr>
            </thead>
            <tbody>
                
                <tr>
                  <td width="200" rowspan="12">
                    <img src="<?php print _rs._sh.'IMAGENES/fotosPromotores/'.$promotor['foto_promotor'] ?>" width="200" >
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
                   <td>LUGAR Y HORARIO</td>
                  <td><?php print $promotor['lugar']." horario:".$promotor['horario'] ?></td>
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
                   <td>EDAD</td>
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
        </div>
      </td>
    </tr>
    <?php $cI++; } ?>
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