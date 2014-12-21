<?php

/**
 * ScavengerHunt
 *
 * A ScavengerHunt extension for MediaWiki
 * Alows to create a scavenger hunt game on a wiki
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2011-01-31
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     include("$IP/extensions/wikia/ScavengerHunt/ScavengerHunt_setup.php");
 */

$wgExtensionCredits['special'][] = array(
	'name' => 'Scavenger hunt',
	'version' => '1.0',
	'author' => array(
		'[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]',
		'Władysław Bodzek' ),
	'description-msg' => 'scavengerhunt-desc'
);

$dir = dirname(__FILE__);

// autoloaded classes
$wgAutoloadClasses['ScavengerHunt'] =  "$dir/ScavengerHunt.class.php";
$wgAutoloadClasses['SpecialScavengerHunt'] =  "$dir/SpecialScavengerHunt.php";
$wgAutoloadClasses['ScavengerHuntGame'] =  "$dir/data/ScavengerHuntGame.class.php";
$wgAutoloadClasses['ScavengerHuntGames'] =  "$dir/data/ScavengerHuntGames.class.php";
$wgAutoloadClasses['ScavengerHuntGameArticle'] =  "$dir/data/ScavengerHuntGameArticle.class.php";
$wgAutoloadClasses['ScavengerHuntFormController'] =  "$dir/ScavengerHuntFormController.class.php";
$wgAutoloadClasses['ScavengerHuntController'] =  "$dir/ScavengerHuntController.class.php";

// i18n
$wgExtensionMessagesFiles['ScavengerHunt'] = "$dir/ScavengerHunt.i18n.php";

// special page
$wgSpecialPages['ScavengerHunt'] = 'SpecialScavengerHunt';

// hooks
$wgHooks['MakeGlobalVariablesScript'][] = 'ScavengerHunt::onMakeGlobalVariablesScript';
$wgHooks['BeforePageDisplay'][] = 'ScavengerHunt::onBeforePageDisplay';
$wgHooks['OpenGraphMeta:beforeCustomFields'][] = 'ScavengerHunt::onOpenGraphMetaBeforeCustomFields';

