<?php
/****************

FAST has been disabled from this release forward 

***************/
return;

if(!defined('MEDIAWIKI')) {
	die(1);
}

$wgExtensionCredits['other'][] = array(
    'name' => 'FAST',
    'author' => 'Inez Korczyński, Christian Williams',
);

$wgHooks['AfterCategoryPageView'][] = 'fastProcessCategory';
$wgHooks['OutputPageBeforeHTML'][] = 'fastProcess';
$wgHooks['UserToggles'][] = 'fastUserToggle';
$wgFASTCalled = false;

function fastUserToggle(&$extraToggle) {
	$extraToggle[] = 'showAds';
	return true;
}

function fastGetConfig() {
	global $wgTitle, $wgArticle, $wgRequest, $wgUser, $wgEnableFAST_HOME2;

	$mainpage = $wgTitle->getArticleId() == Title::newMainPage()->getArticleId();
	$isContentPage = in_array($wgTitle->getNamespace(), array(NS_MAIN, NS_IMAGE, NS_CATEGORY)) || $wgTitle->getNamespace() >= 100;
	$isView = $wgRequest->getVal('action', 'view') == 'view';
	$isPreview = $wgRequest->getVal('wpPreview') != '' && $wgRequest->getVal('action') == 'submit';

	if($wgUser->isLoggedIn()) {
		$showAds = $wgUser->getOption('showAds');
	} else {
		$showAds = true;
	}

	$showAds = $wgRequest->getBool('showads', $showAds);

	$fastConfig = array();

	if($mainpage) {
		if(($isView && $wgTitle->exists()) || $isPreview) {
			$fastConfig[] = 'FAST_HOME1';
			if(!empty($wgEnableFAST_HOME2)) {
				$fastConfig[] = 'FAST_HOME2';
			}
		}

		if($isView) {
			$fastConfig[] = 'FAST_HOME3';
			$fastConfig[] = 'FAST_HOME4';
		}
	} else {
		if($showAds) {
			if($isContentPage && $isView) {
				$fastConfig[] = 'FAST_SIDE';
			}
			if($isContentPage && (($isView && $wgTitle->exists()) || $isPreview)) {
				$fastConfig[] = 'FAST_TOP';
				$fastConfig[] = 'FAST_BOTTOM';
			}
		}
	}

	return $fastConfig;
}

function fastProcessCategory($page) {
	global $wgOut;
	$text = $wgOut->getHTML();
	fastProcess($wgOut, $text, true);
	$wgOut->clearHTML();
	$wgOut->addHTML($text);
	return true;
}

function fastProcess(&$out, &$text, $category = false) {
	global $wgFASTSIDE, $wgFASTCalled, $wgTitle;

	if($wgFASTCalled == true ||($category == false && $wgTitle->getNamespace() == NS_CATEGORY)) {
		return true;
	}

	$fastConfig = fastGetConfig();

	if(in_array('FAST_TOP', $fastConfig)) {
		$text = AdServer::getInstance()->getAd('FAST_TOP').$text;
	} else {
		if(in_array('FAST_HOME2', $fastConfig)) {
			//$text = AdServer::getInstance()->getAd('FAST_HOME2').$text;
			$text = AdServer::getInstance()->getAd('HOME_TOP_RIGHT_BOXAD').$text;
		}
		if(in_array('FAST_HOME1', $fastConfig)) {
			//$text = AdServer::getInstance()->getAd('FAST_HOME1').$text;
			$text = AdServer::getInstance()->getAd('HOME_TOP_LEADERBOARD').$text;
		}
	}
	/*
	$headlineArray = array(
		strrpos($text, '</span></h1>'),
		strrpos($text, '</span></h2>'),
		strrpos($text, '</span></h3>'),
		strrpos($text, '</span></h4>'),
		strrpos($text, '</span></h5>'),
		strrpos($text, '</span></h6>')
	);
	rsort($headlineArray);

	$pos = $headlineArray[0];

	if(in_array('FAST4', $fastConfig)) {
		if($pos > -1) {
			$text = substr($text, 0, $pos + 12).AdServer::getInstance()->getAd('FAST4').substr($text, $pos + 12);
		} else {
			$fastConfig[] = 'FAST_BOTTOM';
		}
	}

	if(in_array('FAST_BOTTOM', $fastConfig)) {
		if($pos > -1) {
			$text = substr($text, 0, $pos + 12).AdServer::getInstance()->getAd('FAST_BOTTOM').substr($text, $pos + 12);
			$adContainer = '<div id="adSpaceFAST5"></div>';
		} else {
			$adContainer = AdServer::getInstance()->getAd('FAST5');
		}
		$text .= '<div id="fast_bottom_ads" style="display: none;"><a name="Advertisement"></a><h2><span class="mw-headline">'.wfMsg('fast-adv').'</span></h2>'.$adContainer.'</div>';
	}
	*/

	if(in_array('FAST_SIDE', $fastConfig)) {
		$wgFASTSIDE[0] = AdServer::getInstance()->getAd('FAST_SIDE');
		$wgFASTSIDE[1] = '<div id="adSpaceFAST7"></div>';
	} else {
		if(in_array('FAST_HOME3', $fastConfig)) {
			$wgFASTSIDE[0] = AdServer::getInstance()->getAd('FAST_HOME3');
		}
		if(in_array('FAST_HOME4', $fastConfig)) {
			$wgFASTSIDE[1] = AdServer::getInstance()->getAd('FAST_HOME4');
		}
	}

	return true;
}
