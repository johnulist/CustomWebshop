<?php
/**
 * PDF component. Uses html2fpdf library (http://html2fpdf.sourceforge.net/)
 *
 * @author      RosSoft
 * @version     0.2
 * @license     MIT
 *
 */
define('RELATIVE_PATH', ROOT . DS . 'app' . DS . 'vendors' . DS . 'html2fpdf' . DS);
App::import('Vendor', 'Html2fpdf', array('file' => 'html2fpdf/html2fpdf.php'));

class PdfComponent extends Object
{
    var $helpers = array('Html');
    var $layout = 'pdf';
    var $controller;

    //capture output from view
    function _content($thtml)
    {
        $layout_backup = $this->controller->layout;
        $this->controller->layout = $this->layout;
       	$content = $this->controller->requestAction($thtml, array('return'));
        $this->controller->layout = $layout_backup;
        return $content;
    }

    function startup(&$controller)
    {
    	$this->controller =& $controller;
    }

	function render($thtml=null)
	{
		$buffer=$this->_content($thtml);
        $buffer=utf8_decode($buffer);//I use utf8, need decoding to ISO-8859-1

		$pdf=new HTML2FPDF();

		$bufferarray = explode("NEWPAGE", $buffer);
		foreach($bufferarray as $pagina)
		{
			$pdf->AddPage();
			$pdf->WriteHTML($pagina);
		}

		$pdf->Output('export.pdf', 'D'); //Read the FPDF.org manual to know the other options
	}

	function buffer($thtml=null)
	{
	    $buffer=$this->_content($thtml);
		$buffer=utf8_decode($buffer);

		$pdf = new HTML2FPDF();
		$pdf->AddPage();
		$pdf->WriteHTML($buffer);
		return $pdf->Output(null, "S"); //Read the FPDF.org manual to know the other options
	}

	function save($thtml = null, $naam)
	{
	    $buffer=$this->_content($thtml);
		$buffer=utf8_decode($buffer);

		$pdf = new HTML2FPDF();
		$pdf->AddPage();
		$pdf->WriteHTML($buffer);

		$pdf->Output(ROOT . "/app/pdf/$naam", "F"); //Read the FPDF.org manual to know the other options
	}
}


?>