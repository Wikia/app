<?php

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Landing Page for Smurfs',
	'description' => 'Landing Page',
	'author' => array('Maciej Brencz', 'Marcin Maciejewski')
);

$dir = dirname(__FILE__) . '/';

// register special page
$wgAutoloadClasses['SpecialLandingPageSmurfs'] = $dir.'SpecialLandingPageSmurfs.class.php';
$wgSpecialPages['LandingPageSmurfs'] = 'SpecialLandingPageSmurfs';

// i18n
$wgExtensionMessagesFiles['LandingPageSmurfs'] = $dir . 'LandingPageSmurfs.i18n.php';
