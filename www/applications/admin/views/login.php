

<div class="span3">
	<?php if($error=='1') { ?>
	<div class="alert alert-error">
		 <a class="close" data-dismiss="alert" href="#">×</a>
	  Datos de inicio de sesión incorrectos.
	</div>
	<?php } ?>
	<h3>Inicio de sesión</h3>
	<form class="well" align="center" method="post" action="<?php print get('webURL') . 'admin/iniciarsesion' ?>">
	  <p><label>Usuario</label><input name="usuario" type="text" class="input-medium" placeholder="Usuario"></p>
	  <p><label>Contraseña</label><input name="clave" type="password" class="input-medium" placeholder="Contraseña"><br></p>
	  <p><button type="submit" class="btn btn-primary">Entrar</button></p>
	</form>
</div>