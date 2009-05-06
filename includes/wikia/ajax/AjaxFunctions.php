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

	$html = '<div class="headerMenu color1 reset" id="headerMenuUser"><ul>';
	foreach($links as $id => $link) {
		$tooltip = !isMsgEmpty('tooltip-pt-'.$id) ?  htmlspecialchars(wfMsg('tooltip-pt-'.$id)) : '';
		$accesskey = !isMsgEmpty('accesskey-pt-'.$id) ?  wfMsg('accesskey-pt-'.$id) : '';
		$html .= '<li id="userMenu-'.$id.'"><a href="'.$link['href'].'" title="'.$tooltip.'" accesskey="'.$accesskey.'">'.htmlspecialchars($link['text']).'</a></li>';
	}
	$html .= '</ul></div>';

	$response = new AjaxResponse();
	$response->addText( $html );
	$response->setCacheDuration( 3600 * 24 * 365 * 10); // 10 years

	return $response;
}
