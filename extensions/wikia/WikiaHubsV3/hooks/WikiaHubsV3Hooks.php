<?php

class WikiaHubsV3Hooks {
	/**
	 * @param Title $title
	 * @param Page $article
	 *
	 * @return true because it's a hook
	 */
	static public function onArticleFromTitle(&$title, &$article) {
		wfProfileIn(__METHOD__);
		$app = F::app();

		if( WikiaPageType::isWikiaHubMain() || $title->isSubpageOf(Title::newMainPage()) ) {
			$model = new WikiaHubsV3HooksModel();

			$dbKeyName = $title->getDBKey();
			$dbKeyNameSplit = explode('/', $dbKeyName);

			$hubTimestamp = $model->getTimestampFromSplitDbKey($dbKeyNameSplit);

			$app->wg->SuppressRail = true;
			$app->wg->SuppressFooter = true;

			if (!$app->wg->request->wasPosted()) {
				// don't change article object while saving data
				$article = new WikiaHubsV3Article($title, $hubTimestamp);
			}
		}
		wfProfileOut(__METHOD__);
		return true;

	}

	/**
	 * Change canonical url if we are displaying hub for selected date
	 *
	 * @param string $url
	 *
	 * @return bool
	 */
	static public function onWikiaCanonicalHref(&$url) {
		wfProfileIn(__METHOD__);
		global $wgRequest;

		$title = Title::newFromText($wgRequest->getVal( 'title' ));
		$mainPageTitle = Title::newMainPage();

		if ( $title instanceof Title && $title->isSubpageOf($mainPageTitle) ) {
			$url = $mainPageTitle->getFullURL();
		}

		wfProfileOut(__METHOD__);
		return true;
	}

}
