<?php

/**
 * Wikia WAM Extension
 * @author Sebastian Marzjan
 *
 */


$app = F::app();
$dir = dirname(__FILE__) . '/';

/**
 * classes
 */
$wgAutoloadClasses['WAMApiController'] =  			$dir . 'controllers/api/WAMApiController.class.php';
$wgWikiaApiControllers['WAMApiController'] = 		$dir . 'controllers/api/WAMApiController.class.php';

$wgExtensionCredits['other'][] = array(
	'name'				=> 'WAM',
	'version'			=> '1.0',
	'author'			=> 'Sebastian Marzjan',
	'url'               => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/WAM',
	'descriptionmsg'    => 'wam-desc'
);

//i18n
$wgExtensionMessagesFiles['WAM'] = $dir . 'WAM.i18n.php';