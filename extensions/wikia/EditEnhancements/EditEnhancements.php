<?
$wgExtensionCredits['other'][] = array(
        'name' => 'EditEnhancements',
	'description' => 'Puts edit summary and save button above the fold',
        'version' => '1.0',
        'author' => array('[http://pl.wikia.com/wiki/User:Macbre Maciej Brencz]', 'Christian Williams')
);

$wgExtensionFunctions[] = 'wfEditEnhancementsInit';

function wfEditEnhancementsInit() {
	global $wgRequest;

	$action = $wgRequest->getVal('action', null);

	if ($action == 'edit' || $action == 'submit') {
		require( dirname(__FILE__) . '/EditEnhancements.class.php' );
		$instance = new EditEnhancements($action);
	}
}


