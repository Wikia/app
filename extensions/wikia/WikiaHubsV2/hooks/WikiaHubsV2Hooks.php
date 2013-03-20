<?php

class WikiaHubsV2Hooks {
	/**
	 * @param Title $title
	 * @param Page $article
	 *
	 * @return true because it's a hook
	 */
	public function onArticleFromTitle(&$title, &$article) {
		wfProfileIn(__METHOD__);
		$app = F::app();

		$model = new WikiaHubsV2HooksModel();

		$dbKeyName = $title->getDBKey();
		$dbKeyNameSplit = explode('/', $dbKeyName);

		$hubName = isset($dbKeyNameSplit[0]) ? $dbKeyNameSplit[0] : null;

		if( $model->isHubsPage($hubName) && !$this->isOffShotPage($title) ) {
			$hubTimestamp = $model->getTimestampFromSplitDbKey($dbKeyNameSplit);

			$app->wg->SuppressPageHeader = true;
			$app->wg->SuppressWikiHeader = true;
			$app->wg->SuppressRail = true;
			$app->wg->SuppressFooter = true;
			$article = F::build( 'WikiaHubsV2Article', array($title, $model->getHubPageId($dbKeyNameSplit[0]), $hubTimestamp) );
		}

		wfProfileOut(__METHOD__);
		return true;

	}

	/**
	 * @desc Off-shot pages are real subpages of a hub (real articles [Video_Games/Video_Game_Olympics/] instead of specific day's versions of a hub page [Video_Games/19-03-2013/])
	 * 
	 * @param Title $title
	 * @return bool
	 */
	protected function isOffShotPage(Title $title) {
		return $title->isSubpage() && $title->exists();
	}

	/**
	 * Change canonical url if we are displaying hub for selected date
	 *
	 * @param string $url
	 * @param Title  $title
	 *
	 * @return bool
	 */
	public function onWikiaCanonicalHref(&$url, $title) {
		wfProfileIn(__METHOD__);
		$app = F::app();

		if( !empty($app->wg->EnableWikiaHomePageExt)) {
			$model = new WikiaHubsV2HooksModel();

			$dbKeyName = $title->getDBKey();
			$dbKeyNameSplit = explode('/', $dbKeyName);
			$hubName = isset($dbKeyNameSplit[0]) ? $dbKeyNameSplit[0] : null;

			if ( $model->isHubsPage($hubName) && isset($dbKeyNameSplit[1])) {
				$url = $model->getCanonicalHrefForHub($hubName, $url);
			}
		}

		wfProfileOut(__METHOD__);
		return true;
	}
}