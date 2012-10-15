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

// WikiaApp
$app = F::app();

// autoloaded classes
$app->registerClass('ScavengerHunt', "$dir/ScavengerHunt.class.php");
$app->registerClass('SpecialScavengerHunt', "$dir/SpecialScavengerHunt.php");
$app->registerClass('ScavengerHuntGame', "$dir/data/ScavengerHuntGame.class.php");
$app->registerClass('ScavengerHuntGames', "$dir/data/ScavengerHuntGames.class.php");
$app->registerClass('ScavengerHuntGameArticle', "$dir/data/ScavengerHuntGameArticle.class.php");
$app->registerClass('ScavengerHuntFormController', "$dir/ScavengerHuntFormController.class.php");
$app->registerClass('ScavengerHuntController', "$dir/ScavengerHuntController.class.php");

// i18n
$wgExtensionMessagesFiles['ScavengerHunt'] = "$dir/ScavengerHunt.i18n.php";

// special page
$wgSpecialPages['ScavengerHunt'] = 'SpecialScavengerHunt';

// hooks
$app->registerHook('MakeGlobalVariablesScript', 'ScavengerHunt', 'onMakeGlobalVariablesScript' );
$app->registerHook('BeforePageDisplay', 'ScavengerHunt', 'onBeforePageDisplay' );
$app->registerHook('OpenGraphMeta:beforeCustomFields', 'ScavengerHunt', 'onOpenGraphMetaBeforeCustomFields' );

// constuctors
F::addClassConstructor( 'ScavengerHuntGames', array( 'app' => $app ) );
F::addClassConstructor( 'ScavengerHuntGame', array( 'app' => $app, 'id' => 0 ) );

// XXX: standard MW constructors - needed to be moved to global place
F::addClassConstructor( 'Title', array(), 'newFromText' );