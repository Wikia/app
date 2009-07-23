<?
$wgExtensionCredits['other'][] = array(
	'name' => 'EditEnhancements',
	'description' => 'Puts edit summary and save button above the fold',
	'version' => '1.2',
	'author' => array('[http://pl.wikia.com/wiki/User:Macbre Maciej Brencz]', 'Christian Williams', '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]')
);

$wgExtensionFunctions[] = 'wfEditEnhancementsInit';

function wfEditEnhancementsInit($forceInit = false) {
	global $wgRequest;

	$action = $wgRequest->getVal('action', null);

	if ($action == 'edit' || $action == 'submit' || $forceInit == true) {
		require( dirname(__FILE__) . '/EditEnhancements.class.php' );
		$instance = new EditEnhancements($action);
	}
}