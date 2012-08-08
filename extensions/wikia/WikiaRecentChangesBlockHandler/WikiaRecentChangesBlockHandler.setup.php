<?php
/**
 * WikiaRecentChangesBlockHandler
 *
 * @author Andrzej 'nAndy' Łukaszewski
 */

$dir = dirname(__FILE__) . '/';
$app = F::app();

$wgExtensionCredits['other'][] = array(
	'name'			=> 'WikiaRecentChangesBlockHandler',
	'author'		=> 'Andrzej "nAndy" Łukaszewski',
	'description'	=> 'WikiaRecentChangesBlockHandler',
	'version'		=> 1.0
);

//classes
$app->registerClass('WikiaRecentChangesBlockHandler', $dir.'WikiaRecentChangesBlockHandler.php');

//hooks
$app->registerHook('ChangesListHeaderBlockGroup', 'WikiaRecentChangesBlockHandler', 'onChangesListHeaderBlockGroup');