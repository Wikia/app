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

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'WAM Page',
	'author' => 'Andrzej "nAndy" Łukaszewski, Marcin Maciejewski, Sebastian Marzjan, Damian Jóźwiak, Łukasz Konieczny',
	'descriptionmsg' => 'wam-page-desc',
	'version' => 1.0,
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/WAMPage'
);

// classes
$wgAutoloadClasses[ 'WAMPage'] =  $dir . 'WAMPage.class.php' ;
$wgAutoloadClasses[ 'WAMPageArticle'] =  $dir . 'WAMPageArticle.class.php' ;
$wgAutoloadClasses[ 'WAMPageController'] =  $dir . 'WAMPageController.class.php' ;
$wgAutoloadClasses[ 'WAMPageHooks'] =  $dir . 'WAMPageHooks.class.php' ;
$wgAutoloadClasses[ 'WAMPageModel'] =  $dir . 'models/WAMPageModel.class.php' ;

// hooks
$wgHooks['ArticleFromTitle'][] = 'WAMPageHooks::onArticleFromTitle';
$wgHooks['MakeGlobalVariablesScript'][] = 'WAMPageHooks::onMakeGlobalVariablesScript';
$wgHooks['LinkBegin'][] = 'WAMPageHooks::onLinkBegin';
$wgHooks['WikiaCanonicalHref'][] = 'WAMPageHooks::onWikiaCanonicalHref';

// i18n
