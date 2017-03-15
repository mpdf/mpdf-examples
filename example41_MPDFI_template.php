<?php

$path = (getenv('MPDF_ROOT')) ? getenv('MPDF_ROOT') : __DIR__;
require_once $path . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf([
	'margin_left' => 15,
	'margin_right' => 15,
	'margin_top' => 57,
	'margin_bottom' => 16,
	'margin_header' => 9,
	'margin_footer' => 9
]);

$mpdf->SetImportUse();

$mpdf->SetDisplayMode('fullpage');

$mpdf->SetCompression(false);

// Add First page
$pagecount = $mpdf->SetSourceFile('pdf/sample_basic.pdf');

$crop_x = 50;
$crop_y = 50;
$crop_w = 100;
$crop_h = 100;

$tplIdx = $mpdf->ImportPage(2, $crop_x, $crop_y, $crop_w, $crop_h);

$x = 50;
$y = 50;
$w = 100;
$h = 100;

$mpdf->UseTemplate($tplIdx, $x, $y, $w, $h);

$mpdf->Rect($x, $y, $w, $h);

$mpdf->Output('newpdf.pdf', 'I');
