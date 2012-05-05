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

	public function contact($id) {
		$data = $this->Db->findAll($this->table);

		return $data;
	}
	
}