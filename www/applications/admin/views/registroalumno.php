 <script type="text/javascript">
$().ready(function() {

   $("#registroalumno").validate({
    rules: {
      numero_control: {required:true, minlength: 8, maxlength: 8, digits: true},
      clave: { required:true, minlength: 6, maxlength: 16},
      nombre: "required",
      ap: "required",
      am:  "required",
      email: { required: true, email: true},
      fecha_nac: {required: true, date: true},
      se: { required: true, digits: true, maxlength: 1}
    },
    messages: {
      numero_control: { required: "* Este campo es obligatorio", minlength: "Debe tener 8 números", maxlength: "Debe tener 8 números", digits: "Debe introducir solo números" },
      clave: { required: "* Este campo es obligatorio", minlength: "Debe tener 6 caracteres mínimo", maxlength: "Debe tener 16 caracteres máximo" },
      nombre: "* Este campo es obligatorio",
      ap: "* Este campo es obligatorio",
      am: "* Este campo es obligatorio",
      email: { required: "* Este campo es obligatorio", email: "Ingrese un correo electrónico válido"},
      fecha_nac: { required: "* Este campo es obligatorio", date: "Ingrese una fecha válida en el formato aaaa-mm-dd"},
      se: { required: "* Este campo es obligatorio", digits: "Solo se aceptan números", maxlength: "Ingrese no más de 1 dígito."},
    }
  });
});
</script>

<style type="text/css">
  label.error { color: red; display: inline; margin-left: 10px;}
</style>
 <form id="registroalumno" class="form-horizontal" method="post" action="<?php print get('webURL')._sh.'admin/regisalumno' ?>">
    <fieldset>
      <legend>Inscripción de un nuevo alumno</legend>
       <p>Antes de registrar el alumno debe tomar en cuenta los siguientes aspectos:</p>
        <ul>
          <li>No debe usarse acentos en el nombre y apellidos del alumno.</li>
          <li>El nombre y apellidos debe escribirse con letra mayúscula.</li>
          <li>El correo electrónico de un alumno es indispensable.</li>
          <li>Debe asignársele una clave al alumno para que acceda al sitio de extraescolares.</li>
          <li>Verifique el número de control del alumno ya que <span class="label label-important">NO SERÁ POSIBLE</span> editarlo más tarde.</li>
        </ul>
        <hr>
        <div class="control-group">
          <label class="control-label" for="numero_control">Número de control</label>
          <div class="controls">
    <!-- -->  <input type="text" maxlength="8" name="numero_control" class="input-xlarge" id="numero_control">
          </div><br>
          <label class="control-label" for="nombre">Nombre</label>
          <div class="controls">
    <!-- -->  <input type="text" name="nombre" class="input-xlarge" id="nombre">
          </div><br>
          <label class="control-label" for="ap">Apellido paterno</label>
          <div class="controls">
      <!-- -->  <input type="text" name="ap" class="input-xlarge" id="ap">
          </div><br>
          <label class="control-label" for="am">Apellido materno</label>
          <div class="controls">
      <!-- -->  <input type="text" name="am" class="input-xlarge" id="am">
          </div><br>
          <label class="control-label">Carrera</label>
          <div class="controls">
      <!-- -->  <select name="carrera" id="carrera">
                  <?php foreach ($carreras as $carrera) { 
                    print '<option value="'.$carrera['id_carrera'].'">'.$carrera['abreviatura_carrera'].' ('.$carrera['id_carrera'].')</option>';
                  } ?>
  
                </select>
          </div><br>
          <label class="control-label" for="fecha_nac">Fecha de nacimiento</label>
          <div class="controls">
      <!-- -->  <input type="text" name="fecha_nac" class="input-xlarge selectorfecha" id="fecha_nac">
          </div><br>
          <label class="control-label">Sexo</label>
          <div class="controls">
      <!-- -->  <select name="sexo" id="sexo">
                  <option value="1">HOMBRE</option>
                  <option value="2">MUJER</option>
                </select>
          </div><br>
          <label class="control-label" for="email">Correo electrónico</label>
          <div class="controls">
      <!-- -->  <input type="text" name="email" class="input-xlarge" id="email">
          </div><br>
          <label class="control-label" for="se">Situación escolar</label>
          <div class="controls">
      <!-- -->  <input type="text" name="se" class="input-xlarge" id="se">
          </div><br>
          <label class="control-label" for="clave">Clave del sitio</label>
          <div class="controls">
      <!-- -->  <input type="text" name="clave" class="input-xlarge" id="clave">
          </div><br>

          <input type="submit" class="btn btn-success span2 pull-center" value="Registrar">  
        </div>
      </fieldset>
</form> 