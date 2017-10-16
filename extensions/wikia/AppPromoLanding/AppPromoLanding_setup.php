<?php

$wgExtensionCredits['other'][] = array(
	'name' => 'AppPromoLanding',
	'descriptionmsg' => 'apppromolanding-desc',
	'author' => [
		'[http://www.seancolombo.com/ Sean Colombo]',
	],
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/AppPromoLanding'
);

$dir = __DIR__ . '/';

// class autoloads mappings

// Nirvana controllers
$wgAutoloadClasses['AppPromoLandingController'] = $dir . 'AppPromoLandingController.class.php';

// i18n mapping
$wgExtensionMessagesFiles['AppPromoLanding'] = $dir . 'AppPromoLanding.i18n.php';

// setup functions
//$wgExtensionFunctions[] = 'AppPromoLandingController::setupAppPromoLanding';

// hooks
$wgHooks['OutputPageBeforeHTML'][] = 'AppPromoLandingController::onOutputPageBeforeHTML';
