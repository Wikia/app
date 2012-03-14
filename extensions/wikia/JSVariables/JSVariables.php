<?php
/*
 * Author: Inez Korczyński (inez@wikia.com)
 */

$wgHooks['MakeGlobalVariablesScript'][] = 'wfMakeGlobalVariablesScript';

function wfMakeGlobalVariablesScript($vars) {
	wfProfileIn(__METHOD__);

	global $wgMemc, $wgCityId, $wgEnableAjaxLogin, $wgUser, $wgDBname, $wgPrivateTracker, $wgExtensionsPath, $wgTitle, $wgArticle, $wgStyleVersion, $wgSitename, $wgWikiFactoryTags, $wgDisableAnonymousEditing, $wgGroupPermissions, $wgBlankImgUrl, $wgCookieDomain, $wgCookiePath;

	$cats = wfGetBreadCrumb();
	$idx = count($cats)-2;
	if(isset($cats[$idx])) {
	    $vars['wgCatId'] = $cats[$idx]['id'];
	    $vars['wgParentCatId'] = $cats[$idx]['parentId'];
	} else	{
	    $vars['wgCatId'] = 0;
	    $vars['wgParentCatId'] = 0;
	}

	$vars['wgCityId'] = $wgCityId;
	$vars['wgID'] = isset($wgCityId) ? (int) $wgCityId : -1; // this one or one above should be deleted
	if (is_array($wgEnableAjaxLogin) && in_array($vars['skin'], $wgEnableAjaxLogin)) {
		$vars['wgEnableAjaxLogin'] = true;
	} else {
		$vars['wgEnableAjaxLogin'] = false;
	}
	$vars['wgDB'] = $wgDBname;
	$vars['wgDBname'] = $wgDBname;
	$vars['wgBlankImgUrl'] = $wgBlankImgUrl;

	// NOTE: This doesn't appear to be used in the code anywhere. If that's true, we can probably remove it.  It is set by the AdEngine though, so perhaps Athena uses it?
	$vars['wgPrivateTracker'] = !empty($wgPrivateTracker) ? $wgPrivateTracker : false;

	if($vars['wgIsArticle'] == false && $vars['wgEnableAjaxLogin']) {
		$vars['ajaxLogin1'] = wfMsg('ajaxLogin1');
		$vars['ajaxLogin2'] = wfMsg('ajaxLogin2');
	}

	// TODO: use wgMainPageTitle instead?
	$vars['wgMainpage'] = wfMsgForContent( 'mainpage' );
	if (Wikia::isMainPage()) {
		$vars['wgIsMainpage'] = true;
	}

	$vars['wgStyleVersion'] = isset($wgStyleVersion) ? $wgStyleVersion : '' ;
	if(isset($wgUser->getSkin()->themename)) {
		$vars['themename'] = $wgUser->getSkin()->themename;
	}

	$vars['wgExtensionsPath'] = $wgExtensionsPath;
	$vars['wgSitename'] = $wgSitename;

	$vars['wgAfterContentAndJS'] = array();

	// Set the JavaScript variable which is used by AJAX request to make data caching possible - Inez
	$vars['wgMWrevId'] = $wgMemc->get(wfMemcKey('wgMWrevId'));

	// RT #21084: get URL to YUI package
	$yuiUrl = array_pop(AssetsManager::getInstance()->getGroupCommonURL('yui', array(), true /* $combine */, true /* $minify */));
	$vars['wgYUIPackageURL'] = $yuiUrl;

	// macbre: get revision ID of current article
	if ( ( $wgTitle->isContentPage() || $wgTitle->isTalkPage() ) && !is_null($wgArticle)) {
		$vars['wgRevisionId'] = !empty($wgArticle->mRevision) ? $wgArticle->mRevision->getId() : intval($wgArticle->mLatest);
	}

	if(isset($wgWikiFactoryTags) && is_array($wgWikiFactoryTags)) {
		$vars['wgWikiFactoryTagIds'] = array_keys( $wgWikiFactoryTags );
		$vars['wgWikiFactoryTagNames'] = array_values( $wgWikiFactoryTags );
	}

	// is anon editing disabled?
	if ( $wgDisableAnonymousEditing || $wgGroupPermissions['user']['edit'] === false ) {
		$vars['wgDisableAnonymousEditing'] = true;
	}

	// moved from Interstitial.php
	$vars['wgCookieDomain'] = $wgCookieDomain;
	$vars['wgCookiePath'] = $wgCookiePath;

	wfProfileOut(__METHOD__);

	return true;
}
