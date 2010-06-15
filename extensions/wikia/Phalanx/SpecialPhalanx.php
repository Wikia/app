<?php

/**
 * Special:Phalanx
 *
 * User interface for viewing, testing and managing the Phalanx filter system.
 *
 * Note that this special page *requires* Phalanx to be enabled separately,
 * by including Phalanx_setup.php
 *
 * @author Bartek Łapiński <bartek@wikia-inc.com>
 * @author Lucas 'TOR' Garczewski <tor@wikia-inc.com>
 *
 * @date 2010-06-09
 */
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Phalanx UI',
	'description' => 'Integrated spam control mechanism managing interface',
	'description-msg' => 'phalanx-ui-description',
	'author' => array(
		'[http://community.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]',
		'[http://community.wikia.com/wiki/User:Macbre Maciej Brencz]',
		'[http://community.wikia.com/wiki/User:TOR Lucas \'TOR\' Garczewski]',
		'Bartek Łapiński',
	)
);

$wgSpecialPages['Phalanx'] = 'SpecialPhalanx';
$wgSpecialPages['PhalanxStats'] = 'PhalanxStats';

$dir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses['SpecialPhalanx'] = $dir.'SpecialPhalanx.body.php';
$wgAutoloadClasses['PhalanxStats'] = $dir.'SpecialPhalanxStats.body.php';
$wgAutoloadClasses['PhalanxHelper'] = $dir.'PhalanxHelper.class.php';
$wgAutoloadClasses['PhalanxAjax'] = $dir.'PhalanxAjax.class.php';

$wgSpecialPageGroups['Phalanx'] = 'wikia';

$wgAvailableRights[] = 'phalanx';

// Ajax dispatcher
$wgAjaxExportList[] = 'PhalanxAjax';
function PhalanxAjax() {
	global $wgUser, $wgRequest;

	wfProfileIn(__METHOD__);
	wfLoadExtensionMessages( 'Phalanx' );

	$method = $wgRequest->getVal('method', false);

	// check permissions
	if (!$wgUser->isAllowed('phalanx')) {
		$data = array('error' => 1, 'text' => 'Permission error.' );
	}
	// call selected method
	else if (method_exists('PhalanxAjax', $method)) {
		$data = PhalanxAjax::$method();
	}
	else {
		$data = false;
	}

	// return as JSON
	$json = Wikia::json_encode($data);
	$response = new AjaxResponse($json);
	$response->setContentType('application/json; charset=utf-8');

	wfProfileOut(__METHOD__);
	return $response;
}
