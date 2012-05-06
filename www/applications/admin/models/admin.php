<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class Admin_Model extends ZP_Model {
	
	public function __construct() {
		$this->Db = $this->db();
		
		$this->helpers();
	
		$this->table = "contacts";
	}

	public function getConfiguracion()
	{
		return $data = $this->Db->query("select * from configuracion");
	}

	public function getClubes()
	{
		return $data = $this->Db->query("select * from clubes order by nombre_club asc");
	}

	public function getAlumnosInscritos($periodo = NULL)
	{
		return $data = $this->Db->query("select * from alumnos natural join inscripciones natural join clubes where periodo = '$periodo'");	
	}

	public function getData($usuario)
	{
		return $this->Db->query("select * from administradores where usuario_administrador = '$usuario'");
	}

	public function getAdminData($id)
	{
		return $this->Db->query("select * from administradores where id_administrador = '$id'");		
	}	

	public function getAllAdminData()
	{
		return $this->Db->query("select * from administradores");
	}

	public function getRespuesta($datos, $sit)
	{
		return $this->Db->query("select * from alumnos natural join carreras where numero_control like '$datos%' or nombre_alumno like '$datos%' or apellido_paterno_alumno like '$datos%' and situacion_escolar = '$sit' order by apellido_paterno_alumno asc, apellido_materno_alumno asc, nombre_alumno asc");
	}

	public function getAlumno($n)
	{
		return $this->Db->query("select * from alumnos where numero_control = '$n'");
	}
	public function contact($id) {
		$data = $this->Db->findAll($this->table);
		return $data;
	}
	
}