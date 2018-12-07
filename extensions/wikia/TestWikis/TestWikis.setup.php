<?php
/**
 * Extension credits properties.
 */
$wgExtensionCredits['api'][] = array(
	'path'           => __FILE__,
	'name'           => 'TestWikis',
	'author'         => 'Bartosz Piatek'
);

$dir = dirname(__FILE__) . '/';

// classes
$wgAutoloadClasses['TestWikis\Controller\TestWikisController'] = __DIR__ . 'controller/TestWikisController.php';
