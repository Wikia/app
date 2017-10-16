<?php

class LyricFindHooks {

	/**
	 * Checks whether given page is trackable
	 *
	 * @param Title $title page to check
	 * @return bool is trackable?
	 */
	static public function pageIsTrackable(Title $title) {
		$namespaces = F::app()->wg->LyricFindTrackingNamespaces;
		$isView = F::app()->wg->Request->getVal('action', 'view') === 'view';
		return $isView && in_array($title->getNamespace(), $namespaces) && $title->exists();
	}

	/**
	 * Loads page views tracking code (in Oasis, mobile skin and monobook)
	 *
	 * @param array $jsAssetGroups AssetsManager groups to load
	 * @return bool true
	 */
	static public function onSkinAssetGroups(Array &$jsAssetGroups) {
		$wg = F::app()->wg;
		if (self::pageIsTrackable($wg->Title)) {
			// load:
			// * js/modules/LyricFind.Tracker.js
			// * js/tracking.js
			$jsAssetGroups[] = 'LyricsFindTracking';
		}

		return true;
	}

	/**
	 * Blocks view source page & make it so that users cannot create/edit
	 * pages that are on the takedown list.
	 *
	 * @param EditPage $editPage edit page instance
	 * @return bool show edit page form?
	 */
	static public function onAlternateEdit(EditPage $editPage) {
		$wg = F::app()->wg;
		$title = $editPage->getTitle();

		// Block view-source on the certain pages.
		if($title->exists()){
			// Look at the page-props to see if this page is blocked.
			if(!$wg->user->isAllowed( 'editlyricfind' )){ // some users (staff/admin) will be allowed to edit these to prevent vandalism/spam issues.
				$removedProp = wfGetWikiaPageProp(WPP_LYRICFIND_MARKED_FOR_REMOVAL,
					$title->getArticleID());
				if(!empty($removedProp)){
					$wg->Out->addHTML(Wikia::errorbox(wfMessage('lyricfind-editpage-blocked')));
					$blockEdit = true;
				}
			}
		} else {
			// Page is being created. Prevent this if page is prohibited by LyricFind.
			$blockEdit = LyricFindTrackingService::isPageBlockedViaApi($amgId="", $gracenoteId="", $title->getText());
			if($blockEdit){
				$wg->Out->addHTML(Wikia::errorbox(wfMessage('lyricfind-creation-blocked')));
			}
		}

		return !$blockEdit;
	}

	/**
	 * Register <lyricfind> parser hook
	 *
	 * @param Parser $parser parser instance
	 * @return bool true
	 */
	static public function onParserFirstCallInit(Parser $parser) {
		$parser->setHook(LyricFindParserController::NAME, 'LyricFindParserController::render');
		return true;
	}

	/**
	 * Replace markers generated by <lyricfind> renderer with a proper HTML
	 *
	 * @param Parser $parser parser
	 * @param string $text parser content
	 * @return bool true
	 */
	static public function onParserAfterTidy(Parser $parser, &$text) {
		$text = strtr($text, LyricFindParserController::$markers);
		return true;
	}

	/**
	 * If this song is on takedown list... replace the lyrics content with a message about why
	 * it is gone. This will replace the content of all <lyrics> tags on the page (also <lyricfind>
	 * and <gracenotelyrics> tags for support of legacy pages).
	 *
	 * @param Parser $parser
	 * @param $text a string containing the wikitext (this is _not_ a Text object).
	 * @param strip_state (undocumented)
	 */
	static public function onParserBeforeStrip(Parser $parser, &$text, &$strip_state){
		$removedProp = wfGetWikiaPageProp(WPP_LYRICFIND_MARKED_FOR_REMOVAL, $parser->getTitle()->getArticleID());
		$isMarkedAsRemoved = (!empty($removedProp));
		if($isMarkedAsRemoved){
			// Replace just the lyrics boxes if any are found. If none are found, hide the whole page.
			$NO_LIMIT = -1;
			$numReplacements = 0;
			$text = preg_replace("/<(lyrics|lyricfind|gracenotelyrics)>(.*?)<\/(lyrics|lyricfind|gracenotelyrics)>/is", "<lyrics>{{lyricfind_takedown}}</lyrics>", $text, $NO_LIMIT, $numReplacements);
		}

		return true;
	}

}
