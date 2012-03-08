<?php
/*
 * Widget Framework
 * @author Inez Korczyński
 */
if(!defined('MEDIAWIKI')) {
	die(1);
}

$wgExtensionCredits['specialpage'][] = array(
    'name' => 'WidgetFramework',
    'author' => 'Inez Korczyński',
    'descriptionmsg' => 'widgetframework-desc',
);

$wgAutoloadClasses["ReorderWidgets"] = "$IP/extensions/wikia/WidgetFramework/ReorderWidgets.php";
$wgAutoloadClasses["WidgetFramework"] = "$IP/extensions/wikia/WidgetFramework/WidgetFramework.class.php";

$wgHooks["ReorderWidgets"][] = "ReorderWidgets::WF";
$wgExtensionMessagesFiles['WidgetFramework'] = dirname(__FILE__) . '/WidgetFramework.i18n.php';

$wgAjaxExportList[] = 'WidgetFrameworkAjax';
function WidgetFrameworkAjax() {
	global $wgRequest, $wgUser;
	$response = array();
	$actionType = $wgRequest->getVal('actionType');

	// Widget Add
	if($actionType == 'add' && $wgUser->isLoggedIn()) {
		$output = WidgetFramework::getInstance()->SetSkin($wgRequest->getText('skin'));
		$output = WidgetFramework::getInstance()->Add(
										$wgRequest->getText('type'),
										$wgRequest->getInt('sidebar'),
										$wgRequest->getInt('index'));

		if($output){
			WidgetFramework::getInstance()->Save();
			if($output === true) {
				$response = array('success' => true, 'reload' => true);
			} else {
				$response = array('success' => true, 'widget' => $output, 'type' => $wgRequest->getText('type'));
			}
		} else {
			$response = array('success' => false);
		}
	}

	// Widget Reorder
	if($actionType == 'reorder' && $wgUser->isLoggedIn()) {
		$status = WidgetFramework::getInstance()->Reorder(
										$wgRequest->getInt('id'),
										$wgRequest->getInt('sidebar'),
										$wgRequest->getInt('index'));

		if($status) {
			WidgetFramework::getInstance()->Save();
			$response = array('success' => true);
		} else {
			$response = array('success' => false);
		}
	}

	// Widget Delete
	if($actionType == 'delete' && $wgUser->isLoggedIn()) {
		$status = WidgetFramework::getInstance()->Delete($wgRequest->getInt('id'));
		if($status) {
			WidgetFramework::getInstance()->Save();
			$response = array('success' => true);
		} else {
			$response = array('success' => false);
		}
	}

	// Widget Editform
	if($actionType == 'editform' && $wgUser->isLoggedIn()) {
		$status = WidgetFramework::getInstance()->GetEditForm($wgRequest->getInt('id'));
		if($status) {
			$response = array('success' => true, 'content' => $status);
		} else {
			$response = array('success' => false);
		}
	}

	// Save widget parameters
	if($actionType == 'configure') {
		$status = WidgetFramework::getInstance()->Configure($wgRequest->getInt('id'));
		if($status) {
			WidgetFramework::getInstance()->Save();
			$response = WidgetFramework::getInstance()->GetWidgetBody($wgRequest->getInt('id'));
			$response = array_merge(array('success' => true), $response);
		} else {
			$response = array('success' => false);
		}
	}

	// add widget id
	if (!empty($response)) {
		$response['id'] = $wgRequest->getInt('id');
	}

	// return JSON with proper headers
	$resp = new AjaxResponse(Wikia::json_encode($response));
	$resp->setContentType('application/json; charset=utf-8');
	return $resp;
}

/**
 * @return array
 * @author Maciej Brencz
 * @author Inez Korczynski <inez@wikia.com>
 */
function WidgetFrameworkCallAPI($params) {
	wfProfileIn(__METHOD__);
	$output = array();
	try {
		$api = new ApiMain(new FauxRequest($params));
		$api->execute();
		$output = $api->getResultData();
	} catch(Exception $e) { };
	wfProfileOut( __METHOD__ );
	return $output;
}

/**
 * @return string
 * @author Inez Korczynski <inez@wikia.com>
 */
function WidgetFrameworkWrapLinks($links) {
	wfProfileIn(__METHOD__);
	$out = '';
	if(is_array($links) && count($links) > 0) {
		$out = '<ul>';
		foreach($links as $link) {
			$out .= '<li>';
			$out .= '<a href="'.htmlspecialchars($link['href']).'"'.(isset($link['title']) ? ' title="'.htmlspecialchars($link['title']).'"' : '').(!empty($link['nofollow']) ? ' rel="nofollow"' : '').'>'.htmlspecialchars($link['name']).'</a>';
			if(isset($link['desc'])) {
				$out .= '<br/>'.$link['desc'];
			}
			$out .= '</li>';
		}
		$out .= '</ul>';
	}
	wfProfileOut( __METHOD__ );
	return $out;
}

/**
 * @return string
 * @author Maciej Brencz
 */
function WidgetFrameworkMoreLink($link) {
	wfProfileIn(__METHOD__);
	$out = '<div class="widgetMore"><a href="'.htmlspecialchars($link).'">'.wfMsg('moredotdotdot').'</a></div>';
	wfProfileOut( __METHOD__ );
	return $out;
}

/**
 * @return string
 * @author Inez Korczyński
 * @author Maciej Brencz
 */
function WidgetFrameworkGetArticle($title, $ns = NS_MAIN ) {
	$titleObj = Title::newFromText($title, $ns);
	if ( !is_object($titleObj) ) {
		return false;
	}
	$revision = Revision::newFromTitle( $titleObj );
	if(is_object($revision)) {
		return $revision->getText();
	}
	return false;
}
