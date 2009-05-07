<?php

$wgAjaxExportList[] = 'GetHubMenu';
function GetHubMenu() {
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
	$links = array();

	$links['userpage'] = array(
		'text' => wfMsg('mypage'),
		'href' => Title::newFromText($userName, NS_USER)->getLocalURL()
		);

	$links['mycontris'] = array(
		'text' => wfMsg('mycontris'),
		'href' => Title::newFromText('Contributions/'.$userName, NS_SPECIAL)->getLocalURL()
		);

	$links['widgets'] = array(
		'text' => wfMsg('manage_widgets'),
		'href' => '#'
		);

	$links['preferences'] = array(
		'text' => wfMsg('preferences'),
		'href' => Title::newFromText('Preferences', NS_SPECIAL)->getLocalURL()
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
