<table class="table table-striped table-condensed">
  <thead>
    <tr>
      <th>Usuario</th>
      <th>Contraseña</th>
      <th>Nombre</th>
      <th>Sexo</th>
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
        <td><?php print $promotor['contrasena_promotor']?></td>
        <td><?php print $promotor['apellido_paterno_promotor'].' '.$promotor['apellido_materno_promotor'].' '.$promotor['nombre_promotor'] ?></td>
        <td><?php print ($promotor['sexo'] == 1) ? 'HOMBRE' : 'MUJER' ?></td>
        <td><?php print $promotor['correo_electronico']?></td>
        <td><?php print edad($promotor['fecha_nacimiento']) ?></td>
        <td><?php print $promotor['ocupacion']?></td>
        <td><?php print $promotor['direccion_promotor']?></td>
        <td></td>
      </tr>
    <?php } ?>
    
  </tbody>
</table>