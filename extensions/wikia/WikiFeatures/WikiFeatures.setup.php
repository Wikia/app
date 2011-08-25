<?php
/**
 * WikiFeatures
 *
 * @author Hyun Lim, Owen Davis
 *
 */
$dir = dirname(__FILE__) . '/';
$app = F::app();
//classes
$app->registerClass('WikiFeaturesSpecialController', $dir . 'WikiFeaturesSpecialController.class.php');
$app->registerClass('WikiFeatures', $dir . 'WikiFeatures.class.php');

// i18n mapping
$wgExtensionMessagesFiles['WikiFeatures'] = $dir . 'WikiFeatures.i18n.php';

// special pages
$app->registerSpecialPage('WikiFeatures', 'WikiFeaturesSpecialController');

$wgAvailableRights[] = 'wikifeatures';

$wgGroupPermissions['*']['wikifeatures'] = false;
$wgGroupPermissions['staff']['wikifeatures'] = true;
$wgGroupPermissions['sysop']['wikifeatures'] = true;
$wgGroupPermissions['bureaucrat']['wikifeatures'] = true;

$wgRevokePermissions['vstf']['wikifeatures'] = true;

// for testing
$wgWikiFeatures = array (
	'normal' => array (
		'wgEnableAjaxPollExt',	// Polls
		'wgEnableTopListsExt', // Top 10 Lists
		'wgEnableAchievementsExt',	// Achievements
		'wgEnablePageLayoutBuilder',	// Page Layout Builder
		'wgEnableBlogArticles',	// Blogs
		'wgEnableArticleCommentsExt',	// Article Comments
		'wgEnableCategoryExhibitionExt',	// Category Exhibition
	),
	'labs' => array (
		'wgEnableChat',	// Chat
		'wgEnableEditPageReskinExt',	// Editor Redesign (new RTE)
	)
);
