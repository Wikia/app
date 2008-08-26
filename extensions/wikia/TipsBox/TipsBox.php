<?php
/**
 * Created on 2007-01-24
 * author: Inez Korczyński (inez@wikia.com)
 * author: Gerard Adamczewski (gerard@wikia.com)
 */

if(!defined('MEDIAWIKI')) {
	die();
	die();
}

require_once( $IP . '/extensions/wikia/WikiCurl/WikiCurl.php' );

global $wgWhitelistRead;
$wgWhitelistRead[] = 'Special:Tips';
/*
global $wgAvailableRights, $wgGroupPermissions;
$wgAvailableRights [] = 'tips';
$wgGroupPermissions['*']['tips'] = true;
$wgGroupPermissions['user']['tips'] = true;
$wgGroupPermissions['staff']['tips'] = true;
$wgGroupPermissions['bureaucrat']['tips'] = true;
*/

/** Set function to initialize extension */
$wgExtensionFunctions[] = 'TipsBox_Setup';
$wgSpecialPages['Tips'] = new SpecialPage('Tips');


function wfSpecialTips() {
	global $wgOut, $wgRequest;

	$which = $wgRequest->getText('w');
	if($which == 'p') { // previous
		echo TipsBox_GetTip(-2);
	} else {
		echo TipsBox_GetTip();
	}
	die();
}

/**
 * Initialize extension
 */
function TipsBox_Setup() {
	global $wgHooks, $wgMessageCache;
	$wgHooks['MonoBookTemplateTipsStart'][] = 'TipsBox_Display';
	$wgMessageCache->addMessage ('tips', 'Tips');
}

function TipsBox_GetLastIndex() {
	global $wgCookiePrefix;

/* begin - gerard@wikia.com */
	if(isset($_COOKIE[$wgCookiePrefix . '_TipsLastIndex'])) {
		return $_COOKIE[$wgCookiePrefix . '_TipsLastIndex'];
	//if(isset($_SESSION['wsTipsLastIndex'])) {
		//return $_SESSION['wsTipsLastIndex'];
/* end - gerard@wikia.com */
	} else {
		return -1;
	}
}

function TipsBox_SaveNewIndex($index) {
	global $wgCookiePrefix, $wgCookiePath, $wgCookieSecure;
/* begin - gerard@wikia.com */
	setcookie( $wgCookiePrefix.'_TipsLastIndex', $index);
	//$_SESSION['wsTipsLastIndex'] = $index;
/* end - gerard@wikia.com */
}

function TipsBox_GetTip($offset = 0) {
	global $wgTipsBoxUrl;

	# get Template:Tips Title object
	$tipsTitle = Title::newFromText("Tips", NS_TEMPLATE);

	# if Template:Tips doesn't exists then return
	if ( $tipsTitle->exists() ) {
		$tipsArticle = new Article($tipsTitle);

		# get Template:Tips article content..
		$tips = $tipsArticle->getContent();

		# ..end then explode tips (one per line) from it..
		$tipsArray = explode("\n", $tips);
	} else {
		$tipsArray = array();
	}

/* begin - gerard@wikia.com */
	$curl = new WikiCurl();
	$centralTips = strstr( $curl->post($wgTipsBoxUrl, array('action'=>'raw')), "*" ); // removing http header up to first star *
	$centralTipsArray = explode("\n", $centralTips);
	$tipsArray = array_merge( $tipsArray, $centralTipsArray );
/* end - gerard@wikia.com */

	# ..and count them
	$tipsCount = count($tipsArray);

	# if there is no tips in Template:Tips so return
	if( $tipsCount < 1) {
		return false;
	}

	# get from cookie index of last displayed tip (-1 if not displayed)

	$lastTipIndex = TipsBox_GetLastIndex();
/* begin - gerard@wikia.com */
	if( $lastTipIndex == -1 ) {
		$lastTipIndex = rand(0, $tipsCount) - 1;
	}
/* end - gerard@wikia.com */

	$newTipIndex = $lastTipIndex + 1 + $offset;
	if($newTipIndex >= $tipsCount) {
		$newTipIndex = 0;
	} else if( !isset ($tipsArray[$newTipIndex]) || $tipsArray[$newTipIndex] == '') {
		$newTipIndex = 0;
	}

	if($lastTipIndex == $newTipIndex) {
		$newTipIndex = $tipsCount - 1;
	}

	# save in cookie index of now displayed tip
	TipsBox_SaveNewIndex($newTipIndex);

	# return wikitext content tip
	global $wgOut;
	return $wgOut->parse($tipsArray[$newTipIndex]);
}


function TipsBox_Display($cos) {
	global $wgTipsChangeTime;

	$tipsTitle = Title::newFromText("Tips", NS_TEMPLATE);

	if(($tip = TipsBox_GetTip()) === false) {
		return;
	}

	$target = Title::newFromText("Tips", NS_SPECIAL);
	$url = $target->getFullURL() . "?w=";

	echo '<script type=\'text/javascript\'>
	var reqTips;
	var autoTips='.((isset($wgTipsChangeTime) && is_int($wgTipsChangeTime)) ? 'true' : 'false').';
	var onTimerFlag = true;
	function tip(w) {
		if( (autoTips==false) && (onTimerFlag==true) )
		{
			onTimerFlag = false;
			return;
		}
		try {
			reqTips = new XMLHttpRequest();
		} catch (error) {
			try {
				reqTips = new ActiveXObject(\'Microsoft.XMLHTTP\');
			} catch (error) {
				return false;
			}
		}
		reqTips.onreadystatechange = processReqChangeTips;
		reqTips.open(\'GET\', \''.$url.'\' + w);
		reqTips.send(null);
		if(autoTips==true) {
			setTimeout( \'tip("n")\', '.($wgTipsChangeTime*1000).');
		}
	}
	function processReqChangeTips() {
		if (reqTips.readyState == 4) {
			if (reqTips.status == 200) {
				if(reqTips.responseText != \'\') {
					document.getElementById(\'p-tips-body\').innerHTML = reqTips.responseText;
				}
			}
		}
	}
	function clickTip(w) {
		autoTips = false;
		tip(w);
	}
	if(autoTips==true) {
		setTimeout( \'tip("n")\', '.($wgTipsChangeTime*1000).');
	}
	</script>';


	echo '<div class="portlet" id="p-tips">
	<h5>'.wfMsgHtml('tips').'</h5>
		<div class="pBody">
			<div id="p-tips-body">'.$tip.'</div>
			<hr />
			<div style="float:left;font-size: 95%;"><a href="#" onClick="clickTip(\'p\'); return false;">'.wfMsgHtml('allpagesprev').'</a></div>
			<div style="float:right;font-size: 95%;"><a href="#" onClick="clickTip(\'n\'); return false;">'.wfMsgHtml('allpagesnext').'</a></div>
			<br style="clear:both"/>
			<div style="text-align: center; font-size: 95%;"><a href="'.$tipsTitle->getFullURL().'">'.wfMsgHtml('moredotdotdot').'</a></div>
		</div>
	</div>';
	return;
}
?>
