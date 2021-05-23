<?php

require_once __DIR__ . '/bootstrap.php';

$mpdf = new \Mpdf\Mpdf();
$sizeConverter = new \Mpdf\SizeConverter($mpdf->dpi, $mpdf->default_font_size, $mpdf, new \Psr\Log\NullLogger());

if (strpos($_REQUEST['bodydata'], 'id%3D%22MathJax_SVG_Hidden%22') === false) {
	die('Hacking attempt');
}

$html = $_POST['bodydata'];
$html = urldecode($html);

preg_match('/<svg[^>]*>\s*(<defs.*?>.*?<\/defs>)\s*<\/svg>/', $html, $m);
$defs = $m[1];

$html = preg_replace('/<svg[^>]*>\s*<defs.*?<\/defs>\s*<\/svg>/', '', $html);
$html = preg_replace('/(<svg[^>]*>)/', "\\1" . $defs, $html);

//var_dump($html, $defs);die;

preg_match_all('/<svg([^>]*)>/', $html, $m);
foreach ($m as $attributes) {
	foreach ($attributes as $attribute) {
		preg_match('/width="(.*?)"/', $attribute, $wr);
		preg_match('/height="(.*?)"/', $attribute, $hr);
		//var_dump($wr, $hr);
		if ($wr && $hr) {
			$w = $sizeConverter->convert($wr[1], 0, $mpdf->FontSize) * $mpdf->dpi / 25.4;
			$h = $sizeConverter->convert($hr[1], 0, $mpdf->FontSize) * $mpdf->dpi / 25.4;
			//var_dump($w, $h);
			$html = str_replace('width="' . $wr[1] . '"', 'width="' . $w . '"', $html);
			$html = str_replace('height="' . $hr[1] . '"', 'height="' . $h . '"', $html);
		}
	}
}

$html = str_replace('stroke="currentColor"', 'stroke="#FFF"', $html);
$html = str_replace('fill="currentColor"', 'fill="#000"', $html);

if (isset($_POST['PDF']) && $_POST['PDF'] === 'PDF') {

	// add a stylesheet
	$stylesheet = '
	img {
		vertical-align: middle;
	}
	.MathJax_SVG_Display {
		padding: 1em 0;
	}
	#mpdf-create, script {
		display: none;
	}
	h3 {
		background-color: #EEEEEE;
		padding: 0.5em;
		border: 1px solid #8888FF;
		font-family: sans-serif;
		font-weight: bold;
		font-size: 14pt;
	}';

	$mpdf->WriteHTML($stylesheet, 1);

	$mpdf->WriteHTML($html);
	$mpdf->Output();

} else {
	// To output SVG files readable by mPDF as text output
	header('Content-type: image/svg+xml');
	preg_match_all('/<svg(.*?)<\/svg>/', $html, $m);
	for ($i = 0; $i < count($m[0]); $i++) {
		$svg = $m[0][$i];
		$svg = preg_replace('/>/', ">\n", $svg); // Just add some new lines
		echo $svg . "\n\n";
	}
}

exit;
