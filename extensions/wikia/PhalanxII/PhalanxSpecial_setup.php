<?php

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'PhalanxII UI',
	'description' => 'Integrated spam control mechanism managing interface',
	'description-msg' => 'phalanx-ui-description',
	'author' => array(
		'[http://community.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]',
		'[http://community.wikia.com/wiki/User:Macbre Maciej Brencz]',
		'[http://community.wikia.com/wiki/User:TOR Lucas \'TOR\' Garczewski]',
		'Bartek Łapiński',
		'Piotr Molski (moli@wikia-inc.com)',
		'Krzysztof Krzyżaniak (eloy@wikia-inc.com)',
		'Maciej Szumocki (szumo@wikia-inc.com)'
	)
);

$dir = dirname(__FILE__) . '/';
$app = F::app();

$classes = array(
	/* controllers */
	'PhalanxSpecialController'        => $dir . 'PhalanxSpecialController.class.php',
	'PhalanxStatsSpecialController'   => $dir . 'PhalanxStatsSpecialController.class.php',
	/* pagers */
	'PhalanxPager'                    => $dir . 'classes/PhalanxPager.class.php',
	'PhalanxStatsPager'               => $dir . 'classes/PhalanxStatsPager.class.php',
	'PhalanxStatsWikiaPager'          => $dir . 'classes/PhalanxStatsWikiaPager.class.php',
	'PhalanxBlockTestPager'           => $dir . 'classes/PhalanxBlockTestPager.class.php'
);

foreach ( $classes as $class_name => $class_path ) {
	$wgAutoloadClasses[ $class_name] =  $class_path ;
}

$wgSpecialPages[ 'Phalanx' ] =  'PhalanxSpecialController';
$wgSpecialPageGroups['Phalanx'] = 'wikia';
$wgSpecialPages[ 'PhalanxStats' ] =  'PhalanxStatsSpecialController';
$wgSpecialPageGroups['PhalanxStats'] = 'wikia';

// Resources Loader module
$wgResourceModules['ext.wikia.Phalanx'] = array(
	'scripts' => array(
		'js/modules/phalanx.js',
		'js/SpecialPhalanx.js',
	),
	'styles' => array(
		'css/Phalanx.css'
	),
	'dependencies' => array(
		'wikia.log',
		'wikia.nirvana',
		'ext.bannerNotifications'
	),
	'messages' => array(
		'phalanx',
		'phalanx-validate-regexp-valid',
		'phalanx-validate-regexp-invalid',
		'phalanx-unblock-message',
		'phalanx-unblock-failure',
	),
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/PhalanxII'
);
