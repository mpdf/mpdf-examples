<?php

// require composer autoload
require_once __DIR__ . '/bootstrap.php';

$mpdf = new \Mpdf\Mpdf([]);

$mpdf->SetWatermarkText(new \Mpdf\WatermarkText('Watermark text', 100, 90, '#996633', 0.4));
$mpdf->showWatermarkText = true;

$mpdf->WriteHtml('Example text');

$mpdf->Output();
