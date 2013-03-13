<?php
/**
 * WAM Page
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 * @author Damian Jóźwiak
 * @author Łukasz Konieczny
 *
 */

$dir = dirname(__FILE__) . '/';
$app = F::app();

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'WAM Page',
	'author' => 'Andrzej "nAndy" Łukaszewski, Marcin Maciejewski, Sebastian Marzjan, Damian Jóźwiak, Łukasz Konieczny',
	'description' => 'WAM Page',
	'version' => 1.0
);

// classes
$app->registerClass( 'WAMPageArticle', $dir . 'WAMPageArticle.class.php' );
$app->registerClass( 'WAMPageSpecialController', $dir . 'WAMPageSpecialController.class.php' );
$app->registerClass( 'WAMPageHooks', $dir . 'WAMPageHooks.class.php' );

// special pages
$app->registerSpecialPage( 'WAMPage', 'WAMPageSpecialController' );

// hooks
$app->registerHook('ArticleFromTitle', 'WAMPageHooks', 'onArticleFromTitle');

// i18n
$app->registerExtensionMessageFile( 'WAMPage', $dir . 'WAMPage.i18n.php' );
