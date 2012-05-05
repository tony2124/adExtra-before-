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
		$vars["message"] = __(_("Hello World :D"));
		$vars["view"]	 = $this->view("show", TRUE);
		//$this->view("show",$vars);
		$this->render("content", $vars);
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
