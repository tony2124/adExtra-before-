<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class Promotor_Model extends ZP_Model {
	
	public function __construct() {
		$this->Db = $this->db();
		$this->helpers();
	}

	public function getPromotor($user)
	{
		return $this->Db->query("select * from promotores natural join horarios natural join clubes where usuario_promotor = '$user' and eliminado_promotor=false");
	}

	public function getAlumnos($id_club, $periodo)
	{
		return $this->Db->query("select * from inscripciones natural join alumnos natural join carreras natural join clubes where id_club = '$id_club' and periodo = '$periodo' order by apellido_paterno_alumno asc, apellido_materno_alumno asc, nombre_alumno asc");
	}

	public function getConfiguracion()
	{
		return $this->Db->query("select * from configuracion");
	}

	public function setResultado($vars)
	{
		$fecha = date("Y-m-d");
		return $this->Db->query("update inscripciones set acreditado = '$vars[res]', fecha_liberacion_club = '$fecha' where folio = '$vars[folio]' and id_club = '$vars[id_club]' and periodo='$vars[periodo]'");
	}

	public function operacion($vars)
	{
		return $this->Db->query("insert into operaciones_administrativas(id_creador, nombre_operacion, fecha_creacion, hora_creacion) values('$vars[id_creador]','$vars[nombre_operacion]','".date('Y-m-d')."','".date('H:i:s')."')");
	}
	
}