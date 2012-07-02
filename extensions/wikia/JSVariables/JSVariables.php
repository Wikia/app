<?php
/*
 * Author: Inez Korczyński (inez@wikia.com)
 */

$wgHooks['MakeGlobalVariablesScript'][] = 'wfMakeGlobalVariablesScript';
$wgHooks['WikiaSkinTopScripts'][] = 'wfJSVariablesTopScripts';

function wfJSVariablesTopScripts(Array $vars) {
	$vars['wgAfterContentAndJS'] = array();
	return true;
}

function wfMakeGlobalVariablesScript(Array $vars, OutputPage $out) {
	wfProfileIn(__METHOD__);
	global $wgMemc, $wgCityId, $wgEnableAjaxLogin, $wgDBname, $wgPrivateTracker, $wgExtensionsPath,
		$wgArticle, $wgStyleVersion, $wgSitename, $wgWikiFactoryTags, $wgDisableAnonymousEditing,
		$wgGroupPermissions, $wgBlankImgUrl, $wgCookieDomain, $wgCookiePath;

	$skin = $out->getSkin();
	$title = $out->getTitle();

	// MW1.19 - ResourceLoaderStartUpModule class adds more variables
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

	$skinName = get_class($skin);
	if (is_array($wgEnableAjaxLogin) && in_array($skinName, $wgEnableAjaxLogin)) {
		$vars['wgEnableAjaxLogin'] = true;
	}
	$vars['wgDBname'] = $wgDBname;
	if (!empty($wgMedusaSlot)) {
		$vars['wgMedusaSlot'] = 'slot' . $wgMedusaSlot;
	}

	$vars['wgBlankImgUrl'] = $wgBlankImgUrl;

	if (!empty($wgPrivateTracker)) {
		$vars['wgPrivateTracker'] = true;
	}

	// TODO: load it on-demand using JSMessages
	if($vars['wgIsArticle'] == false && !empty($vars['wgEnableAjaxLogin'])) {
		$vars['ajaxLogin1'] = wfMsg('ajaxLogin1');
		$vars['ajaxLogin2'] = wfMsg('ajaxLogin2');
	}

	// TODO: use wgMainPageTitle instead?
	$vars['wgMainpage'] = wfMsgForContent( 'mainpage' );
	if (Wikia::isMainPage()) {
		$vars['wgIsMainpage'] = true;
	}
	if (Wikia::isContentNamespace()) {
		$vars['wgIsContentNamespace'] = true;
	}

	$vars['wgStyleVersion'] = isset($wgStyleVersion) ? $wgStyleVersion : '' ;
	if(isset($skin->themename)) {
		$vars['themename'] = $skin->themename;
	}

	$vars['wgExtensionsPath'] = $wgExtensionsPath;
	$vars['wgSitename'] = $wgSitename;

	// Set the JavaScript variable which is used by AJAX request to make data caching possible - Inez
	$vars['wgMWrevId'] = $wgMemc->get(wfMemcKey('wgMWrevId'));

	// not used anymore - we use ResourceLoader to load YUI - @author: wladek
	// TODO: remove after confirmation
	// RT #21084: get URL to YUI package
//	$yuiUrl = array_pop(AssetsManager::getInstance()->getGroupCommonURL('yui', array(), true /* $combine */, true /* $minify */));
//	$vars['wgYUIPackageURL'] = $yuiUrl;

	// macbre: get revision ID of current article
	if ( ( $title->isContentPage() || $title->isTalkPage() ) && !is_null($wgArticle)) {
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
