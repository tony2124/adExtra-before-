<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

include(_corePath . _sh .'/libraries/funciones/funciones.php');

class Admin_Controller extends ZP_Controller {
	
	public function __construct() {
		$this->app("admin");
		$this->Templates = $this->core("Templates");
		$this->Templates->theme();
		$this->Admin_Model = $this->model("Admin_Model");
	}
	
	public function index() {	
		
		if( SESSION('user_admin') )
			return redirect(get('webURL') .  _sh .'admin/estadistica');

		redirect(get('webURL') . _sh . 'admin/login');
	}

	public function logout() {
		unsetSessions(get('webURL') . _sh . 'admin');
	}

	function promotores()
	{
		if( !SESSION('user_admin') )
			return redirect(get('webURL') . _sh . 'admin/login');

		$vars['promotores']  = $this->Admin_Model->getPromotores();
		$vars['view'] = $this->view('adminPromotores',true);

		$this->render('content', $vars);
	}

	function login()
	{
		if (SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/estadistica');

		$vars['view'] = $this->view("login",true);
		$vars['error'] = '0';
		$this->render("login", $vars);
	}

	public function editalumno()
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$vars['numero_control'] = POST('numero_control');
		$vars['nombre'] = POST('nombre');
		$vars['ap'] = POST('ap');
		$vars['am'] = POST('am');
		$vars['fecha_nac'] = POST('fecha_nac');
		$vars['sexo'] = POST('sexo');
		$vars['email'] = POST('email');
		$vars['se'] = POST('se');
		$vars['clave'] = POST('clave');
		
		$this->Admin_Model->updateAlumno($vars);
		redirect(get('webURL').'/admin/alumno/'.$vars['numero_control']);
	}

	public function inscipcionActividad()
	{
		$vars['numero_control'] = POST('numero_control');
		$vars['id_administrador'] = SESSION('id_admin');
		$vars['club'] = POST('actividad');
		$vars['periodo'] = POST('periodo');
		$vars['semestre'] = POST('semestre');
		$vars['fecha_inscripcion'] = date('Y-m-d');
		$vars['fecha_modificacion'] = date('Y-m-d');
		$vars['observaciones'] = POST('obsIns');
		$vars['acreditado'] = POST('acreditado');
		print $this->Admin_Model->inscribirActividad($vars);

	}
	public function editResultado()
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$resultado = POST('acreditado');
		$folio = POST('folio');
		$numero_control = POST('numero_control');
		$obs = $_POST['obs'];
		$fecha_lib = date("Y-m-d");
		$this->Admin_Model->updateRes($resultado, $folio, $obs, $fecha_lib);
		redirect(get('webURL').'/admin/alumno/'.$numero_control);
	}

	public function formRegistroAlumno()
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$vars['carreras'] = $this->Admin_Model->getCarreras();
		$vars['view'] = $this->view('registroalumno',true);
		$this->render("content",$vars);
	}


	public function regisalumno()
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$vars['numero_control'] = POST('numero_control');
		$vars['nombre'] = POST('nombre');
		$vars['ap'] = POST('ap');
		$vars['am'] = POST('am');
		$vars['fecha_nac'] = POST('fecha_nac');
		$vars['fecha_ins'] = '2'.substr(POST('numero_control'), 0, 2).'3';
		$vars['sexo'] = POST('sexo');
		$vars['email'] = POST('email');
		$vars['se'] = POST('se');
		$vars['clave'] = POST('clave');
		$vars['car'] = POST('carrera');
		
		$this->Admin_Model->regAlumno($vars);
		redirect(get('webURL').'/admin/alumno/'.$vars['numero_control']);
	}


	public function elimnoticia($id)
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$this->Admin_Model->elimNoticia($id);
		redirect(get('webURL')._sh.'admin/noticias');
		
	}

	public function guardarnoticia()
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$nombre = POST('name');
		$texto = POST('texto');

		$cadena = str_replace( "'", "\"", $texto);
		$nombre = str_replace( "'", "\"", $nombre);

		$name = "";

		if (FILES("foto", "tmp_name")) 
		{
		    $path = _spath.'/IMAGENES/fotosNoticias/';  
		    $tmp_name = $_FILES["foto"]["tmp_name"];
			$name = $_FILES["foto"]["name"];
	
			$ext = explode(".",$name);		
			if($ext[1]=='JPG' || $ext[1]=='jpg')
			{		 		
				$id = date("YmdHis").rand(0,100).rand(0,100);
				$name = $id.".".$ext[1];

				move_uploaded_file($tmp_name, $path.$name); # Guardar el archivo en una ubicaci�n, debe tener los permisos necesarios
				chmod($path.$name,0777);

				$rutaImagenOriginal = $path.$name;
				$img_original = imagecreatefromjpeg($rutaImagenOriginal);
				$max_ancho = 800;
				$max_alto = 800;
				list($ancho,$alto) = getimagesize($rutaImagenOriginal);
				$x_ratio = $max_ancho /$ancho;
				$y_ratio = $max_alto / $alto;
				if(($ancho <= $max_ancho) && ($alto <= $max_alto))
				{
					$ancho_final = $ancho;
					$alto_final = $alto;
				}
				elseif(($x_ratio * $alto) <$max_alto)
				{
					$alto_final = ceil($x_ratio * $alto);
					$ancho_final = $max_ancho;
				}
				else 
				{
					$ancho_final = ceil($y_ratio*$ancho);
					$alto_final = $max_alto;
				}

				$tmp = imagecreatetruecolor($ancho_final,$alto_final);
				imagecopyresampled($tmp, $img_original, 0, 0, 0, 0, $ancho_final, $alto_final, $ancho, $alto);
				imagedestroy($img_original);
				$calidad = 95;
				imagejpeg($tmp,$path."tm".$name,$calidad);
					
				
				chmod($path."tm".$name,0777);
				unlink($path.$name);
				$name = "tm".$name;
			}else $name=""; 

		}

		$vars["id_noticias"] = uniqid();
		$vars["nombre_noticia"] = $nombre;
		$vars["texto_noticia"] = $cadena;
		$vars["imagen_noticia"] = $name;
		$vars["fecha_modificacion"] = date("Y-m-d");
		$vars["hora"] = date("H:i:s");
		$vars["id_administrador"] = SESSION('id_admin');

		$this->Admin_Model->saveNew($vars);
		redirect(get('webURL')._sh.'admin/noticias');
	}

	public function modnoticia($id_not)
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$nombre = POST('name');
		$texto = $_POST['texto'];

		$cadena = str_replace( "'", "\"", $texto);
		$nombre = str_replace( "'", "\"", $nombre);

		$name = POST('mostrarfoto');

		if (FILES("foto", "tmp_name")) 
		{
			$path = _spath.'/IMAGENES/fotosNoticias/'; 

		    $tmp_name = $_FILES["foto"]["tmp_name"];
			$name = $_FILES["foto"]["name"];
	
			$ext = explode(".",$name);		
			if($ext[1]=='JPG' || $ext[1]=='jpg')
			{		 		
				$id = date("YmdHis").rand(0,100).rand(0,100);
				$name = $id.".".$ext[1];

				move_uploaded_file($tmp_name, $path.$name); # Guardar el archivo en una ubicaci�n, debe tener los permisos necesarios
				chmod($path.$name,0777);

				$rutaImagenOriginal = $path.$name;
				$img_original = imagecreatefromjpeg($rutaImagenOriginal);
				$max_ancho = 800;
				$max_alto = 800;
				list($ancho,$alto) = getimagesize($rutaImagenOriginal);
				$x_ratio = $max_ancho /$ancho;
				$y_ratio = $max_alto / $alto;
				if(($ancho <= $max_ancho) && ($alto <= $max_alto))
				{
					$ancho_final = $ancho;
					$alto_final = $alto;
				}
				elseif(($x_ratio * $alto) <$max_alto)
				{
					$alto_final = ceil($x_ratio * $alto);
					$ancho_final = $max_ancho;
				}
				else 
				{
					$ancho_final = ceil($y_ratio*$ancho);
					$alto_final = $max_alto;
				}

				$tmp = imagecreatetruecolor($ancho_final,$alto_final);
				imagecopyresampled($tmp, $img_original, 0, 0, 0, 0, $ancho_final, $alto_final, $ancho, $alto);
				imagedestroy($img_original);
				$calidad = 95;
				imagejpeg($tmp,$path."tm".$name,$calidad);
					
				
				chmod($path."tm".$name,0777);
				unlink($path.$name);
				$name = "tm".$name;
			}else $name=""; 

		} 

		$vars["id_noticias"] = $id_not;
		$vars["nombre_noticia"] = $nombre;
		$vars["texto_noticia"] = $cadena;
		$vars["imagen_noticia"] = $name;
		$vars["fecha_modificacion"] = date("Y-m-d");
		$vars["hora"] = date("H:i:s");
		$vars["id_administrador"] = SESSION('id_admin');

		print $this->Admin_Model->updateNew($vars);

		redirect(get('webURL')._sh.'admin/noticias');
	}

	public function elimPromotor()
	{
		$usuario_promotor = POST('usuario_promotor');
		$this->Admin_Model->elimPromotor($usuario_promotor);
		redirect(get('webURL'). _sh . 'admin/promotores');
	}

	public function formRegistroPromotor()
	{
		$vars['clubes'] = $this->Admin_Model->getClubes();
		$vars['view'] = $this->view('registroPromotor', true);
		$this->render('content', $vars);
	}

	public function regProm()
	{
		$vars['user'] = POST('user');
		$vars['pass'] = POST('pass');
		$vars['nombre'] = POST('nombre');
		$vars['ap'] = POST('ap');
		$vars['am'] = POST('am');
		$vars['fecha_nac'] = POST('fecha_nac');
		$vars['fecha_reg'] = date("Y-m-d");
		$vars['sexo'] = POST('sexo');
		$vars['club'] = POST('club');
		$vars['sexo'] = POST('sexo');
		$vars['email'] = POST('email');
		$vars['tel'] = POST('tel');
		$vars['direccion'] = POST('direccion');
		$vars['ocupacion'] = POST('ocupacion');
		//____($vars);
		print $this->Admin_Model->regPromotor($vars);
		redirect(get('webURL'). _sh . 'admin/promotores');
	}

	public function noticias($id = NULL)
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$noticias = $this->Admin_Model->getNoticias();
		$vars['noticias'] = $noticias;
		$vars['view'] = $this->view("noticias",true);
		$vars['id'] = NULL;
		if($id)
		{
			$vars['id'] = $id;
			$n = $this->Admin_Model->getNoticia($id);
			$vars['modnot'] = $n[0];
		} 

		$this->render("content", $vars);
	}

	public function adminconfig($id = NULL)
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') . _sh .'admin/login');	
		
		if(!$id) $id = SESSION('id_admin');
		
		$datosAdmin = $this->Admin_Model->getAdminData($id);
		$datosAllAdmin = $this->Admin_Model->getAllAdminData();

		$vars['datosAdmin'] = $datosAdmin;
		$vars['allAdmin'] = $datosAllAdmin;
		$vars["view"] = $this->view("adminconfig",true);
		//$vars["view"]['registroAdmin'] = $this->view("registroAdmin",true);
		$this->render("contAdminConfig",$vars);
	}


	public function iniciarsesion()
	{
		$usuario = POST('usuario');
		$clave = POST('clave');
		$data = $this->Admin_Model->getData($usuario);

		if($data[0]['contrasena_administrador'] == $clave)
		{
			SESSION('user_admin',$data[0]['usuario_administrador']);
			SESSION('id_admin',$data[0]['id_administrador']);
			SESSION('name_admin',$data[0]['nombre_administrador']);
			SESSION('last1_admin',$data[0]['apellido_paterno_administrador']);
			SESSION('last2_admin',$data[0]['apellido_materno_administrador']);
			SESSION('profesion_admin',$data[0]['abreviatura_profesion']);
			return redirect(get('webURL') .  _sh .'admin/estadistica');
		}
		
		$vars['view'] = $this->view("login",true);
		$vars['error'] = '1';
		$this->render("login", $vars);

	}

	public function estadistica($periodo = NULL)
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$configuracion = $this->Admin_Model->getConfiguracion();
		//si no existe periodo calcular periodo actual

		if(!isset($periodo)) 
		{
			$periodo = periodo_actual();
		}

		$clubes = $this->Admin_Model->getClubes();
		$alumnos = $this->Admin_Model->getAlumnosInscritos( $periodo );
		//____($alumnos);
		$vars["view"]	 = $this->view("alumnosInscritos", TRUE);
		$vars["periodo"] = $periodo;
		$vars["clubes"] = $clubes;
		$vars["alumnos"] = $alumnos;
		$this->render("content", $vars);
	}

	public function buscar()
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$busqueda = POST('bus');
		$sit = POST('sit');

		if(!POST('sit')) $sit='1';
		//____($sit);
		$error = NULL;
		if($busqueda=='') $error = 1;

		$datos = $this->Admin_Model->getRespuesta($busqueda,$sit);
		
		/***************** variables **********************/
		$vars["error"] = $error;
		$vars["palabra"] = $busqueda;
		
		$vars["datos"] = $datos;
		
		$vars["view"] = $this->view("busquedaAlumnos",true);
		/*****************************************************/

		$this->render("content",$vars);
	}

	public function alumno($nctrl = NULL)
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');
		//include(_corePath . _sh .'/libraries/funciones/funciones.php');
		$datos = $this->Admin_Model->getAlumno($nctrl);
		$inscripciones = $this->Admin_Model->getClubesInscritosAlumno($nctrl);
		$clubes = $this->Admin_Model->getClubes('all');
		$vars["nombreAlumno"] = $datos[0]['apellido_paterno_alumno'].' '.$datos[0]['apellido_materno_alumno'].' '.$datos[0]['nombre_alumno'];
		$vars["periodos"] = periodos($datos[0]['fecha_inscripcion']);
		
		$vars['clubes'] = $clubes;
		$vars["alumno"] = $datos[0];
		$vars["inscripciones"] = $inscripciones;

		$vars["view"] = $this->view("alumno",true);

		$this->render("content",$vars);
	}

	public function listaclub($club = NULL, $periodo = NULL)
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$clubes = $this->Admin_Model->getClubes('all');
		$alumnos = $this->Admin_Model->getAlumnosClubes($club, $periodo);
		$vars['par1'] = $club;
		$vars['par2'] = $periodo;
		$vars['alumnos'] = $alumnos;
		$vars['clubes'] = $clubes;
		$vars['periodos'] = periodos('2083');
		$vars['view'] = $this->view("clubesalumnos", true);
		$this->render("content", $vars);
 	}

 	public function cambiarEstado ($estado = NULL)
 	{
 		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');
		echo $estado;
		if($estado == 'Vigente')
 			$this->Admin_Model->setCampo("administradores","actual",1,"id_administrador",SESSION('id_admin'));
 		else if($estado == 'noVigente')
 			$this->Admin_Model->setCampo("administradores","actual",0,"id_administrador",SESSION('id_admin'));
 		return redirect(get('webURL') .  _sh .'admin/adminconfig/');
 	}

}
