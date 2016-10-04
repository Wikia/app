<?php
spl_autoload_register(function($class) {
	$prefix = 'ContributionPrototype\\';
	$len = strlen($prefix);
	if (strncmp($prefix, $class, $len) !== 0) {
		return;
	}

	$file = __DIR__.'/'.str_replace('\\', '/', substr($class, $len)).'.php';
	if (file_exists($file)) {
		require $file;
	}
});

// take over actions
$wgActions['view'] = ContributionPrototype\CPViewAction::class;
