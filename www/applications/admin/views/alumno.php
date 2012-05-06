<?php 
if(!$alumno){
  ?>
  <div class="alert alert-error"><h2>Error</h2>No se ha detectado el número de control de un alumno, por favor introdusca un número de contol para encontrar resultados.</div>
  <?php
  return;
}

include(_corePath . _sh .'/libraries/funciones/funciones.php'); ?>
<div class="well"><h4>A continuación se muestra los datos del alumno seleccionado.</h4></div>
<table class="table table-striped table-condensed">
  <thead>
    <tr>
      <th>No. de control</th>
      <th>Nombre</th>
      <th>Carrera</th>
    </tr>
  </thead>
  <tbody>
      <tr>
        <td>Número de control</td>
        <td><?php print $alumno['numero_control'] ?></td>
        <td><a hef="#">Editar</a></td>
      </tr>
  </tbody>
</table>