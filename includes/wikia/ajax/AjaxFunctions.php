<?php

// following functions provide HTML for LeanMonaco drop-down menus
// TODO: move to the skin class

$wgAjaxExportList[] = 'GetHubMenu';
function GetHubMenu() {
	// rt #18795: get category information (id, name, url)
	global $wgCat;

	$cats = wfGetBreadCrumb();
	$idx = count($cats)-2;
	if(isset($cats[$idx])) {
		$wgCat = $cats[$idx];
		wfDebugLog('monaco', 'There is category info');
	} else {
		$wgCat = array('id' => -1);
		wfDebugLog('monaco', 'No category info');
	}

	$tmpl = new EasyTemplate(dirname(__FILE__).'/templates');
	$tmpl->set_vars(array(
		'categorylist' => DataProvider::getCategoryList()
	));

	$response = new AjaxResponse();
	$response->addText( $tmpl->execute('hubMenu') );
	$response->setCacheDuration( 3600 * 24 * 365 * 10); // 10 years

	return $response;
}

$wgAjaxExportList[] = 'GetUserMenu';
function GetUserMenu($userName = '') {
	global $wgEnableWikiaFollowedPages;
	$links = array();

	$userPage = Title::newFromText($userName, NS_USER);

	if (!empty($userPage)) {
		$links['userpage'] = array(
			'text' => wfMsg('mypage'),
			'id' => 'menuMyPage',
			'href' => $userPage->getLocalURL()
			);
	}

	if(!empty($wgEnableWikiaFollowedPages) && $wgEnableWikiaFollowedPages) {
		wfLoadExtensionMessages( 'Follow' );
		$links['follow'] = array(
			'text' => wfMsg('wikiafollowedpages-special-title-userbar'),
			'id' => 'menuMyFollowing',
			'href' => Title::newFromText("Following", NS_SPECIAL )->getLocalUrl()
			);
	}
	
	$userContribs = Title::newFromText('Contributions/'.$userName, NS_SPECIAL);

	if (!empty($userContribs)) {
		$links['mycontris'] = array(
			'text' => wfMsg('mycontris'),
			'id' => 'menuMyContributions',
			'href' => $userContribs->getLocalURL()
			);
	}

	global $wgUser;
        $skin_name = $wgUser->getSkin()->getSkinName();
	if ($skin_name != 'answers'){
	  $links['widgets'] = array(
		'text' => wfMsg('manage_widgets'),
		'id' => 'menuManageWidgets',
		'href' => '#'
		);
	}

	$links['preferences'] = array(
		'text' => wfMsg('preferences'),
		'id' => 'menuPreferences',
		'href' => Skin::makeSpecialUrl('Preferences')
		);

	foreach($links as $id => &$link) {
		$link['tooltip'] = !isMsgEmpty('tooltip-pt-'.$id) ?  htmlspecialchars(wfMsg('tooltip-pt-'.$id)) : '';
		$link['accesskey'] = !isMsgEmpty('accesskey-pt-'.$id) ?  wfMsg('accesskey-pt-'.$id) : '';
	}

	$tmpl = new EasyTemplate(dirname(__FILE__).'/templates');

	$tmpl->set_vars(array(
		'links' => $links,
	));

	$response = new AjaxResponse();
	$response->addText( $tmpl->execute('userMenu') );
	$response->setCacheDuration( 3600 * 24 * 365 * 10); // 10 years

	return $response;
}
