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
		return $this->Db->query("select * from alumnos natural join carreras where (numero_control like '$datos%' or nombre_alumno like '$datos%' or apellido_paterno_alumno like '$datos%') and situacion_escolar = '$sit' order by apellido_paterno_alumno asc, apellido_materno_alumno asc, nombre_alumno asc");
	}

	public function getAlumno($n)
	{
		return $this->Db->query("select * from alumnos natural join carreras where numero_control = '$n'");
	}

	public function getClubesInscritosAlumno($n)
	{
		return $this->Db->query("select * from inscripciones natural join clubes where numero_control = '$n'");
	}

	public function getAlumnosClubes($club, $periodo)
	{
		return $this->Db->query("select * from inscripciones natural join alumnos natural join carreras 
				natural join clubes where id_club = '$club' and periodo = '$periodo' order by apellido_paterno_alumno asc, 
					apellido_materno_alumno asc, nombre_alumno asc");
	}

	public function getNoticias()
	{
		return $this->Db->query("select * from noticias where id_noticias != '1' order by fecha_modificacion desc, hora desc");
	}

	public function getNoticia($id)
	{
		return $this->Db->query("select * from noticias where id_noticias = '$id'");
	}

	public function saveNew($vars)
	{
		$query = "insert into noticias(id_noticias, nombre_noticia, texto_noticia, imagen_noticia, fecha_modificacion, hora, id_administrador)
		 				values ('$vars[id_noticias]','$vars[nombre_noticia]','$vars[texto_noticia]','$vars[imagen_noticia]','$vars[fecha_modificacion]','$vars[hora]',$vars[id_administrador])";

		$this->Db->query($query);
		return $query;

	}

	public function updateNew($vars)
	{
		$query = "update noticias set nombre_noticia = '$vars[nombre_noticia]' , 
			texto_noticia = '$vars[texto_noticia]', imagen_noticia = '$vars[imagen_noticia]', fecha_modificacion = '$vars[fecha_modificacion]', 
				hora = '$vars[hora]', id_administrador = $vars[id_administrador] where id_noticias = '$vars[id_noticias]'";

		$this->Db->query($query);
		return $query;

	}
	
	public function getPromotor($club)
	{
		return $this->Db->query("select * from promotores where id_club = '$club'");
	}

	public function elimNoticia($id)
	{
		$this->Db->query("delete from noticias where id_noticias = '$id'");
	}

}