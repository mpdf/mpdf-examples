<?php

// required to load FPDI classes
$path = (getenv('MPDF_ROOT')) ? getenv('MPDF_ROOT') : __DIR__;
require_once $path . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();

$mpdf->SetImportUse();

$mpdf->Thumbnail('pdf/sample_orientation2.pdf', 4, 5);	// number per row	// spacing in mm

$mpdf->WriteHTML('<pagebreak /><div>Now with rotated pages</div>');

$mpdf->Thumbnail('pdf/sample_orientation3.pdf', 4);	// number per row	// spacing in mm

$mpdf->WriteHTML('<pagebreak /><div>Now with more rotated pages</div>');

$mpdf->Thumbnail('pdf/sample_rotated.pdf', 4);	// number per row	// spacing in mm

$mpdf->Output();
