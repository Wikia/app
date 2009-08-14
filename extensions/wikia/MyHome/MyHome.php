<?php
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'My Home',
	'description' => 'A private home of Wikia for logged-in users',
	'author' => array('Inez Korczyński', 'Maciej Brencz', 'Maciej Błaszkowski (Marooned)')
);

$dir = dirname(__FILE__) . '/';

// special page
$wgAutoloadClasses['SpecialMyHome'] = $dir . 'SpecialMyHome.php';
$wgSpecialPages['MyHome'] = 'SpecialMyHome';

//
// register extension classes
//
$wgAutoloadClasses['MyHome'] = $dir . 'MyHome.class.php';
$wgAutoloadClasses['MyHomeAjax'] = $dir . 'MyHomeAjax.class.php';

// feed providers
$wgAutoloadClasses['FeedProvider'] = $dir . '/feeds/FeedProvider.php';
$wgAutoloadClasses['ActivityFeedProvider'] = $dir . '/feeds/ActivityFeedProvider.php';
$wgAutoloadClasses['WatchlistFeedProvider'] = $dir . '/feeds/WatchlistFeedProvider.php';
$wgAutoloadClasses['UserContributionsProvider'] = $dir . 'UserContributionsProvider.php';

// feed renderers
$wgAutoloadClasses['FeedRenderer'] = $dir . 'FeedRenderer.php';
$wgAutoloadClasses['ActivityFeedRenderer'] = $dir . 'ActivityFeedRenderer.php';
$wgAutoloadClasses['UserContributionsRenderer'] = $dir . 'UserContributionsRenderer.php';
$wgAutoloadClasses['WatchlistFeedRenderer'] = $dir . 'WatchlistRenderer.php';

// hooks
$wgHooks['RecentChange_beforeSave'][] = 'MyHome::storeInRecentChanges';
//$wgHooks['CustomUserData'][] = 'MyHome::addToUserMenu';
$wgHooks['EditFilter'][] = 'MyHome::getSectionName';
//$wgHooks['InitialQueriesMainPage'][] = 'MyHome::getInitialMainPage';

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
