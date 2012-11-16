<script type="text/javascript">
$().ready(function() {

   $("#registropromotor").validate({
    rules: {
      user: {required:true, minlength: 6, maxlength: 16},
      pass: {required:true, minlength: 6, maxlength: 16},
      nombre: "required",
      ap: "required",
      am:  "required",
      email: { required: true, email: true},
      fecha_nac: {required: true, date: true},
      tel: {digits: true, minlength: 7, maxlength: 10},
      ocupacion: "required",
      direccion: "required",
      horario: "required",
      lugar: "required"
    },
    messages: {
      user: { required: "* Este campo es obligatorio", minlength: "Debe tener mínimo 6 caracteres", maxlength: "Debe tener máximo 16 caracteres" },
      pass: { required: "* Este campo es obligatorio", minlength: "Debe tener mínimo 6 caracteres", maxlength: "Debe tener máximo 16 caracteres" },
      nombre: "* Este campo es obligatorio",
      ap: "* Este campo es obligatorio",
      am: "* Este campo es obligatorio",
      email: { required: "* Este campo es obligatorio", email: "Ingrese un correo electrónico válido"},
      fecha_nac: { required: "* Este campo es obligatorio", date: "Ingrese una fecha válida en el formato aaaa-mm-dd"},
      ocupacion: "* Este campo es obligatorio",
      direccion: "* Este campo es obligatorio",
      horario: "* Este campo es obligatorio",
      lugar: "* Este campo es obligatorio",
      tel: {digits: "Este campo solo admite números", minlength: "El teléfono debe contener de 7 a 10 números", maxlength: "El teléfono debe contener de 7 a 10 números"}

    }
  });
});
</script> 

<style type="text/css">
  label.error { color: red; display: inline; margin-left: 10px;}
</style>

 <form id="registropromotor" class="form-horizontal" method="post" action="<?php print get('webURL')._sh.'admin/regProm' ?>" enctype="multipart/form-data">
    <fieldset>
      <legend>Inscripción de un nuevo promotor</legend>
      <div class="well">
      <h5>Antes de registrar al promotor debe tomar en cuenta los siguientes aspectos:</h5>
        <ul>
          <li>No debe usarse acentos en el nombre y apellidos del promotor.</li>
          <li>El nombre y apellidos debe escribirse con letra mayúscula.</li>
          <li>El correo electrónico del promotor es indispensable.</li>
          <li>El usuario del promotor NO PODRÁ SER MODIFICADO DESPUÉS.</li>
        </ul>
      </div>
        <hr>
        <div class="control-group">
           <label class="control-label" for="user">Foto</label>
          <div class="controls">
    <!-- -->  <input type="file"  name="foto">
          </div><br>
          <label class="control-label" for="user">Usuario</label>
          <div class="controls">
    <!-- -->  <input type="text" name="user" class="input-xlarge" id="user">
          </div><br>
          <label class="control-label" for="pass">Contraseña</label>
          <div class="controls">
    <!-- -->  <input type="password" name="pass" class="input-xlarge" id="pass">
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
          <label class="control-label" for="fecha_nac" >Fecha de nacimiento</label>
          <div class="controls">
      <!-- -->  <input type="text" name="fecha_nac" class="selectorFecha" placeholder="aaaa/mm/dd" id="fecha_nac" class="input-xlarge selectorfecha">
          </div><br>
          <label class="control-label">Sexo</label>
          <div class="controls">
      <!-- -->  <select name="sexo" id="sexo" >
                  <option value="1">HOMBRE</option>
                  <option value="2">MUJER</option>
                </select>
          </div><br>
          <label class="control-label">Club</label>
          <div class="controls">
      <!-- -->  <select name="club" id="club">
                <option>Seleccione una opción....</option>
                  <?php foreach ($clubes as $club){

                    print '<option value="'.$club['id_club'].'">'.$club['nombre_club'].'</option>';
                  } ?>
                </select>
          </div><br>
          <label class="control-label" for="horario">Horario de trabajo</label>
          <div class="controls">
      <!-- -->  <textarea name="horario" id="horario"></textarea>
          </div><br>
          <label class="control-label" for="lugar">Lugar de trabajo</label>
          <div class="controls">
      <!-- -->  <textarea name="lugar" id="lugar"></textarea>
          </div><br>
          <label class="control-label" for="email">Correo electrónico</label>
          <div class="controls">
      <!-- -->  <input type="text" name="email" class="input-xlarge" id="email">
          </div><br>
           <label class="control-label" for="tel">Teléfono</label>
          <div class="controls">
      <!-- -->  <input type="text" name="tel" class="input-xlarge" id="tel">
          </div><br>
          <label class="control-label" for="direccion">Dirección</label>
          <div class="controls">
      <!-- -->  <textarea name="direccion" id="direccion"></textarea>
          </div><br>
          <label class="control-label" for="ocupacion">Ocupación</label>
          <div class="controls">
      <!-- -->  <input type="text" name="ocupacion" class="input-xlarge" id="ocupacion">
          </div>
          <div class="form-actions">
            <input type="submit" class="btn btn-success span2 pull-center" value="Registrar">  
          </div>
        </div>
      </fieldset>
</form> 