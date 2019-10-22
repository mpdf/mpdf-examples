<?php

require_once __DIR__ . '/bootstrap.php';

$mpdf = new \Mpdf\Mpdf( [
    'mode' => 'utf-8',
    'format' => 'A4',
    'margin_left' => 0,
    'margin_right' => 0,
    'margin_top' => 0,
    'margin_bottom' => 0,
    'margin_header' => 0,
    'margin_footer' => 0
]);

$mpdf->setLogger(new class extends \Psr\Log\AbstractLogger {
	public function log($level, $message, array $context = [])
	{
		echo $level . ': ' . $message . "\n";
	}
});

$html = <<<HTML
<html>
<head>
    <style>
        table {
            font-size: 20%
        }
    </style>
</style>
</head>
<body>
    <table>
        <tr>
            <td>
                <table>
                    <tr>
                        <td>Test</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
HTML;

$mpdf->WriteHTML($html);

$mpdf->Output('example000.pdf', 'F');

