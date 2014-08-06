<?php

/**
 * MinimalMainPage
 * @author Sean Colombo - derived from VideoPageTool by:
 * @author Garth Webb, Kenneth Kouot, Liz Lee, Saipetch Kongkatong
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'Minimal Main Page',
	'author' => array( '[http://www.seancolombo.com/ Sean Colombo]' ),
	'descriptionmsg' => 'minimalmainpage-desc',
	'version' => '1.0'
);

$dir = dirname(__FILE__) . '/';

// MinimalMainPage shared classes
$wgAutoloadClasses['MinimalMainPageHooks'] =  $dir . 'MinimalMainPageHooks.class.php';

// i18n mapping
$wgExtensionMessagesFiles['MinimalMainPage'] = $dir.'MinimalMainPage.i18n.php';

// hooks
$wgHooks['ArticleFromTitle'][] = 'MinimalMainPageHooks::onArticleFromTitle';
