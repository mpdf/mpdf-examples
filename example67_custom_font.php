<?php

// require composer autoload
require_once __DIR__ . '/bootstrap.php';

$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
	'fontDir' => array_merge($fontDirs, [__DIR__]),
	'fontdata' => $fontData + 
		[
			'angerthas' => [
				'R' => 'assets/angerthas.ttf',
			],
			'inkfree' => [
				'R' => 'assets/Inkfree.ttf',
			],
		],
]);

$mpdf->WriteHtml('<html>
    <head>
		<style>
		.inkfree {
			font-family: "Ink Free";
		}
		</style>
    </head>
    <body>
<h1>Using custom font in the document</h1>

<p style=\'font-family: angerthas\'>This example shows how to keep default font families while adding a custom font directory and definitions.</p>

<p style="font-family: \'Ink Free\'">Inkfree line of text</p>

<p style="font-family: "Ink Free";">Inkfree line of text that is not working</p>

<p style=\'font-family: "Ink Free"\'>Inkfree line of text that is not working</p>

<p class="inkfree">Inkfree line of text</p>

</body>
</html>');

$mpdf->Output();
die;
