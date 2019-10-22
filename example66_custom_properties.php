<?php

// require composer autoload
require_once __DIR__ . '/bootstrap.php';

$mpdf = new \Mpdf\Mpdf([
	'customProperties' => [
		'property1' => 'value of property 1',
		'property2' => 'value of property 2',
		'rewritten_property' => 'value to rewrite',
	]
]);

$mpdf->WriteHtml('<html>
    <head>
    </head>
    <body>
<h1>Custom document properties</h1>

<p>This file will contain four custom properties on File > Properties > Custom tab

</body>
</html>');

$mpdf->AddCustomProperty('rewritten_property', 'rewritten_value');
$mpdf->AddCustomProperty('property3', 'value of property 3');

$mpdf->Output();
die;
