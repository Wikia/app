<?php
/**
 * WikiaRecentChangesBlockHandler
 *
 * @author Andrzej 'nAndy' Łukaszewski
 */

$dir = dirname(__FILE__) . '/';

$wgExtensionCredits['other'][] = array(
	'name'			=> 'WikiaRecentChangesBlockHandler',
	'author'		=> 'Andrzej "nAndy" Łukaszewski',
	'description'	=> 'WikiaRecentChangesBlockHandler',
	'version'		=> 1.0
);

//classes
$wgAutoloadClasses['WikiaRecentChangesBlockHandler'] =  $dir.'WikiaRecentChangesBlockHandler.php';

//hooks
$wgHooks['ChangesListHeaderBlockGroup'][] = 'WikiaRecentChangesBlockHandler::onChangesListHeaderBlockGroup';