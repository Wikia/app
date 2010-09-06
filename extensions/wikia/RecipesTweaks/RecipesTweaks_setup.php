<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

$wgExtensionCredits['other'][] = array(
	'name' => 'Recipes Tweaks',
	'author' => 'Wikia, Inc.',
	'descriptionmsg' => 'recipestweaks-desc',
);

$dir = dirname(__FILE__) . '/';

// autoloaded classes
$wgAutoloadClasses['RecipesTweaks'] = $dir. 'RecipesTweaks.class.php';
$wgAutoloadClasses['SpecialSavedPages'] = $dir. 'SpecialSavedPages.class.php';

// special page
$wgSpecialPages['SavedPages'] = 'SpecialSavedPages';

// hooks
$wgHooks['BeforePageDisplay'][] = 'RecipesTweaks::beforePageDisplay';
$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'RecipesTweaks::renderArticleActionBar';
$wgHooks['SkinGetPageClasses'][] = 'RecipesTweaks::addBodyClass';
$wgHooks['CustomUserData'][] = 'RecipesTweaks::replaceWatchlistUserLink';
$wgHooks['MonacoBeforeWikiaPage'][] = 'RecipesTweaks::renderArticleHeaderTabs';
$wgHooks['MonacoBeforePageBar'][] = 'RecipesTweaks::renderArticleHeaderStripe';
if ( !empty( $wgEnableRecipiesTweaksSavedPages ) ) {
	// requested to be disabled on certain wikis, defaults to true (enabled) in CommonSettings
	$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'RecipesTweaks::renderUserSavedPagesBox';
}

// i18n
$wgExtensionMessagesFiles['RecipesTweaks'] = $dir . 'RecipesTweaks.i18n.php';
