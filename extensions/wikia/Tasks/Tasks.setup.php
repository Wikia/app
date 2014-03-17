<?php
if (!defined('MEDIAWIKI')) {
	exit(1);
}

$classes = [
	'AsyncTask',
	'BaseTask',
	'PriorityQueue',
	'Queue',
];

spl_autoload_register(function($class) use ($classes) {
	if (strpos($class, 'Wikia\\Tasks') === false) {
		return false;
	}

	$parts = explode('\\', $class);
	$path = __DIR__;

	if ($parts[2] == 'Tasks') {
		$class = end($parts);
		$parts = array_slice($parts, 2, -1);

		while (count($parts) > 0) {
			$next = array_shift($parts);
			$path .= "/{$next}";
		}

	} elseif (in_array($parts[2], $classes)) {
		$class = $parts[2];
	} else {
		return false;
	}

	require_once("{$path}/{$class}.class.php");
	return true;
});