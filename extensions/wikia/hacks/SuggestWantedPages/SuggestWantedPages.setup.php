<?php

/**
 * SuggestWantedPages
 *
 * Adds articles from Special:WantedPages to the list of pages suggested
 * by link creation modal
 *
 * @author macbre
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     include("$IP/extensions/wikia/hacks/SuggestWantedPages/SuggestWantedPages.setup.php");
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'Suggest wanted pages',
	'version' => '0.1',
	'author' => 'Maciej Brencz',
);

$dir = dirname(__FILE__);

$app = F::app();

$app->registerClass('SuggestWantedPagesController', "$dir/SuggestWantedPagesController.class.php");
$app->registerHook('ApiOpenSearchExecute', 'SuggestWantedPagesController', 'onApiOpenSearchExecute');