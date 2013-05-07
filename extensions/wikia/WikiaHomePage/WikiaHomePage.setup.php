<?php
/**
 * WikiaHomePage
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Hyun Lim
 * @author Marcin Maciejewski
 * @author Saipetch Kongkatong
 * @author Sebastian Marzjan
 */

$dir = dirname(__FILE__) . '/';
$app = F::app();

$wgExtensionCredits['other'][] = array(
	'name'			=> 'WikiaHomePage',
	'author'		=> 'Andrzej "nAndy" Łukaszewski, Hyun Lim, Marcin Maciejewski, Saipetch Kongkatong, Sebastian Marzjan',
	'description'	=> 'WikiaHomePage',
	'version'		=> 1.0
);

// helper hierarchy
// row assigners
$wgAutoloadClasses['WikiImageRowAssigner'] = $dir.'classes/WikiImageRowAssigner.class.php';
$wgAutoloadClasses['WikiImageRowHelper'] = $dir.'classes/WikiImageRowHelper.class.php';
$wgAutoloadClasses['WikiImageNameRowHelper'] = $dir.'classes/WikiImageNameRowHelper.class.php';
$wgAutoloadClasses['WikiImageReviewStatusRowHelper'] = $dir.'classes/WikiImageReviewStatusRowHelper.class.php';

// getdata helpers
$wgAutoloadClasses['WikiGetDataHelper'] = $dir.'classes/WikiGetDataHelper.class.php';
$wgAutoloadClasses['WikiGetDataForVisualizationHelper'] = $dir.'classes/WikiGetDataForVisualizationHelper.class.php';
$wgAutoloadClasses['WikiGetDataForPromoteHelper'] = $dir.'classes/WikiGetDataForPromoteHelper.class.php';
$wgAutoloadClasses['WikiDataGetter'] = $dir.'classes/WikiDataGetter.class.php';
$wgAutoloadClasses['WikiDataGetterForSpecialPromote'] = $dir.'classes/WikiDataGetterForSpecialPromote.class.php';
$wgAutoloadClasses['WikiDataGetterForVisualization'] = $dir.'classes/WikiDataGetterForVisualization.class.php';

//classes
$wgAutoloadClasses['WikiaHomePageController'] =  $dir.'WikiaHomePageController.class.php';
$wgAutoloadClasses['WikiaHomePageHelper'] =  $dir.'WikiaHomePageHelper.class.php';
$wgAutoloadClasses['CityVisualization'] =  $dir.'CityVisualization.class.php';

//i18n mapping
$wgExtensionMessagesFiles['WikiaHomePage'] = $dir.'WikiaHomePage.i18n.php';
JSMessages::registerPackage('WikiaHomePage', array('wikia-home-page-*'));

$app->registerHook('GetHTMLAfterBody', 'WikiaHomePageController', 'onGetHTMLAfterBody');
$app->registerHook('OutputPageBeforeHTML', 'WikiaHomePageController', 'onOutputPageBeforeHTML');
$app->registerHook('WikiaMobileAssetsPackages', 'WikiaHomePageController', 'onWikiaMobileAssetsPackages');
$app->registerHook('ArticleCommentCheck', 'WikiaHomePageController', 'onArticleCommentCheck');
$app->registerHook('AfterGlobalHeader', 'WikiaHomePageController', 'onAfterGlobalHeader');
