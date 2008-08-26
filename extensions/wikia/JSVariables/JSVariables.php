<?php
/*
 * Author: Inez Korczyński (inez@wikia.com)
 */

$wgHooks['ExtendJSGlobalVars'][] = 'wfExtendJSGlobalVars';

function wfExtendJSGlobalVars($vars) {
	global $wgCurse, $wgCityId, $wgEnableAjaxLogin, $wgUser, $wgDBname, $wgPrivateTracker, $wgWikiaAdvertiserCategory, $wgExtensionsPath, $wgTitle, $wgArticle, $wgStyleVersion;

	$cats = wfGetBreadCrumb();
	$idx = count($cats)-2;
	if(isset($cats[$idx])) {
	    $vars['wgCatId'] = $cats[$idx]['id'];
	    $vars['wgParentCatId'] = $cats[$idx]['parentId'];
	} else	{
	    $vars['wgCatId'] = 0;
	    $vars['wgParentCatId'] = 0;
	}

	$vars['wgCurse'] = $wgCurse;
	$vars['wgCityId'] = $wgCityId;
	$vars['wgID'] = isset($wgCityId) ? (int) $wgCityId : -1; // this one or one above should be deleted
	$vars['wgEnableAjaxLogin'] = (is_array($wgEnableAjaxLogin)) ? in_array($vars['skin'], $wgEnableAjaxLogin) : false;
	$vars['wgReturnTo'] = isset($_REQUEST['returnto']) ? $_REQUEST['returnto'] : '';
	$vars['wgDB'] = $wgDBname;
	$vars['wgPrivateTracker'] = !empty($wgPrivateTracker) ? $wgPrivateTracker : false;
	if($vars['wgIsArticle'] == false && $vars['wgEnableAjaxLogin']) {
		$vars['ajaxLogin1'] = wfMsg('ajaxLogin1');
		$vars['ajaxLogin2'] = wfMsg('ajaxLogin2');
	}
	$vars['wgMainpage'] = wfMsgForContent( 'mainpage' );
	$vars['wgIsMainpage'] = $wgTitle->getArticleId() == Title::newMainPage()->getArticleId();
	if(!$vars['wgIsMainpage']) {
		if(!empty($wgArticle->mRedirectedFrom)) {
			if($vars['wgMainpage'] == $wgArticle->mRedirectedFrom->getPrefixedText()) {
				$vars['wgIsMainpage'] = true;
			}
		}
	}

	$vars['wgStyleVersion'] = isset($wgStyleVersion) ? $wgStyleVersion : '' ;
	if(isset($wgUser->getSkin()->themename)) {
		$vars['themename'] = $wgUser->getSkin()->themename;
	}

	$vars['wgExtensionsPath'] = $wgExtensionsPath;

	return true;
}
?>
