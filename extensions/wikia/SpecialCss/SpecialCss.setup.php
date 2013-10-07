<?php
/**
 * CSS Editor
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Łukasz Konieczny
 */
$dir = dirname(__FILE__) . '/';

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'CSS Editor',
	'description' => 'Admin tool for editing CSS files',
	'authors' => array(
		'Andrzej "nAndy" Łukaszewski',
		'Łukasz Konieczny',
	),
	'version' => 1.0
);

// models
$wgAutoloadClasses['SpecialCssModel'] =  $dir . 'SpecialCssModel.class.php';
$wgAutoloadClasses['SpecialCssHooks'] =  $dir . 'SpecialCssHooks.class.php';
$wgAutoloadClasses['SpecialCssController'] =  $dir . 'SpecialCssController.class.php';

// additional routing
F::app()->getDispatcher()->addRouting( 'SpecialCssController', ['index' => ["notSkin" => SpecialCssModel::$supportedSkins, "method" => "unsupportedSkinIndex"]] );

/**
 * @global Array $wgHooks The list of hooks.
 * 
 * @see http://www.mediawiki.org/wiki/Manual:$wgHooks
 * @see http://www.mediawiki.org/wiki/Manual:Hooks/AlternateEdit
 * @see http://www.mediawiki.org/wiki/Manual:Hooks/ArticleSaveComplete
 * @see http://www.mediawiki.org/wiki/Manual:Hooks/ArticleDelete
 * @see http://www.mediawiki.org/wiki/Manual:Hooks/ArticleUndelete
 */
$wgHooks['AlternateEdit'][] = 'SpecialCssHooks::onAlternateEdit';
$wgHooks['ArticleSaveComplete'][] = 'SpecialCssHooks::onArticleSaveComplete';
$wgHooks['ArticleDelete'][] = 'SpecialCssHooks::onArticleDelete';
$wgHooks['ArticleUndelete'][] = 'SpecialCssHooks::onArticleUndelete';

// special page
$wgSpecialPages['CSS'] = 'SpecialCssController';
$wgSpecialPageGroups['CSS'] = 'wikia';

// message files
$wgExtensionMessagesFiles['SpecialCss'] = $dir.'SpecialCss.i18n.php';
JSMessages::registerPackage( 'SpecialCss', array( 'special-css-*' ) );

//mapping community central language to it's database name
$wgCssUpdatesLangMap = array (
	'en' => 'wikia',
	'pl' => 'plwikia',
	'de' => 'de',
	'fr' => 'frfr',
	'es' => 'es',
	'ru' => 'ruwikia',
	'it' => 'it',
);
