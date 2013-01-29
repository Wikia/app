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

$app->registerClass( 'PhalanxSpecialController', $dir . 'PhalanxSpecialController.class.php' );
$app->registerClass( 'PhalanxStatsSpecialController', $dir . 'PhalanxStatsSpecialController.class.php' );
$app->registerClass( 'Phalanx', $dir . 'classes/Phalanx.class.php' );
$app->registerClass( 'PhalanxPager', $dir . 'classes/PhalanxPager.class.php' );
$app->registerClass( 'PhalanxStatsPager', $dir . 'classes/PhalanxPager.class.php' );
$app->registerClass( 'PhalanxStatsWikiaPager', $dir . 'classes/PhalanxPager.class.php' );
$app->registerSpecialPage( 'Phalanx', 'PhalanxSpecialController', 'wikia' );
$app->registerSpecialPage( 'PhalanxStats', 'PhalanxStatsSpecialController', 'wikia' );

/*
 * rights, globals, etc.
 */
$wgAvailableRights[] = 'phalanx';
$wgAvailableRights[] = 'phalanxemailblock';

/**
 * messages
 */
$app->registerExtensionMessageFile('Phalanx', $dir . 'Phalanx.i18n.php');
