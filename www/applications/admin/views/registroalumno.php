 <form id="registroalumno" class="form-horizontal" method="post" action="<?php print get('webURL')._sh.'admin/regisalumno' ?>">
    <fieldset>
      <legend>Inscripción de un nuevo alumno</legend>
        <div class="control-group">
          <label class="control-label" for="input01">Número de control</label>
          <div class="controls">
    <!-- -->  <input type="text" name="numero_control" class="input-xlarge" id="input01">
          </div><br>
          <label class="control-label" for="input02">Nombre</label>
          <div class="controls">
    <!-- -->  <input type="text" name="nombre" class="input-xlarge" id="input02">
          </div><br>
          <label class="control-label" for="input03">Apellido paterno</label>
          <div class="controls">
      <!-- -->  <input type="text" name="am" class="input-xlarge" id="input03">
          </div><br>
          <label class="control-label" for="input04">Apellido materno</label>
          <div class="controls">
      <!-- -->  <input type="text" name="ap" class="input-xlarge" id="input04">
          </div><br>
          <label class="control-label">Carrera</label>
          <div class="controls">
      <!-- -->  <select name="carrera">
                  <?php foreach ($carreras as $carrera) { 
                    print '<option value="'.$carrera['id_carrera'].'">'.$carrera['abreviatura_carrera'].' ('.$carrera['id_carrera'].')</option>';
                  } ?>
  
                </select>
          </div><br>
          <label class="control-label" for="input05">Fecha de nacimiento</label>
          <div class="controls">
      <!-- -->  <input type="text" name="fecha_nac" class="input-xlarge selectorfecha" id="input05">
          </div><br>
          <label class="control-label">Sexo</label>
          <div class="controls">
      <!-- -->  <select name="sexo" >
                  <option value="1">HOMBRE</option>
                  <option value="2">MUJER</option>
                </select>
          </div><br>
          <label class="control-label" for="input06">Correo electrónico</label>
          <div class="controls">
      <!-- -->  <input type="text" name="email" class="input-xlarge" id="input06">
          </div><br>
          <label class="control-label" for="input07">Situación escolar</label>
          <div class="controls">
      <!-- -->  <input type="text" name="se" class="input-xlarge" id="input07">
          </div><br>
          <label class="control-label" for="input08">Clave del sitio</label>
          <div class="controls">
      <!-- -->  <input type="text" name="clave" class="input-xlarge" id="input08">
          </div><br>
          <label>* Tenga en cuenta que si usted realiza la inscripción de un alumno, éste ya no se importará cuando se actualice la base de datos.</label><br>
          <input type="submit" class="btn btn-success span2 pull-center" value="Registrar">  
        </div>
      </fieldset>
</form> 