<?php
function convertirFecha($date)
{
	$f = explode("-", $date);
	
	return $f[2]."/".mes($f[1])."/".$f[0];
}

function periodos($fecha_inscripcion)
{
	$periodo = array();
	$fec = substr($fecha_inscripcion,1,2);
	$anio = "20".$fec;
	for($i = 0; $i < semestre($fecha_inscripcion) && $i < 9; $i++)
	{
		if($i % 2 == 0)
		{
		$periodo[$i] = "AGO".$anio."-ENE".($anio+1);
		$anio++; 
		}
		else
		{
		$periodo[$i] = "FEB".($anio)."-JUL".($anio);
		}
	}
	return $periodo;
}

function periodos_combo($fecha_inscripcion)
{
	$periodo = array();
	$fec = substr($fecha_inscripcion,1,2);
	$anio = "20".$fec;
	for($i = 0; $i < semestre($fecha_inscripcion); $i++)
	{
		if($i % 2 == 0)
		{
		$periodo[$i] = "AGO".$anio."-ENE".($anio+1);
		$anio++; 
		}
		else
		{
		$periodo[$i] = "FEB".($anio)."-JUL".($anio);
		}
	}
	return $periodo;
}

function fechaactual()
{
	return date("Y-m-d");	
}

function edad($edad){
		list($anio,$mes,$dia) = explode("-",$edad);
		$anio_dif = date("Y") - $anio;
		$mes_dif = date("m") - $mes;
		$dia_dif = date("d") - $dia;
		if ($mes_dif < 0)
			$anio_dif--;
		if($mes_dif == 0 && $dia_dif < 0)
			$anio_dif--;
			
		return $anio_dif;
	}
	

function calcularEdad($fecha1, $fecha2){
		list($anio1,$mes1,$dia1) = explode("-",$fecha1);
		list($anio2,$mes2,$dia2) = explode("-",$fecha2);
		$anio_dif = $anio2 - $anio1;
		$mes_dif = $mes2 - $mes1;
		$dia_dif = $dia2 - $dia1;
		if ($mes_dif < 0)
			$anio_dif--;
		if($mes_dif == 0 && $dia_dif < 0)
			$anio_dif--;
			
		return $anio_dif;
	}

function semestre($fecha)
{
		$fec = substr($fecha,1,2);
		if($fec < 90)
			$fecha = "20".$fec."-08-24";
		else 
			$fecha = "19".$fec."-08-24";
		
		list($anio,$mes,$dia) = explode("-",$fecha);
		$anio_dif = date("Y") - $anio;
		$mes_dif = date("m") - $mes;

		if ($mes_dif < 0)
		{
			$mes_dif = $anio_dif * 12 + $mes_dif; 
		}
		else
			$mes_dif = $anio_dif * 12 + $mes_dif; 
		
		if($mes_dif%6==0)
			$mes_dif++;
		return ceil($mes_dif/6);
}
	
	
function mes($mes)
{
		if($mes == 0) return "00";
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");		
		return $meses[$mes-1];
		
}
	
function periodo_actual()
{
		$nombremes1= "";
		list($anio,$mes) = explode("-",date("Y-m"));
		
		if($mes >= 8 || $mes == 1)
		{
			$nombremes1 = "AGO";
			$nombremes2 = "ENE";
		}
		else
		{
			$nombremes1 = "FEB";
			$nombremes2 = "JUL";
		}
		
		if($mes == 1)
		{
			$nombremes1 = $nombremes1."".($anio-1);
		}
		else
		{
			$nombremes1 = $nombremes1."".($anio);
		}
		
		if($nombremes2 == 'ENE' && $mes!=1)
			$anio = $anio + 1;
			
		$nombremes1.="-".$nombremes2."".$anio;

		return $nombremes1;	
}
	
?>
