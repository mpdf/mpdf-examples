<?php

$types = [
	'png'  => ['png', 'png'],
	'gif'  => ['gif', 'gif'],
	'jpg'  => ['jpg', 'jpeg'],
	'jpeg' => ['jpg', 'jpeg'],
	'wmf'  => ['wmf', 'wmf'],
	'svg'  => ['wmf', 'svg+xml'],
	'bmp'  => ['wmf', 'x-ms-bmp'],
];

if (isset($_GET['t']) && isset($types[$_GET['t']])) {

	$image = $types[$_GET['t']];
	$filename = __DIR__ . '/assets/tiger.' . $image[0];
	$mime = $image[1];

	$fp = fopen($filename, 'rb');
	header("Content-Type: image/".$mime);
	header("Content-Length: " . filesize($filename));
	fpassthru($fp);
	fclose($fp);

} else {
	header('HTTP/1.1 404 Not Found');
}

exit;
