<?php

// require composer autoload
$path = (getenv('MPDF_ROOT')) ? getenv('MPDF_ROOT') : __DIR__;
require_once $path . '/vendor/autoload.php';

$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDir = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
	'fontDir' => [
		$fontDir,
		__DIR__,
	],
	'fontdata' => $fontData + ['angerthas' => [
		'R' => 'assets/angerthas.ttf',
	]],
	'default_font' => 'angerthas'
]);

$mpdf->WriteHtml('<html>
    <head>
    </head>
    <body>
<h1>Using custom font in the document</h1>

<p>This example shows how to keep default font families while adding a custom font directory and definitions.

</body>
</html>');

$mpdf->Output();
die;
