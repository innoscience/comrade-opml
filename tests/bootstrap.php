<?php

error_reporting(E_ALL | E_STRICT);

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
	require_once __DIR__ . '/../vendor/autoload.php';
}
elseif (file_exists(__DIR__ . '/../../../autoload.php')) {
	require_once __DIR__ . '/../../../autoload.php';
}
else {
	throw new \Exception('Cannot find autoload.php captain. Run `composer install` to create autoload files or check composer.');
}