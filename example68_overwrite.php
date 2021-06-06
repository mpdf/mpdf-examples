<?php
require_once __DIR__ . '/bootstrap.php';

$mpdf = new \Mpdf\Mpdf([
  'default_font' => 'freesans',
]);
$mpdf->WriteHTML('Hello world!');
$mpdf->WriteHTML('<p><strong>Hello world!</strong></p>');
$mpdf->Output('test.pdf','F');
unset($mpdf);

//==============================================================

$mpdf = new \Mpdf\Mpdf();
$replacements = [
  'Hello' => "Hi",
  'world' => "universe",
];
$mpdf->OverWrite('test.pdf',
  array_keys($replacements),
  array_values($replacements),
  'I', 'mpdf.pdf') ;
