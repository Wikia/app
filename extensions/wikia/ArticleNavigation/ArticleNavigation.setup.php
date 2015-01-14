<?php
/**
 * ArticleNavigation
 *
 * @author Bogna 'bognix' Knychała
 *
 */

$wgExtensionCredits[ 'specialpage' ][] = [
	'name' => 'ArticleNavigation',
	'author' => 'Bogna "bognix" Knychała',
	'description' => 'ArticleNavigation',
	'version' => 1.0
];

// controller classes
$wgAutoloadClasses[ 'ArticleNavigationController' ] =  __DIR__ . '/ArticleNavigationController.class.php';
$wgAutoloadClasses[ 'ArticleNavigationContributeMenuController' ] =  __DIR__ . '/ArticleNavigationContributeMenuController.class.php';
$wgAutoloadClasses[ 'ArticleNavigationHelper' ] =  __DIR__ . '/ArticleNavigationHelper.class.php';

// hooks
$wgHooks['Linker::overwriteTOC'][] = 'ArticleNavigationHelper::onOverwriteTOC';

// messages
$wgExtensionMessagesFiles[ 'ArticleNavigation' ] = __DIR__ . '/ArticleNavigation.i18n.php';
