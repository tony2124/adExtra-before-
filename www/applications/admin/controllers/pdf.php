<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}

class Pdf_Controller extends ZP_Controller {
	
	public function __construct() {
		$this->app("admin");
		$this->Admin_Model = $this->model("Admin_Model");
	}
	
	public function formatos($for, $club=NULL, $periodo=NULL)
 	{
 		if (!SESSION('user_admin'))
			return redirect(get('webURL') .  _sh .'admin/login');
 		
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

 			case 'liberacion':
 				$folio = $club; //Se usa la variable club para pasar el folio de la inscripcion
 				$row = $this->Admin_Model->getAlumnoInscrito($folio);
 			
 				$admin = $this->Admin_Model->getAdminData($row[0]['id_administrador']);
				/******************************************************************************************/
				// se crea un nuevo documento
				$pdf = new MYPDFv(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

				// set document information
				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor('Alfonso Calderon');
				$pdf->SetTitle('Liberacion de horas extraescolares');
				$pdf->SetSubject('Horas extraescolares');
				$pdf->SetKeywords('horas, extraescolares, clubes, club');

				// set default monospaced font
				$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

				//set margins PDF_MARGIN_LEFT PDF_MARGIN_TOP
				$pdf->SetMargins(20, 50, 20);
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

				$html = '<br><br><br>

				<table width="620">
					<tr>
						<td width="620" align="center">
							<strong>DEPARTAMENTO DE ACTIVIDADES CULTURALES, DEPORTIVAS Y  RECREATIVAS</strong>
						</td>
					</tr>
				</table>

				<br><br><br>
				<table width="620" border="1" cellpadding="0"  cellspacing="0" style="border-collapse:collapse; font-family:Arial, Helvetica, sans-serif">
				  <tr>
				    <td align="center" colspan="5" valign="top" height="45">
					<strong><br>BOLETA DE ACREDITACIÓN DE ACTIVIDADES CULTURALES, DEPORTIVAS Y RECREATIVAS</strong>
					</td>
				  </tr>
				  <tr>
				    <td width="130" valign="top"><strong> No. DE CONTROL:</strong></td>
				    <td width="160" valign="top"> '.$row[0]['numero_control'].'</td>
				    <td width="140" colspan="2"  valign="top"><strong> PERIODO ESCOLAR:</strong></td>
				    <td width="190" valign="top"> '.$row[0]['periodo'].'</td>
				  </tr>
				  <tr>
				    <td><strong> ALUMNO:</strong></td>
				    <td colspan="4" valign="top"> '.$row[0]['nombre_alumno'].' '.$row[0]['apellido_paterno_alumno'].' '.$row[0]['apellido_materno_alumno'].'</td>
				  </tr>
				  <tr>
				    <td valign="top"><strong> ESPECIALIDAD:</strong></td>
				    <td valign="top">&nbsp;'.$row[0]['abreviatura_carrera'].'</td>
				    <td colspan="2" valign="top"><strong> SEMESTRE: </strong></td>
				    <td valign="top" align="center">'.$row[0]['semestre'].'</td>
				  </tr>
				  <tr>
				    <td valign="top"><strong> ACTIVIDAD:</strong></td>
				    <td colspan="4" valign="top"> '.$row[0]['nombre_club'];
				    if($row[0]['observaciones'] != '') $html .= " (".$row[0]['observaciones'].")";
				    $html .= '</td>
				  </tr>
				  <tr>
				    <td valign="top"><strong> RESULTADO:</strong></td>
				    <td colspan="4" valign="top"> ACREDITADO </td>
				  </tr>
				  <tr>
				    <td align="center" height="137" valign="middle">
				      <br><strong> FECHA DE DESCARGA:</strong>
						<br><br>'.convertirFecha(date("Y-m-d"))."<br>".date("H:i:s").'<br><br><b>FECHA DE LIBERACIÓN</b><br><br>
						'.convertirFecha($row[0]['fecha_liberacion_club']).'
					 </td>
				    <td align="center" colspan="3" valign="top">
					<br><br>ATENTAMENTE<br><br><br><br>'.$admin[0]['abreviatura_profesion'].' '.$admin[0]['nombre_administrador'].' '.$admin[0]['apellido_paterno_administrador'].' '.$admin[0]['apellido_materno_administrador'].'&nbsp;
					<br>
				      <br><strong>JEFE DEL DEPARTAMENTO DE ACTIVIDADES CULTURALES, DEPORTIVAS Y RECREATIVAS</strong>
					</td>
				    <td align="center" colspan="1" valign="top">
				    
				      <strong>SELLO:</strong><br><!--<img src="sello.png" />--></td>
				  </tr>
				</table>
				<br><br><br>
				<table style="text-align:justify"><tr><td>
				<strong>NOTA.*  CONSERVE ESTA BOLETA SE LE SOLICITARÁ EN LA REALIZACIÓN DE OTROS TRÁMITES.</strong>
				</td></tr></table>
				';

				// output the HTML content
				$pdf->writeHTML($html, true, false, true, false, '');

				$style = array(
				    'border' => 0,
				    'vpadding' => 'auto',
				    'hpadding' => 'auto',
				    'fgcolor' => array(0,0,0),
				    'bgcolor' => false, //array(255,255,255)
				    'module_width' => 1, // width of a single module in points
				    'module_height' => 1 // height of a single module in points
				);


				$pdf->write2DBarcode('INSTITUTO TECNOLOGICO SUPERIOR DE APATZINGAN - DEPARTAMENTO DE ACTIVIDADES CULTURALES, DEPORTIVAS Y RECREATIVAS', 'QRCODE,L', 145, 113, 45, 45, $style, 'N');
	
				$pdf->lastPage();

				//Close and output PDF document
				$pdf->Output($row[0]['numero_control'].$row[0]['periodo'].".pdf", 'I');

 			break;
 		}
 	}

}
