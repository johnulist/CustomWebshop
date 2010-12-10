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

        //
        if($footer = true)
        {
            $pdf->SetY(-50);
            //Copyright //especial para esta vers�o
            $pdf->SetFont('Arial','',9);
            $pdf->SetTextColor(0);
            //Cells

            $pdf->Cell(60, 7, Configure::read('Shop.bedrijfsnaam'), 0, 0, 'L', 0);
            $pdf->Cell(60, 7, "Tel: " . Configure::read('Shop.telefoon'), 0, 0, 'L', 0);
            $pdf->Cell(60, 7, Configure::read('Shop.bankNaam') . ": " . Configure::read('Shop.bankNummer'), 0, 0, 'L', 0);
            $pdf->Ln();

            $pdf->Cell(60, 7, Configure::read('Shop.adres'), 0, 0, 'L', 0);
            $pdf->Cell(60, 7, "Fax: " . Configure::read('Shop.fax'), 0, 0, 'L', 0);
            $pdf->Cell(60, 7, "IBAN: " . Configure::read('Shop.bankIban'), 0, 0, 'L', 0);
            $pdf->Ln();

            $pdf->Cell(60, 7, Configure::read('Shop.postcode') . " " . Configure::read('Shop.plaats'), 0, 0, 'L', 0);
            $pdf->Cell(60, 7, Configure::read('Shop.emailadres'), 0, 0, 'L', 0);
            $pdf->Cell(60, 7, "BIC: " . Configure::read('Shop.bankBIC'), 0, 0, 'L', 0);
            $pdf->Ln();

            $pdf->Cell(60, 7, '', 0, 0, 'L', 0);
            $pdf->Cell(60, 7, Configure::read('Shop.www'), 0, 0, 'L', 0);
            $pdf->Cell(60, 7, "BTW: " . Configure::read('Shop.btw'), 0, 0, 'L', 0);
            $pdf->Ln();

            //Return Font to normal
            $pdf->SetFont('Arial','',11);
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

	function save($thtml = null, $naam, $map)
	{
	    $buffer=$this->_content($thtml);
		$buffer=utf8_decode($buffer);

		$pdf = new HTML2FPDF();
		$pdf->AddPage();
		$pdf->WriteHTML($buffer);

		$pdf->Output(ROOT . "/app/pdf/$map/$naam", "F"); //Read the FPDF.org manual to know the other options
	}
   
    /*
     * <table width="100%">
            <tr>
                <td><?php echo Configure::read('Shop.bedrijfsnaam'); ?></td>
                <td>Tel: <?php echo Configure::read('Shop.telefoon'); ?></td>
                <td><?php echo Configure::read('Shop.bankNaam'); ?>: <?php echo Configure::read('Shop.bankNummer'); ?></td>
            </tr>
            <tr>
                <td><?php echo Configure::read('Shop.adres'); ?></td>
                <td>Fax: <?php echo Configure::read('Shop.fax'); ?></td>
                <td>IBAN: <?php echo Configure::read('Shop.bankIban'); ?></td>
            </tr>
            <tr>
                <td><?php echo Configure::read('Shop.postcode'); ?> <?php echo Configure::read('Shop.plaats'); ?></td>
                <td><?php echo Configure::read('Shop.emailadres'); ?></td>
                <td>BIC: <?php echo Configure::read('Shop.bankBIC'); ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo Configure::read('Shop.www'); ?></td>
                <td>BTW: <?php echo Configure::read('Shop.btw'); ?></td>
            </tr>
        </table>
     */
}


?>