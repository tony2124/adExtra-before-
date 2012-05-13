<?php 
if(!$alumno){
  ?>
  <div class="alert alert-error"><h2>Error</h2>No se ha detectado el número de control de un alumno, por favor introdusca un número de contol para encontrar resultados.</div>
  <?php
  return;
}
?>

<div class="well"><h4>A continuación se muestra los datos del alumno seleccionado.</h4></div>
<a data-toggle="modal" href="#myModal" class="pull-right"><i class="icon-cog"></i></a>
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
        <td><?php print ($alumno['situacion_escolar'] == 1) ? semestre( $alumno['fecha_inscripcion']) : 'NO DISP.' ?></td>
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
<hr>

<div class="tabbable tabs-left"> 
  <ul class="nav nav-tabs">
    <?php $i=0; foreach ($periodos as $periodo) { 
        $liberado = false;
        foreach ($inscripciones as $ins) {
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
    <?php } ?>
  </ul>
  <div class="tab-content">
    <?php $i=0; foreach ($periodos as $periodo) { ?>
    
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
            foreach ($inscripciones as $ins) {
              if($ins['periodo'] == $periodo)
              { ?>
              <tr>
                <td><?php print $ins['fecha_inscripcion_club'] ?></td>
                <td><?php print $ins['fecha_liberacion_club'] ?></td>
                <td><?php print $ins['nombre_club'] ?></td>
                <td><?php print ($ins['acreditado']==1) ? '<span class="label label-success">ACREDITADO</span>' : '<span class="label label-important">NO ACREDITADO</span>' ?></td>
                <td>
                  <?php if($ins['observaciones']!=NULL) { ?>
                  <a href="#" rel="popover" data-content="<?php print $ins['observaciones'] ?>" data-original-title="Observación">ver</a><?php } ?></td>
                <td><a href="" class="btn">Formato</a></td>
              </tr>
                <?php
              }
                
            }
            ?>
        </tbody>
      </table>
  
    </div>
  
    <?php } ?>
    
  </div>
</div> 

<div class="modal hide fade" id="myModal">
  <div class="modal-header">
    <button class="close" data-dismiss="modal">×</button>
    <h3>Edición de datos del alumno </h3>
  </div>
  <div class="modal-body">
    <p>En el siguiente formulario se muestran los datos del alumno, por favor edite el campo correspondiente y haga clic en guardar cambios.</p>
    <form id="editalumno" class="form-horizontal" method="post" action="<?php print get('webURL')._sh.'admin/editalumno' ?>">
    <div class="control-group">
      <label class="control-label" for="input01">Nombre</label>
      <div class="controls">
        <input type="text" name="Nombre" class="input-xlarge" id="input01">
      </div><br>
      <label class="control-label" for="input02">Apellido paterno</label>
      <div class="controls">
        <input type="text" name="contrasena" class="input-xlarge" id="input02">
      </div><br>
      <label class="control-label" for="input03">Apellido materno</label>
      <div class="controls">
        <input type="text" name="nombre" class="input-xlarge" id="input03">
      </div><br>
      <label class="control-label" for="input04">Fecha de nacimiento</label>
      <div class="controls">
        <input type="text" name="ap" class="input-xlarge" id="input04">
      </div><br>
      <label class="control-label" for="input05">Sexo</label>
      <div class="controls">
        <input type="text" name="am" class="input-xlarge" id="input05">
      </div><br>
      <label class="control-label" for="input06">Correo electrónico</label>
      <div class="controls">
        <input type="text" name="email" class="input-xlarge" id="input06">
      </div><br>
      <label class="control-label" for="input07">Situación escolar</label>
      <div class="controls">
        <input type="text" name="direccion" class="input-xlarge" id="input07">
      </div><br>
      <label class="control-label" for="input08">Clave del sitio</label>
      <div class="controls">
        <input type="text" name="prof" class="input-xlarge" id="input08">
      </div>
    </div>
</form> 
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Cerrar</a>
    <a href="#" class="btn btn-primary" onclick="$('#editalumno').submit()">Guardar cambios</a>
  </div>
</div>

