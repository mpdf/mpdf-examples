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

$mpdf->SetDocTemplate('pdf/sample_logoheader2.pdf',1);	// 1|0 to continue after end of document or not - used on matching page numbers

//===================================================
$mpdf->AddPage();
$mpdf->WriteHTML('Hello World');
$mpdf->AddPage();
$mpdf->WriteHTML('Hello World');
$mpdf->AddPage();
$mpdf->WriteHTML('Hello World');
//===================================================

$mpdf->RestartDocTemplate();

//===================================================
$mpdf->AddPage();
$mpdf->WriteHTML('Hello World');
$mpdf->AddPage();
$mpdf->WriteHTML('Hello World');
$mpdf->AddPage();
$mpdf->WriteHTML('Hello World');
//===================================================

$mpdf->Output();
