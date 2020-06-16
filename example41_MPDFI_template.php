<?php

require_once __DIR__ . '/bootstrap.php';

class Pdf extends \Mpdf\Mpdf
{
	public function clipRect($x, $y, $width, $heigth)
	{
		$this->pages[$this->page] .= $this->_setClippingPath($x, $y, $width, $heigth);
	}

	public function endClip()
	{
		$this->pages[$this->page] .= ' Q ';
	}
}

$mpdf = new Pdf([
	'margin_left' => 15,
	'margin_right' => 15,
	'margin_top' => 57,
	'margin_bottom' => 16,
	'margin_header' => 9,
	'margin_footer' => 9
]);

$mpdf->SetDisplayMode('fullpage');

$mpdf->SetCompression(false);

// Add First page
$pagecount = $mpdf->SetSourceFile('pdf/sample_basic.pdf');

$crop_x = 50;
$crop_y = 50;
$crop_w = 100;
$crop_h = 100;

$tplIdx = $mpdf->ImportPage(2);

$mpdf->AddPage();
$mpdf->clipRect($crop_x, $crop_y, $crop_w, $crop_h);

$mpdf->useTemplate($tplIdx);

$mpdf->endClip();

$mpdf->Rect($crop_x, $crop_y, $crop_w, $crop_h);

$mpdf->Output('newpdf.pdf', 'I');

$mpdf->cleanup();
