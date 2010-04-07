<?php
$wgExtensionCredits['other'][] = array(
	'name' => 'Recipes Tweaks',
	'description' => 'Design and functionality tweaks for Recipes Wiki',
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
$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'RecipesTweaks::renderUserSavedPagesBox';

// i18n
$wgExtensionMessagesFiles['RecipesTweaks'] = $dir . 'RecipesTweaks.i18n.php';