<?php

// require composer autoload
$path = (getenv('MPDF_ROOT')) ? getenv('MPDF_ROOT') : __DIR__;
require_once $path . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf(['mode' => 'win-1252', 'format' => 'A4-L']);

$mpdf->useOnlyCoreFonts = true;
$mpdf->SetDisplayMode('fullpage');
$mpdf->SetFontSize(6);

$pm = 8;   // page margin
$w = 20;
$h = 10;
$m = 5;

for ($k = 0; $k <= 8; $k++) {    // Black - page group

  for ($y = 0; $y <= 10; $y++) {    // Yellow - page group

    $mpdf->AddPage();

    for ($i = 0; $i <= 10; $i++) {    // Rows (Magenta)

      for ($j = 0; $j <= 10; $j++) {    // Cols (Cyan)

        $mpdf->SetXY($pm + ($j * ($w + $m)), $pm + ($i * ($h + $m)));

        $mpdf->SetFillColor($j * 10, $i * 10, $y * 10, $k * 10);

        $mpdf->Cell($w, $h, '', 0, 0, 'L', 1);

        $mpdf->SetXY($pm + ($j * ($w + $m)), $h + $pm + ($i * ($h + $m)));

        $txt = 'C:' . ($j * 10) . ' M:' . ($i * 10) . ' Y:' . ($y * 10) . ' K:' . ($k * 10);

        $mpdf->Cell($w, 4, $txt, 0, 0, 'L');
      }
    }
  }
}

$mpdf->Output('mpdf.pdf', \Mpdf\Output\Destination::INLINE);
