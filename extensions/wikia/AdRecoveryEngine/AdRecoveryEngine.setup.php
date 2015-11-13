<?php
$wgExtensionCredits['other'][] = array(
	'name' => 'AdRecoveryEngine',
	'author' => 'AdEngineering',
	'description-msg' => 'Recoverable modules',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/AdRecoveryEngine',
);

// autoloaded classes
$wgAutoloadClasses['AdRecoveryEngine'] = __DIR__ . '/AdRecoveryEngine.php';
$wgAutoloadClasses['GCSRecoveryProvider'] = __DIR__ . '/provider/GCSRecoveryProvider.php';
