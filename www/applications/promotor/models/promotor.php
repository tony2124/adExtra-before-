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
	
}