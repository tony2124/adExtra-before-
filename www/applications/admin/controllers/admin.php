<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

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

	function login()
	{
		if (SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/estadistica');

		$vars['view'] = $this->view("login",true);
		$vars['error'] = '0';
		$this->render("login", $vars);
	}

	public function adminconfig($id = NULL)
	{
		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');	
		
		if(!$id) $id = SESSION('id_admin');
		
		$datosAdmin = $this->Admin_Model->getAdminData($id);
		$datosAllAdmin = $this->Admin_Model->getAllAdminData();

		$vars['datosAdmin'] = $datosAdmin;
		$vars['allAdmin'] = $datosAllAdmin;
		$vars["view"]['adminConfig'] = $this->view("adminconfig",true);
		$vars["view"]['registroAdmin'] = $this->view("registroAdmin",true);
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
			include(_corePath . _sh .'/libraries/funciones/funciones.php');
			$periodo = periodo_actual();
		}
		$clubes = $this->Admin_Model->getClubes();
		$alumnos = $this->Admin_Model->getAlumnosInscritos( $periodo );

		$vars["view"]	 = $this->view("alumnosInscritos", TRUE);
		$vars["periodo"] = $periodo;
		$vars["clubes"] = $clubes;
		$vars["alumnos"] = $alumnos;
		$this->render("content", $vars);
	}

	public function buscar()
	{
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
		include(_corePath . _sh .'/libraries/funciones/funciones.php');
		$datos = $this->Admin_Model->getAlumno($nctrl);
		$inscripciones = $this->Admin_Model->getClubesInscritosAlumno($nctrl);

		$vars["nombreAlumno"] = $datos[0]['apellido_paterno_alumno'].' '.$datos[0]['apellido_materno_alumno'].' '.$datos[0]['nombre_alumno'];
		$vars["periodos"] = periodos($datos[0]['fecha_inscripcion']);
		

		$vars["alumno"] = $datos[0];
		$vars["inscripciones"] = $inscripciones;

		$vars["view"] = $this->view("alumno",true);

		$this->render("content",$vars);
	}

	public function contact($contactID) {
		$data = $this->Default_Model->contact($contactID);
		____($data);
	}

	public function page($page) {
		$data = $this->Default_Model->page($page);
		____($data);
	}

	public function test($param1, $param2) {
		print "New dispatcher it's works fine: $param1, $param2";
	}

	public function show($message) {
		$vars["message"] = $message;
		$vars["view"]	 = $this->view("show", TRUE);
		
		$this->render("content", $vars);
		#$this->view("show", $vars);
	}

}
