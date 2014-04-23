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

	$file = "{$path}/{$class}.class.php";
	if (file_exists($file)) {
		require_once($file);
		return true;
	}

	return false;
});

class TaskExecutors {
	private static $modernExecutors = [
		'parsoid',
	];

	static function isLegacy($taskName) {
		return !self::isModern($taskName);
	}

	static function isModern($taskName) {
		return in_array($taskName, self::$modernExecutors);
	}
}