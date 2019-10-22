<?php

// require composer autoload
$path = (getenv('MPDF_ROOT')) ? getenv('MPDF_ROOT') : __DIR__;

require_once $path . '/../repo/vendor/autoload.php';

Tracy\Debugger::enable(Tracy\Debugger::DEVELOPMENT, __DIR__ . '/log');
Tracy\Debugger::$strictMode = true;
