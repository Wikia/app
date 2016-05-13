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
 //$wgAutoloadClasses['CreateNewWikiObfuscate'] = $dir . 'CreateNewWikiObfuscate.class.php';
// $wgAutoloadClasses['CreateWiki'] = $dir."/CreateWiki.php";
// $wgAutoloadClasses['CreateWikiChecks'] = $dir."/CreateWikiChecks.php";
// $wgAutoloadClasses['SpecialCreateNewWiki'] = $dir . 'SpecialCreateNewWiki.class.php';

// Nirvana controllers
$wgAutoloadClasses['AppPromoLandingController'] = $dir . 'AppPromoLandingController.class.php';

// special page mapping

// i18n mapping
$wgExtensionMessagesFiles['AppPromoLanding'] = $dir . 'AppPromoLanding.i18n.php';

// setup functions
//$wgExtensionFunctions[] = 'AppPromoLandingController::setupAppPromoLanding';

// hooks
$wgHooks['OutputPageBeforeHTML'][] = 'AppPromoLandingController::onOutputPageBeforeHTML';
