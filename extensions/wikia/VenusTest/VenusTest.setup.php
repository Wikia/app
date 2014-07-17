<?php
/**
 * Venus skin Test
 *
 * @author Consumer Team
 */
$dir = dirname(__FILE__) . '/';

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Venus skin test',
	'description' => 'Test page for Venus skin',
	'authors' => [],
	'version' => 1.0
);

// models
$wgAutoloadClasses['VenusTestController'] =  $dir . 'VenusTestController.class.php';


// special page
$wgSpecialPages['VenusTest'] = 'VenusTestController';
$wgSpecialPageGroups['VenusTest'] = 'wikia';

// message files
$wgExtensionMessagesFiles['VenusTest'] = $dir.'VenusTest.i18n.php';
JSMessages::registerPackage( 'VenusTest', array( 'special-venustest-*' ) );

// hooks
$wgHooks['RequestContextCreateSkin'][] = 'VenusTestController::onGetSkin';
