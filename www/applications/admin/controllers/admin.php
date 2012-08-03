<?php
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
		$this->render('noRightContent', $vars);
	}

	function login()
	{
		if (SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/estadistica');

		$vars['view'] = $this->view("login",true);
		$vars['error'] = '0';
		$this->render("noRightContent", $vars);
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
		$vars['observaciones'] = str_replace( "'", "\"", $_POST['obsIns']);
		$vars['acreditado'] = POST('acreditado');
		print $this->Admin_Model->inscribirActividad($vars);
		redirect(get('webURL').'/admin/alumno/'.POST('numero_control'));
	}
	public function editResultado()
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$resultado = POST('acreditado');
		$folio = POST('folio');
		$numero_control = POST('numero_control');
		$obs = str_replace( "'", "\"", $_POST['obs']);
		$fecha_lib = date("Y-m-d");
		print $this->Admin_Model->updateRes($resultado, $folio, $obs, $fecha_lib);
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

	public function guardarAviso()
	{
		$cuerpo =str_replace( "'", "\"",  $_POST['texto'] );
		$mostrar = POST('mostrarAviso');
		if($mostrar) $mostrar = 1; else $mostrar = 0;
		$this->Admin_Model->guardarAviso($cuerpo, $mostrar);
		redirect(get('webURL')._sh.'admin/avisos');
	}

	public function guardarnoticia()
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$nombre = $_POST['name'];
		$texto = $_POST['texto']; //porque necesito el código en formato HTML NO FORMATEADO

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

	public function updateLiberacion()
	{
		$vars['ins_ini'] = POST('ins_ini');
		$vars['ins_fin'] = POST('ins_fin');
		$vars['lib_ini'] = POST('lib_ini');
		$vars['lib_fin'] = POST('lib_fin');
		$vars['periodo'] = POST('periodo');
		$vars['nper'] = POST('nper');
		$this->Admin_Model->updateLiberacion($vars);
		redirect(get('webURL')._sh.'admin/configLiberacion');
	}

	public function modnoticia($id_not)
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');

		$nombre = $_POST['name'];
		$texto = $_POST['texto']; //porque necesito el código en formato HTML NO FORMATEADO

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

	public function elimFoto()
	{
		$id=POST('id_imagen');
		$image_name = POST('image_name');
		$url = $_POST['url'];
		$path = $_POST['path'];
		$filename = _spath.'/IMAGENES/clubes/'.$path._sh;
		/** DELETING PHISICS FILES ***/
		chmod($filename."thumbs/".$image_name, 0777);
		unlink($filename."thumbs/".$image_name);
		chmod($filename.$image_name, 0777);
		unlink($filename.$image_name);

		/****** DELETING FROM THE DATABASE ***/
		$this->Admin_Model->elimFoto($id);
		redirect($url);
	}

	function crearAlbum($tipo, $club)
	{
		$nombre_album = strtoupper( POST('nombre_album') );
		$id=uniqid();
		mkdir(_spath . _sh . 'IMAGENES/clubes/'.$club.'/'.$id, 0777);
		chmod(_spath . _sh . 'IMAGENES/clubes/'.$club.'/'.$id, 0777);
		mkdir(_spath . _sh . 'IMAGENES/clubes/'.$club.'/'.$id . '/thumbs', 0777);
		chmod(_spath . _sh . 'IMAGENES/clubes/'.$club.'/'.$id, 0777);
		$this->Admin_Model->crearAlbum($id, $nombre_album, $club);
		redirect(get('webURL')._sh.'admin/galeria/'.$tipo._sh.$club);
	}

	public function formRegistroPromotor()
	{
		$vars['clubes'] = $this->Admin_Model->getClubes();
		$vars['view'] = $this->view('registroPromotor', true);
		$this->render('content', $vars);
	}

	public function formEdicionPromotor($id)
	{
		$data = $this->Admin_Model->getEditPromotor($id);
		$vars['promotor'] = $data[0];
		$vars['clubes'] = $this->Admin_Model->getClubes();
		$vars['view'] = $this->view('editPromotor', true);
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

	public function editProm()
	{
		$vars['usuario'] = POST('user');
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
		print $this->Admin_Model->updatePromotor($vars);
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
		$this->render("noRightContent", $vars);

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
		$vars["periodos"] = periodos("2082");
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

 	public function configLiberacion()
 	{
 		$vars['view'] = $this->view('configLiberacion', true);
 		$config = $this->Admin_Model->getConfiguracion();
 		$vars['periodos'] = periodos('1082');
 		$vars['config'] = $config[0];

 		$this->render('content', $vars);
 	}

 	public function avisos()
 	{
 		$mensaje = $this->Admin_Model->getAviso();
 		$conf = $this->Admin_Model->getConfiguracion();
 		$vars['conf'] = $conf[0];
 		$vars['mensaje'] = $mensaje[0]; 
 		$vars['view'] = $this->view('avisos',true);
 		$this->render('content', $vars);
 	}

 	public function galeria($tipo=NULL, $club = NULL, $album = NULL, $subalbum = NULL)
 	{
 		$vars['URL']['tipo'] = $tipo;
 		$vars['URL']['club'] = $club;
 		$vars['URL']['album'] = $album;
 		if(isset($tipo)){
 			if($tipo==0)
 			{
 				$data[0]['nombre_club'] = 'GENERAL';
 				$data[0]['id_club'] = '0';

 				$vars['clubes'] = $data;
 			}
 			else
 			{
 				$data = $this->Admin_Model->getClubes($tipo);
 				if($data) $vars['clubes'] = $data;
 			}
 		} 

 		if(isset($club)) {

 			$data = $this->Admin_Model->getAlbumes('club',$club);
 			$vars['albumes'] = $data;
 			
 		}
 		if(isset($album)){
 			$vars['subalbumes'] = $this->Admin_Model->getAlbumes('album', $album);
 			$vars['fotos'] = $this->Admin_Model->getFotos($album);
 		}

 		$vars['view'] = $this->view('galeria',true);
 		$this->render('content', $vars);
 	}

 	public function banners()
 	{
 		$vars['view'] = $this->view('banners',true);
 		$this->render('content', $vars);
 	}

 	public function cambiarEstado ($estado = NULL,$userAdmin = NULL)
 	{
 		$this->sessionOn();
		if($estado == 'Vigente')
			$array = array("actual" => "1");
 		else if($estado == 'noVigente' && $this->Admin_Model->comprobarEstados() >= 2)
 			$array = array("actual" => "0");
 		else
 		{
 			$vars = $this->getDatosAdmin(SESSION('id_admin'));
 			$vars['errorEstado'] = true;
 			$vars["view"] = $this->view("adminconfig",true);
 			$this->render("content",$vars);
 			return;
 		}
 		$idAdministrador = $this->Admin_Model->getCampos("administradores","id_administrador","usuario_administrador='$userAdmin'");
 		$this->Admin_Model->setCampos("administradores",$array,isset($userAdmin)?$idAdministrador[0]['id_administrador']:SESSION('id_admin'));
 		return redirect(get('webURL') .  _sh .'admin/adminconfig/');
 	}

 	public function editaAdmin ()
 	{
 		//$this->sessionOn();
 		$datosAdmin = $this->Admin_Model->getCampos("administradores","contrasena_administrador","id_administrador = ".SESSION('id_admin'));
 		if(POST('guardarCambios'))
 		{
 			$datos = array(
 				0 => array(utf8_encode(POST('newpass1')),utf8_encode(POST('newpass2')),6,25,NULL,NULL,NULL),
 				1 => array(utf8_encode(POST('nombre')),NULL,NULL,25,"/^([A-Z][a-záéíóúñ]+([[:space:]][A-Z][a-záéíóúñ]+)*|[A-ZÁÉÍÓÚÑ]+([[:space:]][A-ZÁÉÍÓÚÑ]+)*)$/",NULL,NULL),
 				2 => array(utf8_encode(POST('adminAP')),NULL,NULL,25,"/^([A-Z][a-záéíóúñ]+([[:space:]][A-Z][a-záéíóúñ]+)*|[A-ZÁÉÍÓÚÑ]+([[:space:]][A-ZÁÉÍÓÚÑ]+)*)$/",NULL,NULL),
 				3 => array(utf8_encode(POST('adminAM')),NULL,NULL,25,"/^([A-Z][a-záéíóúñ]+([[:space:]][A-Z][a-záéíóúñ]+)*|[A-ZÁÉÍÓÚÑ]+([[:space:]][A-ZÁÉÍÓÚÑ]+)*)$/",NULL,NULL),
 				4 => array(utf8_encode(POST('email')),NULL,NULL,45,"/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/","administradores","correo_electronico"),
 				5 => array(utf8_encode(POST('direc')),NULL,NULL,100,"/^[[:ascii:]]*$/i",NULL,NULL),
 				6 => array(utf8_encode(POST('profe')),NULL,NULL,45,"/^[[:ascii:]]*$/i",NULL,NULL),
 				7 => array(utf8_encode(POST('abrevi')),NULL,NULL,40,"/^[[:ascii:]]*$/i",NULL,NULL)
 				);

 			$campos = array(
 				0 => array("contrasena_administrador","Contraseña"),
 				1 => array("nombre_administrador","Nombre"),
 				2 => array("apellido_paterno_administrador","Apellido paterno"),
 				3 => array("apellido_materno_administrador","Apellido materno"),
 				4 => array("correo_electronico","E-mail"),
 				5 => array("direccion_administrador","Dirección"),
 				6 => array("profesion_administrador","Profesión"),
 				7 => array("abreviatura_profesion","Abreviatura")
 				);
 			$array = array();
 			$i = 1;
 			while ($i < count($datos))
 			{
 				if(!$vars['adminUpdate'] = ($this->Admin_Model->isValid($datos[$i])))
	 			{
	 				$array += array($campos[$i][0] => utf8_decode($datos[$i][0]) );
	 			}
	 			else
	 			{
	 				$vars['adminUpdate'] = $campos[$i][1].": Al modificar - ".$vars['adminUpdate'];
	 				break;
	 			}
	 			$i++;
 			}
 			if(!$vars['adminUpdate'] && POST('lastpass') && (POST('lastpass') == $datosAdmin[0]['contrasena_administrador']))
 			{
 				//if(POST('lastpass') != $datosAdmin[0]['contrasena_administrador'])
 					//$vars['adminUpdate'] = "Contraseña actual: La contraseña introducida no es correcta, favor de verificar.";
 				if(!$vars['adminUpdate'] = $this->Admin_Model->isValid($datos[0]))
 				{
 					$array += array($campos[0][0] => utf8_decode($datos[0][0]));
 				}
 				else
 				{
 					$vars['adminUpdate'] = $campos[0][1].": Al modificar - ".$vars['adminUpdate'];
 				}
 			}
 			if(!$vars['adminUpdate'])
	 			$this->Admin_Model->setCampos("administradores",$array,SESSION('id_admin'));
 		}
 		$vars = $this->getDatosAdmin(SESSION('id_admin'),$vars);
		$vars["view"] = $this->view("adminconfig",true);
		$this->render("content",$vars);
 	}

 	public function regisAdmin()
 	{
 		$this->sessionOn();
 		$vars['date'] = date("Y-m-d");
 		if(POST('btnSubmit'))
 		{
 			//Explainer
 			/*	Array( 0 , 1 , 2 , n)
 			(value,	=> x , x , x , x
			compare,=> x , x , x , x
			min,	=> x , x , x , x
			max,	=> x , x , x , x
			expreg,	=> x , x , x , x
			tabla,	=> x , x , x , x
			columna)=> x , x , x , x
 			*/
 			$getPost = array(
 				0 => array(utf8_encode(POST('usuario')),NULL,6,25,"/^[A-Za-z][A-Za-z0-9]*$/","administradores","usuario_administrador"),	//4 letras iniciales seguidas de numeros o letras
 				1 => array(utf8_encode(POST('passone')),utf8_encode(POST('passtwo')),6,25,NULL,NULL,NULL), //Cualquier caracter exepto espacio
 				2 => array(utf8_encode(POST('nombre')),NULL,NULL,25,"/^([A-Z][a-záéíóúñ]+([[:space:]][A-Z][a-záéíóúñ]+)*|[A-ZÁÉÍÓÚÑ]+([[:space:]][A-ZÁÉÍÓÚÑ]+)*)$/",NULL,NULL),
 				3 => array(utf8_encode(POST('apepat')),NULL,NULL,25,"/^([A-Z][a-záéíóúñ]+([[:space:]][A-Z][a-záéíóúñ]+)*|[A-ZÁÉÍÓÚÑ]+([[:space:]][A-ZÁÉÍÓÚÑ]+)*)$/",NULL,NULL),
 				4 => array(utf8_encode(POST('apemat')),NULL,NULL,25,"/^([A-Z][a-záéíóúñ]+([[:space:]][A-Z][a-záéíóúñ]+)*|[A-ZÁÉÍÓÚÑ]+([[:space:]][A-ZÁÉÍÓÚÑ]+)*)$/",NULL,NULL),
 				5 => array(utf8_encode(POST('email')),NULL,NULL,45,"/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/","administradores","correo_electronico"),
 				6 => array(utf8_encode(POST('direccion')),NULL,NULL,100,"/^[[:ascii:]]*$/i",NULL,NULL),
 				7 => array(utf8_encode(POST('prof')),NULL,NULL,45,"/^[[:ascii:]]*$/i",NULL,NULL),
 				8 => array(utf8_encode(POST('abprof')),NULL,NULL,40,"/^[[:ascii:]]*$/i",NULL,NULL)
 				);
 			$campos = array(
 				0 => array("usuario_administrador","Usuario"),
 				1 => array("contrasena_administrador","Contraseña"),
 				2 => array("nombre_administrador","Nombre"),
 				3 => array("apellido_paterno_administrador","Apellido paterno"),
 				4 => array("apellido_materno_administrador","Apellido materno"),
 				5 => array("correo_electronico","E-mail"),
 				6 => array("direccion_administrador","Dirección"),
 				7 => array("profesion_administrador","Profesión"),
 				8 => array("abreviatura_profesion","Abreviatura")
 				);
 			$array = array();
 			$i = 0;
 			while ($i < count($getPost))
 			{
 				if(!$vars['regAdminError'] = ($this->Admin_Model->isValid($getPost[$i])))
	 			{
	 				$array += array($campos[$i][0] => utf8_decode($getPost[$i][0]) );
	 			}
	 			else
	 			{
	 				$vars['regAdminError'] = $campos[$i][1].": ".$vars['regAdminError'];
	 				break;
	 			}
	 			$i++;
 			}
	 		$array += array(
	 			"fecha_registro" => $vars['date'],
	 			"actual" => 1,
	 			"eliminado" => 0,
	 			"tipo_administrador" => 1
	 			);
	 		if(!$vars['regAdminError'])
	 			$vars['success'] = $this->Admin_Model->setRow("administradores",$array);
	 	}
 		$vars['view'] = $this->view("registroAdmin",true);
 		$this->render("content",$vars);
 	}

 	private function getDatosAdmin ($id,$vars = NULL)
 	{
 		$datosAdmin = $this->Admin_Model->getAdminData($id);
		$datosAllAdmin = $this->Admin_Model->getAllAdminData();

		$vars['datosAdmin'] = $datosAdmin;
		$vars['allAdmin'] = $datosAllAdmin;

		return $vars;
 	}

 	private function sessionOn()
 	{
 		if (!SESSION('user_admin'))
			return redirect(get('webURL') . _sh .'admin/login');
 	}

 	public function adminconfig($id = NULL)
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') . _sh .'admin/login');	
		
		if(!$id) $id = SESSION('id_admin');
		
		$vars = $this->getDatosAdmin($id);
		$vars["view"] = $this->view("adminconfig",true);
		//$vars["view"]['registroAdmin'] = $this->view("registroAdmin",true);
		$this->render("content",$vars);
	}
}
