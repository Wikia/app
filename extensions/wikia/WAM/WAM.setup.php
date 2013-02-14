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
$app->registerClass('WAMApiController', 			$dir . 'controllers/api/WAMApiController.class.php');

$wgExtensionCredits['other'][] = array(
	'name'				=> 'WAM',
	'version'			=> '1.0',
	'author'			=> 'Sebastian Marzjan',
);
