<?php 
if(!$alumno){
  ?>
  <div class="alert alert-error"><h2>Error</h2>No se ha detectado el número de control de un alumno, por favor introdusca un número de contol para encontrar resultados.</div>
  <?php
  return;
}
?>
<script>
  function modAcreditacion(periodo, actividad, acred, folio)
  {
       $('#periodo').html(periodo); 
       $('#actividad').html(actividad);
       $('#obs').val('');
       $('#folio').val(folio);
       if(acred=='1')
          $("#selectRes > option[value='1']").attr("selected","selected");
       else $("#selectRes > option[value='0']").attr("selected","selected");
  }

  function updateDataInsForm(semestre, periodo)
  {
     $('#periodoIns').val(periodo);
     $('#semestre').val(semestre);
     $('#obsIns').val('');
  }


$().ready(function() {

  // validate signup form on keyup and submit
  $("#editres").validate({
    rules: {
      obs: "required"
    },
    messages: {
      obs: "Debe incluir un comentario para que realice el cambio."
    }
  });

  $("#insActForm").validate({
    rules: {
      obsIns: "required"
    },
    messages: {
      obsIns: "Debe incluir un comentario para que realice el cambio."
    }
  });

   $("#editalumno").validate({
    rules: {
      nombre: "required",
      ap: "required",
      am:  "required",
      email: { required: true, email: true},
      fecha_nac: {required: true, date: true},
      se: { required: true, digits: true, maxlength: 1},
      clave: { minlength: 6, maxlength: 15}
    },
    messages: {
      nombre: "Este campo es obligatorio",
      ap: "Este campo es obligatorio",
      am: "Este campo es obligatorio",
      email: { required: "Este campo es obligatorio", minlength: "Ingrese un correo electrónico válido"},
      fecha_nac: { required: "Este campo es obligatorio", date: "Ingrese una fecha válida en el formato aaaa-mm-dd"},
      se: { required: "Este campo es obligatorio", digits: "Solo se aceptan números", maxlength: "Ingrese no más de 1 dígito."},
      clave: { minlength: "Ingrese más caracteres", maxlength: "Ingrese menos caracteres"}

    }
  });

  // propose username by combining first- and lastname
 
});

</script>

<style type="text/css">
  label.error { color: red;}
</style>

<div class="well"><h4>A continuación se muestra los datos del alumno seleccionado.</h4></div>
<a rel="tooltip" title="Modificar datos del alumno" data-toggle="modal" href="#miModal" class="pull-right">
  <i class="icon-cog"></i> Editar
</a>
<table class="table table-striped table-condensed">
  <thead>
    <tr>
      <th></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
      <tr>
        <td>Número de control</td>
        <td><?php print $alumno['numero_control'] ?></td>
      </tr>
      <tr>
        <td>Nombre</td>
        <td><?php print $alumno['nombre_alumno'] ?></td>
      </tr>
       <tr>
        <td>Apellido paterno</td>
        <td><?php print $alumno['apellido_paterno_alumno'] ?></td>
      </tr>
       <tr>
        <td>Apellido materno</td>
        <td><?php print $alumno['apellido_materno_alumno'] ?></td>
      </tr>
      <tr>
        <td>Carrera</td>
        <td><?php print $alumno['nombre_carrera'] ?></td>
      </tr>
      <tr>
        <td>Semestre</td>
        <td><?php print (semestre( $alumno['fecha_inscripcion']) > 12) ? 'NO DISP.' : semestre( $alumno['fecha_inscripcion']) ?></td>
      </tr>
      <tr>
        <td>Edad</td>
        <td><?php print edad($alumno['fecha_nacimiento']) ?></td>
      </tr>
      <tr> 
        <td>Sexo</td>
        <td><?php print ($alumno['sexo']==1) ? 'HOMBRE' : 'MUJER' ?></td>
      </tr>
      <tr>
        <td>Correo electrónico</td>
        <td><?php print $alumno['correo_electronico'] ?></td>
      </tr>
      <tr>
        <td>Situación escolar (SE)</td>
        <td><?php print $alumno['situacion_escolar'] ?></td>
      </tr>
      <tr>
        <td>Clave del sitio</td>
        <td><?php print $alumno['clave'] ?></td>
      </tr>
  </tbody>
</table>

<h2>Historial de liberación de horas extraescolares</h2>
<hr>
<p>A continuación se muestra todos los clubes y actividades que ha realizado <span class="label label-primary"><?php print $nombreAlumno ?> </span>.</p>
<hr><!--
<?php // if($inscripciones == NULL) { ?>
 <div class="alert"><h2>Advertencia</h2>Este alumno no se ha inscrito en ninguna actividad.</div>
<?php //}else{ ?> -->
<div class="tabbable tabs-left"> 
  <ul class="nav nav-tabs">
    <?php $i=0; 
    foreach ($periodos as $periodo) 
    { 
        $liberado = false;
        if($inscripciones!=NULL)
        foreach ($inscripciones as $ins) 
        {
          if($ins['periodo'] == $periodo && $ins['acreditado'] == 1)
          {
              $liberado = true; break;
          }
            
        }
      ?>
    <li class="<?php print ($i==0) ? 'active' : NULL; $i++; ?>">
      <a href="#tab<?php print $i ?>" data-toggle="tab">
        <span class="label label-<?php print ($liberado) ? 'success' : 'important' ?>"><?php print $periodo ?></span>
      </a>
    </li>
    <?php 
  } ?>
  </ul>
  
  <div class="tab-content">
    <?php $i=0; foreach ($periodos as $periodo) 
    { ?>
    
    <div class="tab-pane <?php print ($i==0) ? 'active' : NULL; $i++; ?>" id="tab<?php print $i ?>">
      <table class="table table-striped table-condensed">
        <thead>
        <th>fecha insc.</th>
        <th>fecha lib.</th>
        <th>Actividad</th>
        <th>Resultado</th>
        <th>Obser.</th>
        <th></th></thead>
        <tbody>
            <?php
            $band = false;
            if($inscripciones!=NULL)
            foreach ($inscripciones as $ins) 
            {
              if($ins['periodo'] == $periodo)
              { 
                $band = true;
                ?>
              <tr>
                <td><?php print $ins['fecha_inscripcion_club'] ?></td>
                <td><?php print $ins['fecha_liberacion_club'] ?></td>
                <td><?php print $ins['nombre_club'] ?></td>
                <td>
                  <a data-toggle="modal" onclick="modAcreditacion(<?php print "'".$periodo."','".$ins['nombre_club']."','".$ins['acreditado']."','".$ins['folio']."'" ?>)" href="#cambiarAcreditado">
                    <?php print ($ins['acreditado']==1) ? 'ACREDITADO' : 'NO ACREDITADO' ?>
                  </a>
                </td>
                <td>
                  <?php if($ins['observaciones']!=NULL) { ?>
                  <a href="#" rel="popover" data-content="<?php print $ins['observaciones'] ?>" data-original-title="Observación">ver</a><?php } ?></td>
                <td>
                  <a href="<?php print get('webURL')._sh.'admin/pdf/formatos/liberacion/'.$ins['folio'] ?>" target="_blank" title="Descargar formato de liberación de horas" rel="tooltip" class="btn">Formato</a>
                </td>
              </tr>
                <?php
              }
              
            }
            if(!$band) 
              print '<tr><td colspan="6">No se encuentra inscrito en ningún club ó actividad</td></tr>';
            ?>
        </tbody>
      </table>
      <a rel="tooltip" title="Inscribir a una actividad" onclick="updateDataInsForm(<?php print $i.",'".$periodo."'" ?>)" class="pull-right btn btn-success" data-toggle="modal" href="#insActDialog" >
        <i class="icon-pencil icon-white"></i>
      </a>
    </div>
  
    <?php } ?>
  </div>
</div>
<!--<?php // } ?> -->

<div class="modal hide fade" id="cambiarAcreditado">
  <div class="modal-header">
    <button class="close" data-dismiss="modal">×</button>
    <h3>Edición de acreditación </h3>
  </div>
  <div class="modal-body">
    <p>En el siguiente formulario se cambiará la acreditación.</p>
   
    <form id="editres" class="form-horizontal" method="post" action="<?php print get('webURL')._sh.'admin/editResultado' ?>">
    <div class="control-group">
        <label class="control-label">Actividad</label> 
      <div class="controls">
            <span id="actividad" type="text" class="uneditable-input"></span>
      </div><br>
      <label class="control-label">Periodo</label> 
      <div class="controls">
          <span id="periodo" type="text" class="uneditable-input"></span>
      </div><br>
      <label class="control-label">Resultado</label> 
      <div class="controls">
          <select name="acreditado" id="selectRes">
              <option value="1">ACREDITADO</option>
              <option value="0">NO ACREDITADO</option>
          </select>
      </div><br>
      <label class="control-label">Observación</label> 
      <div class="controls">
          <textarea name="obs" id="obs"></textarea>
      </div><br>
      <input type="hidden" value="" id ="folio" name="folio">
      <input type="hidden" value="<?php print $alumno['numero_control'] ?>" name="numero_control">
    </div>
</form> 
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Cerrar</a>
    <a href="#" class="btn btn-primary" onclick="$('#editres').submit()">Guardar cambios</a>
  </div>
</div>

<div class="modal hide fade" id="insActDialog">
  <div class="modal-header">
    <button class="close" data-dismiss="modal">×</button>
    <h3>Inscripción a una actividad</h3>
  </div>
  <div class="modal-body">
    <p>Complete el siguiente formulario para inscribir a este alumno a una actividad.</p>
   
    <form id="insActForm" class="form-horizontal" method="post" action="<?php print get('webURL')._sh.'admin/inscipcionActividad' ?>">
    <div class="control-group">
        <label class="control-label">Actividad</label> 
      <div class="controls">
             <select name="actividad">
                <?php foreach ($clubes as $club) { if($club['tipo_club'] != 1 && $club['tipo_club'] != 2) { ?>
                <option value="<?php print $club['id_club'] ?>"><?php print $club['nombre_club'] ?></option>
              <?php } } ?>
          </select>
      </div><br>
      <label class="control-label">Resultado</label> 
      <div class="controls">
          <select name="acreditado" id="selectRes">
              <option value="1">ACREDITADO</option>
              <option value="0">NO ACREDITADO</option>
          </select>
      </div><br>
      <label class="control-label">Observación</label> 
      <div class="controls">
          <textarea name="obsIns" id="obsIns"></textarea>
      </div><br>
      <input type="hidden" value="" id ="periodoIns" name="periodo">
      <input type="hidden" value="" id ="semestre" name="semestre">
      <input type="hidden" value="<?php print $alumno['numero_control'] ?>" name="numero_control">
    </div>
</form> 
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Cerrar</a>
    <a href="#" class="btn btn-primary" onclick="$('#insActForm').submit()">Guardar cambios</a>
  </div>
</div>

<div class="modal hide fade" id="miModal">
  <div class="modal-header">
    <button class="close" data-dismiss="modal">×</button>
    <h3>Edición de datos del alumno&nbsp;&nbsp;&nbsp;&nbsp;<a rel="tooltip" title="Actualizar" href="<?php print get('webURL'). _sh . 'admin/alumno/'.$alumno['numero_control'] ?>"><i class="icon-refresh"></i></a></h3>
  </div>
  <div class="modal-body">
    <p>En el siguiente formulario se muestran los datos del alumno, por favor edite el campo correspondiente y haga clic en guardar cambios.</p>
    <form id="editalumno" class="form-horizontal" method="POST" action="<?php print get('webURL')._sh.'admin/editalumno/' ?>">
    <div class="control-group">
      <label class="control-label" for="nombre">Nombre</label>
      <div class="controls">
  <!-- -->  <input type="text" name="nombre" class="input-xlarge" id="nombre" value="<?php print $alumno['nombre_alumno'] ?>">
      </div><br>
      <label class="control-label" for="ap">Apellido paterno</label>
      <div class="controls">
  <!-- -->  <input type="text" name="ap" class="input-xlarge" id="ap" value="<?php print $alumno['apellido_paterno_alumno'] ?>">
      </div><br>
      <label class="control-label" for="am">Apellido materno</label>
      <div class="controls">
  <!-- -->  <input type="text" name="am" class="input-xlarge" id="am"  value="<?php print $alumno['apellido_materno_alumno'] ?>">
      </div><br>
      <label class="control-label" for="fecha_nac">Fecha de nacimiento</label>
      <div class="controls">
  <!-- -->  <input type="text" name="fecha_nac" class="input-xlarge" id="fecha_nac"  value="<?php print $alumno['fecha_nacimiento'] ?>">
      </div><br>
      <label class="control-label" for="sexo">Sexo</label>
      <div class="controls">
  <!-- -->  <select name="sexo" id="sexo">
              <option value="1">HOMBRE</option>
              <option value="2" <?php if($alumno['sexo']!=1) print 'selected="selected"' ?>>MUJER</option>
            </select>
      </div><br>
      <label class="control-label" for="email">Correo electrónico</label>
      <div class="controls">
  <!-- -->  <input type="text" name="email" class="input-xlarge" id="email"  value="<?php print $alumno['correo_electronico'] ?>">
      </div><br>
      <label class="control-label" for="se">Situación escolar</label>
      <div class="controls">
  <!-- -->  <input type="text" name="se" class="input-xlarge" id="se"  value="<?php print $alumno['situacion_escolar'] ?>">
      </div><br>
      <label class="control-label" for="clave">Clave del sitio</label>
      <div class="controls">
  <!-- -->  <input type="text" name="clave" class="input-xlarge" id="clave"  value="<?php print $alumno['clave'] ?>">
      </div>
      <input type="hidden" name="numero_control" value="<?php print $alumno['numero_control'] ?>"> 

    </div>
</form> 
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Cerrar</a>
    <button class="btn btn-primary" onclick="$('#editalumno').submit()">Guardar cambios</button>
  </div>
</div>

