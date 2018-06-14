<?php

$GLOBALS['wgAutoloadClasses']['AutoLoginHooks'] = __DIR__ . '/AutoLoginHooks.php';
$GLOBALS['wgHooks']['BeforePageDisplay'][] = '\AutoLoginHooks::onBeforePageDisplay';

$GLOBALS['wgResourceModules']['ext.wikia.autoLogin'] = [
	'scripts' => 'ext.wikia.autoLogin.js',

	'localBasePath'=> __DIR__ . '/modules/',
	'remoteExtPath' => 'wikia/AutoLogin',
];
