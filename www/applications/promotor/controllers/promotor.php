<?php
/**
 * Access from index.php:
 */
include(_corePath . _sh .'/libraries/funciones/funciones.php');

if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class Promotor_Controller extends ZP_Controller {
	
	public function __construct() {
		$this->app("promotor");
		
		$this->Templates = $this->core("Templates");

		$this->Templates->theme("promotor");

		$this->Promotor_Model = $this->model("Promotor_Model");
	}
	
	public function index() {	
		if(!SESSION('usuario_promotor')) redirect(get('webURL')._sh.'promotor/login');
		$vars['alumnos'] = $this->Promotor_Model->getAlumnos(SESSION('id_club'),periodo_actual());
		$vars['view'] = $this->view('liberarAlumnos', true);
		$this->render('content', $vars);
	}

	public function login()
	{
		if(SESSION('usuario_promotor')) redirect(get('webURL')._sh.'promotor');
		$vars['error'] = '0';
		$vars['view'] = $this->view('loginForm', true);
		$this->render('content', $vars);
	}

	public function promotor()
	{
		$vars['view'] = $this->view('content', true);
	}

	public function iniciarsesion()
	{
		if(SESSION('usuario_promotor')) redirect(get('webURL')._sh.'promotor');
		$user = POST('usuario');
		$clave = POST('clave');

		$data = $this->Promotor_Model->getPromotor($user);

		if($data!=NULL && $data[0]['contrasena_promotor'] == $clave)
		{
			SESSION('usuario_promotor', $data[0]['usuario_promotor']);
			SESSION('nombre_promotor', $data[0]['nombre_promotor']);
			SESSION('ap_promotor', $data[0]['apellido_paterno_promotor']);
			SESSION('am_promotor', $data[0]['apellido_materno_promotor']);
			SESSION('id_club', $data[0]['id_club']);
			SESSION('email', $data[0]['correo_electronico_promotor']);
			redirect(get('webURL')._sh.'promotor');
		}
		else
		{
			$vars['error'] = '1';
			$vars['view']=$this->view('loginForm',true);
			$this->render('content', $vars);
		}
		
	}

	public function salirSesion()
	{
		unsetSessions();
		redirect(get('webURL')._sh.'promotor');
	}

}