<?php
/**
 * User Path Prediction extension
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
		"name" => "User Path Prediction",
		"description" => "User Path Prediction",
		"descriptionmsg" => "userpathprediction-desc",
		"url" => "http://help.wikia.com/wiki/Help:UserPathPrediction",
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
$app->wg->set( 'wgAutoloadClasses', "{$dir}/UserPathPredictionModel.class.php", 'UserPathPredictionModel' );
$app->wg->set( 'wgAutoloadClasses', "{$dir}/SmarterGlobalTitle.class.php", 'SmarterGlobalTitle' );

/**
 * services
 */
$app->wg->set( 'wgAutoloadClasses', "{$dir}/UserPathPredictionLogService.class.php", 'UserPathPredictionLogService' );
$app->wg->set( 'wgAutoloadClasses', "{$dir}/UserPathPredictionService.class.php", 'UserPathPredictionService' );

/**
 * controllers
 */
$app->wg->set( 'wgAutoloadClasses', "{$dir}/UserPathPredictionController.class.php", 'UserPathPredictionController' );
$app->wg->set( 'wgAutoloadClasses', "{$dir}/UserPathPredictionSpecialController.class.php", 'UserPathPredictionSpecialController' );

/**
 * special pages
 */

$app->wg->set( 'wgSpecialPages', 'UserPathPredictionSpecialController', 'UserPathPrediction' );

/**
 * message files
 */
$app->wg->set( 'wgExtensionMessagesFiles', "{$dir}/UserPathPrediction.i18n.php", 'UserPathPrediction' );

/**
 * hooks
 */
$app->wg->append( 'wgHooks', 'efUserPathPredictionOnBeforePageDisplayAddButton', 'BeforePageDisplay' );

/*
 * settings
 */
//allow overriding in Default/LocalSettings or via WikiFactory
if ( empty( $app->wg->UserPathPredictionExludeNamespaces ) ) {
	 $app->wg->UserPathPredictionExludeNamespaces = array( NS_SPECIAL );
}

//this is a devbox only hack, will disappear before reaching production
function efUserPathPredictionOnBeforePageDisplayAddButton( $article, $row ) {
	$app = F::app();
	
	$title = $app->wg->title;
	if( $app->wg->DevelEnvironment && !$title->isSpecialPage() && get_class( $app->wg->User->getSkin() ) == 'SkinOasis' ) {
		$script = '<script>$("#WikiaPageHeader ul.commentslikes").append(\'<li><a href="/wiki/Special:UserPathPrediction/' . $title->getPrefixedUrl() . '" class="wikia-button secondary" >Show Path</a></li>\');</script>';
		$app->wg->Out->addScript( $script );
	}
	return true;
}