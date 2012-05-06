<?php 
if(!$alumno){
  ?>
  <div class="alert alert-error"><h2>Error</h2>No se ha detectado el número de control de un alumno, por favor introdusca un número de contol para encontrar resultados.</div>
  <?php
  return;
}
?>

<div class="well"><h4>A continuación se muestra los datos del alumno seleccionado.</h4></div>
<table class="table table-striped table-condensed">
  <thead>
    <tr>
      <th></th>
      <th></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
      <tr>
        <td>Número de control</td>
        <td><?php print $alumno['numero_control'] ?></td>
        <td><a href="#">Editar</a></td>
      </tr>
      <tr>
        <td>Nombre</td>
        <td><?php print $alumno['nombre_alumno'] ?></td>
        <td><a href="#">Editar</a></td>
      </tr>
       <tr>
        <td>Apellido paterno</td>
        <td><?php print $alumno['apellido_paterno_alumno'] ?></td>
        <td><a href="#">Editar</a></td>
      </tr>
       <tr>
        <td>Apellido materno</td>
        <td><?php print $alumno['apellido_materno_alumno'] ?></td>
        <td><a href="#">Editar</a></td>
      </tr>
      <tr>
        <td>Carrera</td>
        <td><?php print $alumno['nombre_carrera'] ?></td>
        <td><a href="#">Editar</a></td>
      </tr>
      <tr>
        <td>Semestre</td>
        <td><?php print ($alumno['situacion_escolar'] == 1) ? semestre( $alumno['fecha_inscripcion']) : 'NO DISP.' ?></td>
        <td><a href="#">Editar</a></td>
      </tr>
      <tr>
        <td>Edad</td>
        <td><?php print edad($alumno['fecha_nacimiento']) ?></td>
        <td><a href="#">Editar</a></td>
      </tr>
      <tr>
        <td>Sexo</td>
        <td><?php print ($alumno['sexo']==1) ? 'HOMBRE' : 'MUJER' ?></td>
        <td><a href="#">Editar</a></td>
      </tr>
      <tr>
        <td>Correo electrónico</td>
        <td><?php print $alumno['correo_electronico'] ?></td>
        <td><a href="#">Editar</a></td>
      </tr>
      <tr>
        <td>Situación escolar (SE)</td>
        <td><?php print $alumno['situacion_escolar'] ?></td>
        <td><a href="#">Editar</a></td>
      </tr>
      <tr>
        <td>Clave</td>
        <td><?php print $alumno['clave'] ?></td>
        <td><a href="#">Editar</a></td>
      </tr>
  </tbody>
</table>

<h2>Historial de liberacion de horas extraescolares</h2>
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
                  <a href="#" class="btn" rel="popover" data-content="<?php print $ins['observaciones'] ?>" data-original-title="Observación">ver</a><?php } ?></td>
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


<!--
 <?php $i=0; foreach ($periodos as $periodo) { 
        $liberado = false;
        $i++;
        foreach ($inscripciones as $ins) {
          if($ins['periodo'] == $periodo && $ins['acreditado'] == 1)
          {
              $liberado = true; break;
          }
            
        }
      ?>
      <p><button class="btn btn-large btn-<?php print ($liberado) ? 'success' : 'danger' ?>" data-toggle="collapse" data-target="#div<?php print $i ?>">
        <?php print $periodo ?>
      </button></p>
       <div id="div<?php print $i ?>" class="collapse off"> 
       
       <table class="table table-striped table-condensed">
        <thead>
        <th>fecha insc.</th>
        <th>fecha lib.</th>
        <th>Actividad</th>
        <th>Resultado</th>
        <th>Observaciones</th>
        <th></th></thead>
        <tbody><?php
            foreach ($inscripciones as $ins) {
              $club = false;
              if($ins['periodo'] == $periodo)
              { $club = true;?>
              <tr>
                <td><?php print $ins['fecha_inscripcion_club'] ?></td>
                <td><?php print $ins['fecha_liberacion_club'] ?></td>
                <td><?php print $ins['nombre_club'] ?></td>
                <td><?php print ($ins['acreditado']==1) ? '<span class="label label-success">ACREDITADO</span>' : '<span class="label label-important">NO ACREDITADO</span>' ?></td>
                <td><?php print $ins['observaciones'] ?></td>
                <td><a href="" class="btn">Formato</a></td>
              </tr>
                <?php
              } } ?>
               </tbody>
      </table>
</div>
    <?php } ?>

 -->
