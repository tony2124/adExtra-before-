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

	public function acentos()
	{
		$this->Db->query("SET NAMES 'utf8'");
	}

	public function updateRes($acred, $folio, $obs, $fl)
	{
		$dat = $this->Db->query("select * from inscripciones where folio = $folio");
		$observaciones = $dat[0]['observaciones']."<br>".$fl."&nbsp;".$obs;
		$this->acentos();
		$query = "update inscripciones set acreditado = $acred, fecha_liberacion_club = '$fl', observaciones = '$observaciones' where folio = '$folio'";
	    $this->Db->query($query);
	    return $query;

	}

	public function getPromotores()
	{
		return $this->Db->query("select * from promotores where eliminado_promotor = false order by apellido_paterno_promotor asc, apellido_materno_promotor asc, nombre_promotor asc");
	}

	public function getConfiguracion()
	{
		return $data = $this->Db->query("select * from configuracion");
	}

	public function inscribirActividad($vars)
	{
		$this->acentos();
		$query = "insert into inscripciones(id_administrador, numero_control, id_club, periodo, semestre, 
					fecha_inscripcion_club, fecha_liberacion_club, observaciones, acreditado ) 
						values('$vars[id_administrador]','$vars[numero_control]','$vars[club]','$vars[periodo]','$vars[semestre]','$vars[fecha_inscripcion]',
							'$vars[fecha_modificacion]','$vars[observaciones]',$vars[acreditado])";
		$data = $this->Db->query($query);
		return $query;
	}

	public function getClubes($hm = NULL)
	{
		if(strcmp($hm, "all") == 0)
			return $data = $this->Db->query("select * from clubes where eliminado_club = 0 order by nombre_club asc");			
		return $data = $this->Db->query("select * from clubes where eliminado_club = 0 and tipo_club!=3 order by nombre_club asc");
	}

	public function getCarreras()
	{
		return $data = $this->Db->query("select * from carreras order by abreviatura_carrera asc");
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

	public function getAdminCampo($Campo, $Valor)
	{
		return $this->Db->query("select * from administradores where $Campo = $Valor");		
	}

	public function getAllAdminData()
	{
		return $this->Db->query("select * from administradores");
	}

	public function getRespuesta($datos, $sit)
	{
		return $this->Db->query("select * from alumnos natural join carreras where (numero_control like '$datos%' or nombre_alumno like '$datos%' or apellido_paterno_alumno like '$datos%') and situacion_escolar <= '$sit' order by apellido_paterno_alumno asc, apellido_materno_alumno asc, nombre_alumno asc");
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
		$this->acentos();
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

	public function elimPromotor($id)
	{
		$this->Db->query("update promotores set eliminado_promotor = true where usuario_promotor = '$id' ");
	}

	public function updateAlumno($vars)
	{
		$query = "update alumnos set nombre_alumno = '$vars[nombre]' , apellido_paterno_alumno = '$vars[ap]', apellido_materno_alumno = '$vars[am]',
			sexo = $vars[sexo], fecha_nacimiento = '$vars[fecha_nac]', correo_electronico = '$vars[email]', 
				situacion_escolar = $vars[se], clave = '$vars[clave]' where numero_control = '$vars[numero_control]'";

		$this->Db->query($query);
		return $query;
	}

	public function regAlumno($vars)
	{
		$query = "insert into alumnos (numero_control, nombre_alumno, apellido_paterno_alumno, apellido_materno_alumno, id_carrera, sexo, fecha_nacimiento, fecha_inscripcion, correo_electronico, situacion_escolar, clave)
				values('$vars[numero_control]', '$vars[nombre]', '$vars[ap]','$vars[am]', '$vars[car]',  $vars[sexo],  '$vars[fecha_nac]', '$vars[fecha_ins]', '$vars[email]', $vars[se],  '$vars[clave]')";

		$this->Db->query($query);
		return $query;
	}

	public function regPromotor($vars)
	{
		
		$query = "insert into promotores (usuario_promotor, contrasena_promotor, nombre_promotor, apellido_paterno_promotor, apellido_materno_promotor, id_club, sexo_promotor, fecha_nacimiento_promotor, fecha_registro_promotor, correo_electronico_promotor, telefono_promotor, ocupacion_promotor, direccion_promotor)
				values('$vars[user]', '$vars[pass]', '$vars[nombre]' ,'$vars[ap]','$vars[am]', $vars[club],  $vars[sexo],  '$vars[fecha_nac]', '$vars[fecha_reg]', '$vars[email]','$vars[tel]' ,'$vars[ocupacion]',  '$vars[direccion]')";
		//$this->acentos();
		$this->Db->query($query);
		return $query;
	}

	public function getAlumnoInscrito($folio)
	{
		return $this->Db->query("select * from inscripciones natural join alumnos natural join carreras natural join clubes where folio = '$folio'");
	}

	public function setCampo($tabla, $campos, $ID)
	{
		$this->Db->update($tabla, $campos, $ID);
	}
}