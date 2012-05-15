<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

// Extend the TCPDF class to create custom Header and Footer
require_once(_spath.'/APIs/tcpdf/config/lang/eng.php');
require_once(_spath.'/APIs/tcpdf/tcpdf.php');
include(_corePath . _sh .'/libraries/funciones/funciones.php');

class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Set font
        $this->SetFont('helvetica', 'N', 10);
        $this->SetY(15);
        
        // Title
        $html = '<table style="border-collapse:collapse; font-family:Arial, Helvetica, sans-serif" border="1" cellspacing="0" cellpadding="0" width="620">
        <tr>
          <td height="110" width="150" rowspan="3" align="center" valign="middle">
          &nbsp;<br><img src="'._spath.'/formatos/formatoliberacionhoras_clip_image002.jpg" />
        </td>
          
        <td height="60" width="450" align="center" valign="middle">
          <strong> Formato para Boleta de Acreditación de Actividades Culturales, Deportivas y Recreativas.</strong>
        </td>
          
        <td width="250" valign="middle">
          <strong> Código:SNEST/D-VI-PO-003-05</strong>
        </td> 
        </tr>

        <tr>    
        <td rowspan="2" valign="middle" align="center">
          <strong><br> Referencia a la Norma ISO 9001:2008  7.2.1</strong>
        </td>

        <td height="25" valign="middle">
          <strong> Revisión: 3</strong>
        </td>  
        </tr>

        <tr>
          <td valign="top">
          <strong> Página '.$this->getAliasNumPage().' de '.$this->getAliasNbPages().'</strong>
        </td>
        </tr>
      </table>';
       $this->writeHTML($html, true, false, true, false, '');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
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

	public function editalumno()
	{
		print 'script para actualizar los datos del alumno';
	}

	public function elimnoticia($id)
	{
		$this->Admin_Model->elimNoticia($id);
		redirect(get('webURL')._sh.'admin/noticias');
		
	}

	public function editnoticia($id)
	{
		print "Script para editar la noticia";
	}

	public function guardarnoticia()
	{

		$nombre = POST('name');
		$texto = $_POST['texto'];

		$cadena = str_replace( "'", "\"", $texto);
		$nombre = str_replace( "'", "\"", $nombre);

		$name = "";

		if (FILES("foto", "tmp_name")) 
		{
		    $path = _spath; 
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


	public function noticias($id = NULL)
	{
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
			//include(_corePath . _sh .'/libraries/funciones/funciones.php');
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
		//include(_corePath . _sh .'/libraries/funciones/funciones.php');
		$datos = $this->Admin_Model->getAlumno($nctrl);
		$inscripciones = $this->Admin_Model->getClubesInscritosAlumno($nctrl);

		$vars["nombreAlumno"] = $datos[0]['apellido_paterno_alumno'].' '.$datos[0]['apellido_materno_alumno'].' '.$datos[0]['nombre_alumno'];
		$vars["periodos"] = periodos($datos[0]['fecha_inscripcion']);
		

		$vars["alumno"] = $datos[0];
		$vars["inscripciones"] = $inscripciones;

		$vars["view"] = $this->view("alumno",true);

		$this->render("content",$vars);
	}

	public function listaclub($club = NULL, $periodo = NULL)
	{

		$clubes = $this->Admin_Model->getClubes();
		$alumnos = $this->Admin_Model->getAlumnosClubes($club, $periodo);
		$vars['par1'] = $club;
		$vars['par2'] = $periodo;
		$vars['alumnos'] = $alumnos;
		$vars['clubes'] = $clubes;
		$vars['periodos'] = periodos('2083');
		$vars['view'] = $this->view("clubesalumnos", true);
		$this->render("content", $vars);
 	}

 	public function formatos($for, $club, $periodo)
 	{
 		
 		switch($for)
 		{
 			case 'lista':
 				$data = $this->Admin_Model->getAlumnosClubes($club, $periodo);
				$prommotor = $this->Admin_Model->getPromotor($club);
		
				// create new PDF document
				$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

				// set document information
				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor('Alfonso Calderon');
				$pdf->SetTitle('Lista de alumnos');
				$pdf->SetSubject('Lista');
				$pdf->SetKeywords('lista, extraescolares, clubes, club');

				// set default header data
				$pdf->SetHeaderData("logo.png", 15, "Relación de alumnos del club de ".$data[0]['nombre_club'], "Instituto Tecnológico Superior de Apatzingán\n".$prommotor[0]['nombre_promotor']." ".$prommotor[0]['apellido_paterno_promotor']." ".$prommotor[0]['apellido_materno_promotor']."\nwww.itsa.edu.mx");

				// set header and footer fonts
				$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

				// set default monospaced font
				$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

				//set margins PDF_MARGIN_LEFT PDF_MARGIN_TOP
				$pdf->SetMargins(20, PDF_MARGIN_TOP, 20);
				$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

				//set auto page breaks
				$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

				//set image scale factor
				$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

				//set some language-dependent strings
				//$pdf->setLanguageArray($l);

				// ---------------------------------------------------------

				// set font
				$pdf->SetFont('dejavusans', '', 10);

				// add a page
				$pdf->AddPage();

				// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
				// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

				// create some HTML content
				$html = '
					<br>
					<p align="center">
					RELACIÓN DE ALUMNOS DEL CLUB DE '.$data[0]['nombre_club'].' DEL PERIODO '.$periodo.'  
					</p>
					<table border="1" width="850">
						<tr height="80" align="center">
							<td width="400" height = "80"><br><br><br>Nombre del alumno</td>';
							$i=0;
							while($i<22)
							{
								$html .= '<td width="20"></td>';
								$i++;
							}
							$html .='
						</tr>';
						foreach ($data as $row ) {
							
							$html .= '
								<tr>
									<td> '.$row['apellido_paterno_alumno'].' '.$row['apellido_materno_alumno'].' '.$row['nombre_alumno'].'</td>';
									$i=0;
							while($i<22)
							{
								$html .= '<td width="20"></td>';
								$i++;
							}
							$html .='
								
								</tr>
								';
						}
						$html .= '</table>';
					

				// output the HTML content
				$pdf->writeHTML($html, true, false, true, false, '');

				// reset pointer to the last page
				$pdf->lastPage();

				// ---------------------------------------------------------

				//Close and output PDF document
				$pdf->Output("lista".$club.$periodo.".pdf", 'I');
				 
 			break;

 			case 'cedula':

				$data = $this->Admin_Model->getAlumnosClubes($club, $periodo);
				$prommotor = $this->Admin_Model->getPromotor($club);
				/*********************************************************************************************************/

				// se crea un nuevo documento
				$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

				// set document information
				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor('Alfonso Calderon');
				$pdf->SetTitle('Lista de alumnos');
				$pdf->SetSubject('Lista');
				$pdf->SetKeywords('lista, extraescolares, clubes, club');

				// set default monospaced font
				$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

				//set margins PDF_MARGIN_LEFT PDF_MARGIN_TOP
				$pdf->SetMargins(20, 60, 20);
				$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

				//set auto page breaks
				$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

				//set image scale factor
				$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

				//set some language-dependent strings
				//$pdf->setLanguageArray($l);

				// ---------------------------------------------------------

				// set font
				$pdf->SetFont('dejavusans', '', 10);

				// add a page
				$pdf->AddPage();

				// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
				// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

				// create some HTML content
				$html = '<p align="center">
					<b>
						DEPARTAMENTO DE ACTIVIDADES CULTURALES, DEPORTIVAS Y RECREATIVAS
					</b> 
				</p>
					
				<p align="center">
					<b>
						INSCRIPCIÓN - PERIODO: '.$periodo.'
					</b>
				</p>

				<br>

				<table style="border-collapse:collapse; font-family:Arial, Helvetica, sans-serif" border="0" 
						cellspacing="0" cellpadding="0">
				  <tr>
				    <td width="100">
				   		<b>ACTIVIDAD:</b>
					</td>
					<td width="250">
				   		<b>'.$data[0]['nombre_club'].'</b>
					</td>
					<td  width="100">
				   		<b>GRUPO:</b> 
					</td>
					<td width="150">
				   		
					</td>
					<td width="80">
				   		<b>HORA:</b>
					</td>
					<td width="150">
				   		
					</td>
					
				  </tr>
				</table>
				<br>&nbsp;<br>
				<table style="border-collapse:collapse; font-family:Arial, Helvetica, sans-serif" border="1" 
						cellspacing="0" cellpadding="0">
				  <tr align = "center">
				    <td width = "25">No.</td>
				    <td width = "300">ALUMNOS</td>
				    <td width = "90">No. CONTROL</td>
				    <td width = "150">CARRERA</td>
				    <td width = "45">SEM</td>
				    <td width = "45">EDAD</td>
				    <td width = "45">SEXO</td>
				    <td width = "150">OBSERVACIONES</td>
				  </tr>';
				  $contador = 1;
				  foreach($data as $row)
				  {
				  	$html .= '
					<tr>
						<td>&nbsp;'.($contador++).'</td>
						<td>&nbsp;'.$row['apellido_paterno_alumno'].' '.$row['apellido_materno_alumno'].' '.$row['nombre_alumno'].'</td>
						<td>&nbsp;'.$row['numero_control'].'</td>
						<td>&nbsp;'.$row['abreviatura_carrera'].'</td>
						<td>&nbsp;'.semestre($row['fecha_inscripcion']).'</td>
						<td>&nbsp;'.calcularEdad($row['fecha_nacimiento'], $row['fecha_inscripcion_club']).'</td>
						<td>&nbsp;';
						
						if($row['sexo'] == 1) $html .= "H"; else $html.= "M";
						
						$html .= '</td>
						<td>&nbsp;</td>
						
					</tr>
					';
					
				  }

				  $html.='</table>';


				// output the HTML content
				$pdf->writeHTML($html, true, false, true, false, '');

				// reset pointer to the last page
				$pdf->lastPage();

				// ---------------------------------------------------------

				//Close and output PDF document
				$pdf->Output("cedulaInscripcion.pdf", 'I');
				 
 			break;
 		}
 	}

}
