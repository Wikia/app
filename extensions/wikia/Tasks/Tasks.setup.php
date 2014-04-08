<?php
if (!defined('MEDIAWIKI')) {
	exit(1);
}

require_once(__DIR__.'/special/setup.php');

spl_autoload_register(function($class) {
	if (strpos($class, 'Wikia\\Tasks') === false) {
		return false;
	}

	$path = __DIR__;
	$parts = explode('\\', $class);
	$class = end($parts);
	$parts = array_slice($parts, 2, -1);

	while (count($parts) > 0) {
		$next = array_shift($parts);
		$path .= "/{$next}";
	}

	require_once("{$path}/{$class}.class.php");
	return true;
});