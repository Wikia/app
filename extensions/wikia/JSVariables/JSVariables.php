<?php
/*
 * Author: Inez Korczyński (inez@wikia.com)
 */

$wgExtensionCredits[ 'other' ][ ] = array(
	'name' => 'JSVariables',
	'author' => 'Inez Korczyński (inez@wikia.com)',
	'descriptionmsg' => 'jsvariables-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/JSVariables',
);

//i18n
$wgExtensionMessagesFiles[ 'JSVariables' ] = __DIR__ . '/JSVariables.i18n.php';

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
	$vars['wgCdnRootUrl'] = $wg->CdnRootUrl;
	$vars['wgCdnApiUrl'] = $wg->CdnApiUrl;
	// make sure window.Mercury is not defined in Oasis
	$vars['Mercury'] = null;

	// analytics needs it (from here till the end of the function)
	$vars['wgDBname'] = $wg->DBname;
	$vars['wgCityId'] = $wg->CityId;

	// c&p from OutputPage::getJSVars with an old 1.16 name
	$vars['wgContentLanguage'] = $title->getPageLanguage()->getCode();

	// c&p from OutputPage::getJSVars, it's needed earlier
	$user = $wg->User; /** @var $user User */
	if ($user->isAnon()) {
		$vars['wgUserName'] = null;
	} else {
		$vars['wgUserName'] = $user->getName();
		$vars['wgUserId'] = $user->getId();
		$vars['wgUserIsSubjectToCcpa'] = $user->isSubjectToCcpa();
	}
	if ($out->isArticle()) {
		$vars['wgArticleId'] = $out->getWikiPage()->getId();
		$vars['wgVideoBridgeCountries'] = WikiFactory::getVarValueByName(
			'wgVideoBridgeCountries',
			WikiFactory::COMMUNITY_CENTRAL
		);
	}
	$vars['wgCategories'] = $out->getCategories();
	$vars['wgPageName'] = $title->getPrefixedDBKey();
	$vars['wikiaPageType'] = WikiaPageType::getPageType();
	$vars['wikiaPageIsCorporate'] = WikiaPageType::isCorporatePage();
	$vars['wgArticleType'] = WikiaPageType::getArticleType();
	$vars['wgNamespaceNumber'] = $title->getNamespace();

	// missing in 1.19
	$skin = RequestContext::getMain()->getSkin();
	$vars['skin'] = $skin->getSkinName();

	// for Google Analytics
	$vars['_gaq'] = array();
	$vars['wgIsGASpecialWiki'] = $wg->IsGASpecialWiki;

	// PER-58: moved wgStyleVersion to <head>
	$vars['wgStyleVersion'] = (string)($wg->StyleVersion);

	$wg->NoExternals = $wg->Request->getBool('noexternals', $wg->NoExternals);
	if (!empty($wg->NoExternals)) {
		$vars["wgNoExternals"] = $wg->NoExternals;
	}

	$vars['wgTransactionContext'] = Transaction::getAttributes();

	$scripts .= Html::inlineScript("var wgNow = new Date();") . "\n";

	return true;
}

/**
 * MW1.19 - ResourceLoaderStartUpModule class adds more variables
 * @param array $vars JS variables to be added at the bottom of the page
 * @param OutputPage $out
 * @return bool return true - it's a hook
 */
function wfMakeGlobalVariablesScript(Array &$vars, OutputPage $out) {
	wfProfileIn(__METHOD__);
	global $wgMemc, $wgPrivateTracker, $wgExtensionsPath,
		$wgArticle, $wgSitename, $wgDisableAnonymousEditing, $wgCityId,
		$wgGroupPermissions, $wgBlankImgUrl, $wgEnableNewAuthModal, $wgResourceBasePath;

	$skin = $out->getSkin();
	$title = $out->getTitle();

	// FIXME: This needs to be converted to getVerticalId when the data is available (PLATFORM-267)
	$hubService = WikiFactoryHub::getInstance();
	$catId = $hubService->getCategoryId( $wgCityId );
	if( isset( $catId ) ) {
		$vars['wgCatId'] = $catId;
	} else	{
		$vars['wgCatId'] = 0;
	}

	$vars['wgBlankImgUrl'] = $wgBlankImgUrl;

	if (!empty($wgPrivateTracker)) {
		$vars['wgPrivateTracker'] = true;
	}

	// TODO: use wgMainPageTitle instead?
	$vars['wgMainpage'] = wfMsgForContent( 'mainpage' );
	if (Wikia::isMainPage()) {
		$vars['wgIsMainpage'] = true;
	}
	if (Wikia::isContentNamespace()) {
		$vars['wgIsContentNamespace'] = true;
	}

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

	$vars['wgEnableNewAuthModal'] = $wgEnableNewAuthModal;

	wfProfileOut(__METHOD__);
	return true;
}

