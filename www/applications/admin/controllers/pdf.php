<?php
/**
 * Access from index.php:
 */
if(!defined("_access")) {
	die("Error: You don't have permission to access here...");
}


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
        $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().' de '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}


class MYPDFv extends TCPDF {

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
          
        <td height="60" width="280" align="center" valign="middle">
          <strong> Formato para Boleta de Acreditación de Actividades Culturales, Deportivas y Recreativas.</strong>
        </td>
          
        <td width="190" valign="middle">
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
        $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().' de '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
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
				$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor('Alfonso Calderon');
				$pdf->SetTitle('Lista de alumnos');
				$pdf->SetSubject('Lista');
				$pdf->SetKeywords('lista, extraescolares, clubes, club');
				$pdf->SetHeaderData("logo.png", 15, "Relación de alumnos del club de ".$data[0]['nombre_club'], "Instituto Tecnológico Superior de Apatzingán\n".$prommotor[0]['nombre_promotor']." ".$prommotor[0]['apellido_paterno_promotor']." ".$prommotor[0]['apellido_materno_promotor']."\nwww.itsa.edu.mx");
				$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
				$pdf->SetMargins(20, PDF_MARGIN_TOP, 20);
				$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
				$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
				$pdf->SetFont('dejavusans', '', 10);
				$pdf->AddPage();
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
					
				$pdf->writeHTML($html, true, false, true, false, '');
				$pdf->lastPage();
				$pdf->Output("lista".$club.$periodo.".pdf", 'I');
 			break;

 			case 'cedula':

				$data = $this->Admin_Model->getAlumnosClubes($club, $periodo);
				$prommotor = $this->Admin_Model->getPromotor($club);
				$admin = $this->Admin_Model->getAdminData(SESSION('id_admin'));

				$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor('Alfonso Calderon');
				$pdf->SetTitle('Lista de alumnos');
				$pdf->SetSubject('Lista');
				$pdf->SetKeywords('lista, extraescolares, clubes, club');
				$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
				$pdf->SetMargins(20, 60, 20);
				$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
				$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
				$pdf->SetFont('dejavusans', '', 10);
				$pdf->AddPage();
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
				   		'.$data[0]['nombre_club'].'
					</td>
					<td  width="100">
				   		<b>GRUPO:</b> 
					</td>
					<td width="150">
					ÚNICO
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
				  	$html .= '<tr>
						<td>&nbsp;'.($contador++).'</td>
						<td>&nbsp;'.$row['apellido_paterno_alumno'].' '.$row['apellido_materno_alumno'].' '.$row['nombre_alumno'].'</td>
						<td>&nbsp;'.$row['numero_control'].'</td>
						<td>&nbsp;'.$row['abreviatura_carrera'].'</td>
						<td>&nbsp;'.semestre($row['fecha_inscripcion']).'</td>
						<td>&nbsp;'.calcularEdad($row['fecha_nacimiento'], $row['fecha_inscripcion_club']).'</td>
						<td>&nbsp;';
						
						if($row['sexo'] == 1) $html .= "H"; else $html.= "M";
						
						$html .= '</td>
						<td class="margin-left:10px"> '.$row['observaciones'].'</td>
					</tr>';
					
				  }

				$html.='</table><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>Jefe de Departamento de Actividades Culturales, Deportivas y Recreativas: <b>'.strtoupper($admin[0]['abreviatura_profesion'].' '.$admin[0]['nombre_administrador'].' '.$admin[0]['apellido_paterno_administrador'].' '.$admin[0]['apellido_materno_administrador']).'</b>';
				$pdf->writeHTML($html, true, false, true, false, '');
				$pdf->lastPage();
				$pdf->Output("cedulaInscripcion.pdf", 'I');
 			break;

 			case 'liberacion':
 				$folio = $club; 
 				$row = $this->Admin_Model->getAlumnoInscrito($folio);
 			
 				$admin = $this->Admin_Model->getAdminData($row[0]['id_administrador']);
				$pdf = new MYPDFv(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor('Alfonso Calderon');
				$pdf->SetTitle('Liberacion de horas extraescolares');
				$pdf->SetSubject('Horas extraescolares');
				$pdf->SetKeywords('horas, extraescolares, clubes, club');
				$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
				$pdf->SetMargins(20, 50, 20);
				$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
				$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
				$pdf->SetFont('dejavusans', '', 10);
				$pdf->AddPage(); 
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
				    if($row[0]['observaciones'] != '' && $row[0]['tipo_club'] == 3 ) $html .= " (".$row[0]['observaciones'].")";
				    $html .= '</td>
				  </tr>
				  <tr>
				    <td valign="top"><strong> RESULTADO:</strong></td>
				    <td colspan="4" valign="top">';
				    if($row[0]['acreditado'] == 0 ) $html.=' NO ACREDITADO'; else $html.=' ACREDITADO';
				    $html.='</td>
				  </tr>
				  <tr>
				    <td align="center" height="137" valign="middle">
				      <br><strong> FECHA DE DESCARGA:</strong>
						<br><br>'.convertirFecha(date("Y-m-d"))."<br>".date("H:i:s").'<br><br><b>FECHA DE LIBERACIÓN</b><br><br>
						'.convertirFecha($row[0]['fecha_liberacion_club']).'
					 </td>
				    <td align="center" colspan="3" valign="top">
					<br><br>ATENTAMENTE<br><br><br><br>'.strtoupper($admin[0]['abreviatura_profesion'].' '.$admin[0]['nombre_administrador'].' '.$admin[0]['apellido_paterno_administrador'].' '.$admin[0]['apellido_materno_administrador']).'&nbsp;
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

				$pdf->writeHTML($html, true, false, true, false, '');
				$style = array(
				    'border' => 0,
				    'vpadding' => 'auto',
				    'hpadding' => 'auto',
				    'fgcolor' => array(0,0,0),
				    'bgcolor' => false, 
				    'module_width' => 1, 
				    'module_height' => 1 
				);

				$pdf->write2DBarcode('INSTITUTO TECNOLOGICO SUPERIOR DE APATZINGAN - DEPARTAMENTO DE ACTIVIDADES CULTURALES, DEPORTIVAS Y RECREATIVAS', 'QRCODE,L', 145, 113, 45, 45, $style, 'N');
				$pdf->lastPage();
				$pdf->Output($row[0]['numero_control'].$row[0]['periodo'].".pdf", 'I');
 			break;
 		}
 	}

}
