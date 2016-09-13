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

// take over view action
$wgActions['view'] = ContributionPrototype\CPViewAction::class;

// This hook runs some setup/resource loading for the edit action
$wgHooks[ 'CustomEditor' ][] = 'ContributionPrototype\ContributionPrototypeHooks::onCustomEditor';

// different hook to load some js vars
$wgHooks['MakeGlobalVariablesScript'][] = 'ContributionPrototype\ContributionPrototypeHooks::onMakeGlobalVariablesScript';

//This hook just lets us override the PHP edit class during the edit action
//Not the "right" way to do this but we erase any other AlternateEditPageClass hooks this way because there can be only one
$wgHooks['AlternateEditPageClass'] = ['ContributionPrototype\ContributionPrototypeHooks::onAlternateEditPageClass'];
#$wgHooks['AlternateEditPageClass'][] = ['ContributionPrototype\ContributionPrototypeHooks::onAlternateEditPageClass'];
