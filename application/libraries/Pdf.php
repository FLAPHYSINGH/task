<?php
ini_set('display_errors', 0);
/**
 * Include base class
 */
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';


/**
 * Generate PDF from TCPDF
 */
class Pdf
{
	function generate($html,$filename='receipt', $file_path='', $customPaper='A4')
	{
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $customPaper, true, 'UTF-8', false);
		$pdf->SetPrintHeader(false);
		$pdf->SetPrintFooter(false);
		// $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		// $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		// $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		// $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->SetMargins(10, 10, 10, true);
		$pdf->AddPage();
		$pdf->SetFont('dejavusans', '', 14);
		$pdf->writeHTML($html, true, false, true, false, '');
		if(strlen($file_path)){
			$pdf->Output($file_path.$filename.'.pdf', 'F');
		}else{
			$pdf->Output($filename.'.pdf', 'I');
		}
	}
}
