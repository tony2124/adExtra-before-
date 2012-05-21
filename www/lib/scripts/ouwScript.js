var globalElemento;

function activo(Elemento)
{
	globalElemento = Elemento.value;
}

function cambio(Elemento)
{
	botonGuardar = document.getElementById("guardarCambios");
	if(globalElemento != Elemento.value)
	{
		botonGuardar.disabled = "";
	}
	else 
	{
		botonGuardar.disabled = "disabled";
	}
}