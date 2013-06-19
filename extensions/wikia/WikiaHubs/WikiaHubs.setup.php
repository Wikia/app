<?php
/**
 * WikiaHubs
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Hyun Lim
 * @author Marcin Maciejewski
 * @author Saipetch Kongkatong
 * @author Sebastian Marzjan
 *
 */

$dir = dirname(__FILE__) . '/';

$wgExtensionCredits['other'][] = array(
		'name'		=> 'WikiaHubs',
		'author'	=> 'Andrzej "nAndy" Łukaszewski,Hyun Lim,Marcin Maciejewski,Saipetch Kongkatong,Sebastian Marzjan',
		'description'	=> 'WikiaHubs',
		'version'	=> 1.0
);

//classes
$wgAutoloadClasses['WikiaHubsSuggestController'] =  $dir.'WikiaHubsSuggestController.class.php';
$wgAutoloadClasses['WikiaHubsPopularVideos'] =  $dir . 'WikiaHubsHook.class.php';
$wgAutoloadClasses['WikiaHubsMobile'] =  $dir . 'WikiaHubsHook.class.php';
$wgAutoloadClasses['WikiaHubsHelper'] =  $dir . 'WikiaHubsHelper.class.php';

// i18n mapping
$wgExtensionMessagesFiles['WikiaHubs'] = $dir . 'WikiaHubs.i18n.php';

// hooks
$wgHooks['ParserFirstCallInit'][] = 'WikiaHubsPopularVideos::onParserFirstCallInit';
$wgHooks['WikiaMobileAssetsPackages'][] = 'WikiaHubsMobile::onWikiaMobileAssetsPackages';
$wgHooks['WikiaAssetsPackages'][] = 'WikiaHubsHelper::onWikiaAssetsPackages';
$wgHooks['OutputPageMakeCategoryLinks'][] = 'WikiaHubsHelper::onOutputPageMakeCategoryLinks';
$wgHooks['OutputPageBeforeHTML'][] = 'WikiaHubsHelper::onOutputPageBeforeHTML';
