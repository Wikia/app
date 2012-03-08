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

$wgExtensionMessagesFiles['WidgetFramework'] = dirname(__FILE__) . '/WidgetFramework.i18n.php';

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
