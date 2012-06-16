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
		return $this->Db->query("select * from promotores where usuario_promotor = '$user' and eliminado_promotor=false");
	}

	public function getAlumnos($id_club, $periodo)
	{
		return $this->Db->query("select * from inscripciones natural join alumnos natural join carreras natural join clubes where id_club = '$id_club' and periodo = '$periodo' order by apellido_paterno_alumno asc, apellido_materno_alumno asc, nombre_alumno asc");
	}
	
}