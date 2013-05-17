<?php
/**
 * Path Finder extension
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This file is part of MediaWiki, it is not a valid entry point.\n";
	exit( 1 );
}

$app = F::app();
$dir = dirname( __FILE__ );

/**
 * info
 */
$app->wg->append(
	'wgExtensionCredits',
	array(
		"name" => "Path Finder",
		"description" => "Path finder",
		"descriptionmsg" => "pathfinder-desc",
		"url" => "http://help.wikia.com/wiki/Help:PathFinder",
		"author" => array(
			'Federico "Lox" Lucignano <federico(at)wikia-inc.com>',
			'Jakub Olek <jakubolek@wikia-inc.com>'
		)
	),
	'other'
);

/**
 * dependencies
 */
require_once( "{$IP}/lib/vendor/predis/Predis.php" );//Redis
require_once( "{$IP}/includes/wikia/S3Command.class.php" );//Amazon S3

/**
 * classes
 */
$app->wg->set( 'wgAutoloadClasses', "{$dir}/S3Command.class.php", 'S3Command' );
$app->wg->set( 'wgAutoloadClasses', "{$dir}/PathFinderCache.class.php", 'PathFinderCache' );
$app->wg->set( 'wgAutoloadClasses', "{$dir}/PathFinderParser.class.php", 'PathFinderParser' );

/**
 * models
 */
$app->wg->set( 'wgAutoloadClasses', "{$dir}/PathFinderDataSource.class.php", 'PathFinderDataSource' );
$app->wg->set( 'wgAutoloadClasses', "{$dir}/PathFinderDataSet.class.php", 'PathFinderDataSet' );
$app->wg->set( 'wgAutoloadClasses', "{$dir}/PathFinderModel.class.php", 'PathFinderModel' );

/**
 * services
 */
$app->wg->set( 'wgAutoloadClasses', "{$dir}/PathFinderLogger.class.php", 'PathFinderLogger' );
$app->wg->set( 'wgAutoloadClasses', "{$dir}/PathFinderService.class.php", 'PathFinderService' );

/**
 * controllers
 */
$app->wg->set( 'wgAutoloadClasses', "{$dir}/PathFinderController.class.php", 'PathFinderController' );
$app->wg->set( 'wgAutoloadClasses', "{$dir}/PathFinderSpecialController.class.php", 'PathFinderSpecialController' );

/**
 * exceptions
 */
$app->wg->set( 'wgAutoloadClasses', "{$dir}/PathFinderDataSource.class.php", 'PathFinderDataSourceNoDataException' );
$app->wg->set( 'wgAutoloadClasses', "{$dir}/PathFinderDataSet.class.php", 'PathFinderDataSetInvalidName' );

/**
 * special pages
 */
$wgSpecialPages['PathFinder'] = 'PathFinderSpecialController';

/**
 * message files
 */
$app->wg->set( 'wgExtensionMessagesFiles', "{$dir}/PathFinder.i18n.php", 'PathFinder' );

/**
 * hooks
 */
$app->wg->append( 'wgHooks', 'efPathFinderOnBeforePageDisplayAddButton', 'BeforePageDisplay' );

/*
 * settings
 */
//allow overriding in Default/LocalSettings or via WikiFactory
if ( empty( $app->wg->PathFinderExcludeNamespaces ) ) {
	 $app->wg->PathFinderExcludeNamespaces = array( NS_SPECIAL );
}

//this is a devbox-only-super-quick hack, will disappear before reaching production, no remorse, just live with that ;)
function efPathFinderOnBeforePageDisplayAddButton( $article, $row ) {
	$app = F::app();
	$title = $app->wg->title;

	if( $app->wg->DevelEnvironment && !in_array( $title->getNamespace(), $app->wg->PathFinderExcludeNamespaces ) && get_class( $app->wg->User->getSkin() ) == 'SkinOasis' ) {
		$specialTitle = Title::newFromText( 'PathFinder', NS_SPECIAL );
		$script = "<script>$('#WikiaPageHeader ul.commentslikes').append('<li><a href=\"{$specialTitle->getLocalURL()}/{$title->getPrefixedUrl()}\" " .
			"class=\"wikia-button secondary\" >" . wfMsg( 'pathfinder-find-path' ) . "</a></li>');</script>";

		$app->wg->Out->addScript( $script );
	}

	return true;
}
