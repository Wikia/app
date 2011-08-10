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
			'Jakub Olek <bukaj.kelo(at)gmail.com>'
		)
	),
	'other'
);

/**
 * classes
 */
$app->wg->set( 'wgAutoloadClasses', "{$dir}/PathFinderModel.class.php", 'PathFinderModel' );
$app->wg->set( 'wgAutoloadClasses', "{$dir}/BetterGlobalTitle.class.php", 'BetterGlobalTitle' );

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
 * special pages
 */

$app->wg->set( 'wgSpecialPages', 'PathFinderSpecialController', 'PathFinder' );

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
			"class=\"wikia-button secondary\" >" . $app->wf->Msg( 'pathfinder-find-path' ) . "</a></li>');</script>";
		
		$app->wg->Out->addScript( $script );
	}

	return true;
}