<?php

// require composer autoload
require_once __DIR__ . '/bootstrap.php';

$mpdf = new \Mpdf\Mpdf([]);

$mpdf->SetWatermarkImage(new \Mpdf\WatermarkImage('assets/tiger.wmf', \Mpdf\WatermarkImage::SIZE_DEFAULT, \Mpdf\WatermarkImage::POSITION_CENTER_PAGE, 0.2, true));
$mpdf->showWatermarkImage = true;

$mpdf->WriteHtml('Example text');

$mpdf->Output();
