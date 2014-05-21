<?php
/**
 * ErrorHandler
 *
 * ErrorHandler for handling standard php notices/warnings/fatals
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

// FIXME: this doesn't belong here
//$wgHooks['WikiaSkinTopScripts'][] = 'Wikia\\Logger\\WikiaLogger::onWikiaSkinTopScripts';

$loggerClasses = [
	"LogstashFormatter",
	"SyslogHandler",
	"WebProcessor",
	"WikiaLogger",
];

spl_autoload_register(function($class) use ($loggerClasses) {
	if (strpos($class, 'Wikia\\Logger') !== 0) {
		return false;
	}

	$parts = explode('\\', $class);
	if (!in_array($parts[2], $loggerClasses)) {
		return false;
	}

	$path = sprintf("%s/../%s/%s.class.php", __DIR__, $parts[1], $parts[2]);
	require_once($path);
	return true;
});
