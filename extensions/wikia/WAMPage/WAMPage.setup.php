<?php
/**
 * WAM Page
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 * @author Damian Jóźwiak
 * @author Łukasz Konieczny
 *
 */

$dir = dirname(__FILE__) . '/';
$app = F::app();

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'WAM Page',
	'author' => 'Andrzej "nAndy" Łukaszewski, Marcin Maciejewski, Sebastian Marzjan, Damian Jóźwiak, Łukasz Konieczny',
	'description' => 'WAM Page',
	'version' => 1.0
);

$app->registerClass( 'WAMPage', $dir . 'WAMPage.class.php' );
$app->registerClass( 'SpecialWAMPageController', $dir . 'SpecialWAMPageController.class.php' );

$app->registerSpecialPage( 'WAMPage', 'WAMPageSpecialController' );

$app->registerExtensionMessageFile( 'WAMPage', $dir . 'WAMPage.i18n.php' );