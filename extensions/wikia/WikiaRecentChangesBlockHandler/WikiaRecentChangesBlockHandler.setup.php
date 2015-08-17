<?php
/**
 * WikiaRecentChangesBlockHandler
 *
 * @author Andrzej 'nAndy' Łukaszewski
 */

$dir = dirname(__FILE__) . '/';

$wgExtensionCredits['other'][] = array(
	'name'				=> 'WikiaRecentChangesBlockHandler',
	'author'			=> 'Andrzej "nAndy" Łukaszewski',
	'descriptionmsg'	=> 'wikiarecentchangesblockhandler-desc',
	'version'			=> 1.0,
	'url'       	    => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/WikiaRecentChangesBlockHandler'
);

//i18n
$wgExtensionMessagesFiles['WikiaRecentChangesBlockHandler'] = $dir . 'WikiaRecentChangesBlockHandler.i18n.php';

//classes
$wgAutoloadClasses['WikiaRecentChangesBlockHandler'] =  $dir.'WikiaRecentChangesBlockHandler.php';

//hooks
$wgHooks['ChangesListHeaderBlockGroup'][] = 'WikiaRecentChangesBlockHandler::onChangesListHeaderBlockGroup';