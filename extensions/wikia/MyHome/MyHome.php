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
