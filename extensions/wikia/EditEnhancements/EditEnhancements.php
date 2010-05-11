<?
$wgExtensionCredits['other'][] = array(
	'name' => 'EditEnhancements',
	'description' => 'Puts edit summary and save button above the fold',
	'version' => '1.2',
	'author' => array('Maciej Brencz', 'Christian Williams', '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]')
);

$wgExtensionFunctions[] = 'wfEditEnhancementsInit';
$wgAutoloadClasses['EditEnhancements'] = dirname(__FILE__) . '/EditEnhancements.class.php';

function wfEditEnhancementsInit($forceInit = false) {
	global $wgRequest;

	$action = $wgRequest->getVal('action', null);

	if ($action == 'edit' || $action == 'submit' || $forceInit == true) {
		$instance = EditEnhancements::getInstance($action, $forceInit);
	}
}
