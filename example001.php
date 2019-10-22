<?php

// require composer autoload
$path = (getenv('MPDF_ROOT')) ? getenv('MPDF_ROOT') : __DIR__;

require $path . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf([]);

$mpdf->WriteHTML("<img src='https://ibidsmsfrontend-dev.azurewebsites.net/assets/img/ibid.png' class='img-content'>");

$mpdf->Output('example001.pdf', 'F');
