<?php

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'My Home',
	'description' => 'A private home of Wikia for logged-in users',
	'author' => array('Inez Korczyński', 'Maciej Brencz', 'Maciej Błaszkowski (Marooned)')
);

$dir = dirname(__FILE__) . '/';

// special page
$wgAutoloadClasses['SpecialMyHome'] = $dir.'SpecialMyHome.php';
$wgSpecialPages['MyHome'] = 'SpecialMyHome';
$wgSpecialPageGroups['MyHome'] = 'users';

// register extension classes
$wgAutoloadClasses['MyHome'] = $dir.'MyHome.class.php';
$wgAutoloadClasses['MyHomeAjax'] = $dir.'MyHomeAjax.class.php';

/// data providers
$wgAutoloadClasses['iAPIProxy'] = $dir . 'data/iAPIProxy.php';
$wgAutoloadClasses['DataFeedProvider'] = $dir . 'data/DataFeedProvider.php';
$wgAutoloadClasses['ActivityFeedAPIProxy'] = $dir . 'data/ActivityFeedAPIProxy.php';
$wgAutoloadClasses['WatchlistFeedAPIProxy'] = $dir . 'data/WatchlistFeedAPIProxy.php';

$wgAutoloadClasses['HotSpotsProvider'] = $dir.'data/HotSpotsProvider.php';
$wgAutoloadClasses['UserContributionsProvider'] = $dir.'data/UserContributionsProvider.php';

// renderers
$wgAutoloadClasses['FeedRenderer'] = $dir.'renderers/FeedRenderer.php';
$wgAutoloadClasses['ActivityFeedRenderer'] = $dir.'renderers/ActivityFeedRenderer.php';
$wgAutoloadClasses['WatchlistFeedRenderer'] = $dir.'renderers/WatchlistRenderer.php';

$wgAutoloadClasses['HotSpotsRenderer'] = $dir.'renderers/HotSpotsRenderer.php';
$wgAutoloadClasses['UserContributionsRenderer'] = $dir.'renderers/UserContributionsRenderer.php';

// hooks
$wgHooks['RecentChange_beforeSave'][] = 'MyHome::storeInRecentChanges';
$wgHooks['CustomUserData'][] = 'MyHome::addToUserMenu';
$wgHooks['EditFilter'][] = 'MyHome::getSectionName';
$wgHooks['InitialQueriesMainPage'][] = 'MyHome::getInitialMainPage';
$wgHooks['LinksUpdateComplete'][] = 'MyHome::getInserts';
$wgHooks['UserToggles'][] = 'MyHome::userToggles';
$wgHooks['AddNewAccount2'][] = 'MyHome::addNewAccount';

// i18n
$wgExtensionMessagesFiles['MyHome'] = $dir . 'MyHome.i18n.php';

// Ajax dispatcher
$wgAjaxExportList[] = 'MyHomeAjax';
function MyHomeAjax() {
	global $wgUser;
	if ($wgUser->isAnon()) {
		return;
	}

	global $wgRequest;
	$method = $wgRequest->getVal('method', false);

	if (method_exists('MyHomeAjax', $method)) {
		wfLoadExtensionMessages('MyHome');

		$data = MyHomeAjax::$method();
		$json = Wikia::json_encode($data);

		$response = new AjaxResponse($json);
		$response->setContentType('application/json; charset=utf-8');
		return $response;
	}
}

#####

$wgExtensionFunctions[] = 'ActivityFeedTag_setup';

function ActivityFeedTag_setup() {
	global $wgParser;
	wfLoadExtensionMessages('MyHome');
	wfLoadExtensionMessages('Masthead');
	$wgParser->setHook('activityfeed', 'ActivityFeedTag_render');
    return true;
}

function ActivityFeedTag_render(&$parser) {
	global $wgOut, $wgStyleVersion, $wgExtensionsPath;

	$feedProxy = new ActivityFeedAPIProxy();
	$feedRenderer = new ActivityFeedRenderer();

	$feedProvider = new DataFeedProvider($feedProxy);
	$feedData = $feedProvider->get(10);
	if(!isset($feedData['results']) || count($feedData['results']) == 0) {
		return '';
	}
	$feedHTML = $feedRenderer->render($feedData, false);
	$feedHTML = str_replace("\n", '', $feedHTML);

	return "<script type=\"text/javascript\" src=\"{$wgExtensionsPath}/wikia/MyHome/ActivityFeedTag.js?{$wgStyleVersion}\"></script><style type=\"text/css\">@import url({$wgExtensionsPath}/wikia/MyHome/ActivityFeedTag.css?{$wgStyleVersion});</style>".'<div class="myhome-feed myhome-activity-feed clearfix">'.$feedHTML.'</div>';
}
