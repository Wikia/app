<?php
/*
 * Author: Inez Korczyński (inez@wikia.com)
 */

$wgHooks['MakeGlobalVariablesScript'][] = 'wfMakeGlobalVariablesScript';
$wgHooks['WikiaSkinTopScripts'][] = 'wfJSVariablesTopScripts';

/**
 * @param array $vars JS variables to be added at the top of the page
 * @param array $scripts JS scripts to add to the top of the page
 * @return bool return true - it's a hook
 */
function wfJSVariablesTopScripts(Array &$vars, &$scripts) {
	$wg = F::app()->wg;

	$title = $wg->Title;
	$out = $wg->Out;

	// ads need it
	$vars['wgAfterContentAndJS'] = array();
	if (is_array($wg->WikiFactoryTags)) {
		$vars['wgWikiFactoryTagIds'] = array_keys( $wg->WikiFactoryTags );
		$vars['wgWikiFactoryTagNames'] = array_values( $wg->WikiFactoryTags );
	}
	$vars['wgCdnRootUrl'] = $wg->CdnRootUrl;

	// analytics needs it (from here till the end of the function)
	$vars['wgDBname'] = $wg->DBname;
	$vars['wgCityId'] = $wg->CityId;
	if (!empty($wg->MedusaSlot)) {
		$vars['wgMedusaSlot'] = 'slot' . $wg->MedusaSlot;
	}

	// c&p from OutputPage::getJSVars with an old 1.16 name
	$vars['wgContentLanguage'] = $title->getPageLanguage()->getCode();

	// c&p from OutputPage::getJSVars, it's needed earlier
	$user = $wg->User; /** @var $user User */
	if ($user->isAnon()) {
		$vars['wgUserName'] = null;
	} else {
		$vars['wgUserName'] = $user->getName();
	}
	if ($out->isArticle()) {
		$vars['wgArticleId'] = $out->getWikiPage()->getId();
	}
	$vars['wgCategories'] = $out->getCategories();
	$vars['wgPageName'] = $title->getPrefixedDBKey();

	// missing in 1.19
	$skin = RequestContext::getMain()->getSkin();
	$vars['skin'] = $skin->getSkinName();

	// analytics/wikiatracker
	$vars['_gaq'] = array();
	$vars['_wtq'] = array();

	$vars['wgIsGASpecialWiki'] = $wg->IsGASpecialWiki;

	$scripts .= Html::inlineScript("var wgNow = new Date();") .	"\n";

	return true;
}

/**
 * @param array $vars JS variables to be added at the bottom of the page
 * @param OutputPage $out
 * @return bool return true - it's a hook
 */
function wfMakeGlobalVariablesScript(Array &$vars, OutputPage $out) {
	wfProfileIn(__METHOD__);
	global $wgMemc, $wgEnableAjaxLogin, $wgPrivateTracker, $wgExtensionsPath,
		$wgArticle, $wgStyleVersion, $wgSitename, $wgDisableAnonymousEditing,
		$wgGroupPermissions, $wgBlankImgUrl, $wgCookieDomain, $wgCookiePath, $wgResourceBasePath;

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

	$skinName = get_class($skin);
	if (is_array($wgEnableAjaxLogin) && in_array($skinName, $wgEnableAjaxLogin)) {
		$vars['wgEnableAjaxLogin'] = true;
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

	// TODO: is this one really needed?
	if(isset($skin->themename)) {
		$vars['themename'] = $skin->themename;
	}

	$vars['wgExtensionsPath'] = $wgExtensionsPath;
	$vars['wgResourceBasePath'] = $wgResourceBasePath;
	$vars['wgSitename'] = $wgSitename;

	// Set the JavaScript variable which is used by AJAX request to make data caching possible - Inez
	$vars['wgMWrevId'] = $wgMemc->get(wfMemcKey('wgMWrevId'));

	// macbre: get revision ID of current article
	if ( ( $title->isContentPage() || $title->isTalkPage() ) && !is_null($wgArticle)) {
		$vars['wgRevisionId'] = !empty($wgArticle->mRevision) ? $wgArticle->mRevision->getId() : intval($wgArticle->mLatest);
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
