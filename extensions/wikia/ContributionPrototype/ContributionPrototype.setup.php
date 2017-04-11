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

$wgActions['view'] = ContributionPrototype\CPViewAction::class;
$wgActions['edit'] = ContributionPrototype\CPEditAction::class;
$wgActions['history'] = ContributionPrototype\CPHistoryAction::class;

// titles in the name mainspace shouldn't be force capitalized
$wgCapitalLinkOverrides = [NS_MAIN => false];

// have the url form be the value that's passed in the url bar. this is already decoded so we need to re-encode it
$wgHooks['AfterCheckInitialQueries'][] = function($title, $action, $ret) {
	if ($ret->getNamespace() === NS_MAIN) {
		$ret->mUrlform = rawurlencode($title);
	}

	return true;
};

// we shouldn't redirect if the db key doesn't match the incoming title
$wgHooks['TestCanonicalRedirect'][] = function($request, $title, $output) {
	if ($title->getNamespace() === NS_MAIN) {
		return false;
	}

	return true;
};
