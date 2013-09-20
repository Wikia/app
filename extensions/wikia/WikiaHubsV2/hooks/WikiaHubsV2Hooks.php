<?php

class WikiaHubsV2Hooks {
	/**
	 * @param Title $title
	 * @param Page $article
	 *
	 * @return true because it's a hook
	 */
	static public function onArticleFromTitle(&$title, &$article) {
		wfProfileIn(__METHOD__);
		$app = F::app();

		$model = new WikiaHubsV2HooksModel();

		$dbKeyName = $title->getDBKey();
		$dbKeyNameSplit = explode('/', $dbKeyName);

		$hubName = isset($dbKeyNameSplit[0]) ? $dbKeyNameSplit[0] : null;

		if( $model->isHubsPage($hubName) && !self::isOffShotPage($title) ) {
			$hubTimestamp = $model->getTimestampFromSplitDbKey($dbKeyNameSplit);

			$app->wg->SuppressPageHeader = true;
			$app->wg->SuppressWikiHeader = true;
			$app->wg->SuppressRail = true;
			$app->wg->SuppressFooter = true;
			if (!$app->wg->request->wasPosted()) {
				// don't change article object while saving data
				$article = new WikiaHubsV2Article($title, $model->getHubPageId($dbKeyNameSplit[0]), $hubTimestamp);
			}
		}

		if( $model->isHubsPage($hubName) && self::isOffShotPage($title) ) {
			$hubsModel = new WikiaHubsV2Model();
			$canonicalHubName = $hubsModel->getCanonicalVerticalName($model->getHubPageId($dbKeyNameSplit[0]));
			OasisController::addBodyClass('WikiaHubs' . mb_ereg_replace(' ', '', $canonicalHubName));

			$am = AssetsManager::getInstance();
			$app->wg->Out->addStyle($am->getSassCommonURL('extensions/wikia/WikiaHubsV2/css/WikiaHubsV1/WikiaHubs.scss'));
			$app->wg->Out->addStyle($am->getSassCommonURL('extensions/wikia/WikiaHubsV2/css/WikiaHubsV2.scss'));

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
	static protected function isOffShotPage(Title $title) {
		return $title->isSubpage() && $title->exists();
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
		$app = F::app();

		if( !empty($app->wg->EnableWikiaHomePageExt) ) {
			$model = new WikiaHubsV2HooksModel();
			
			$title = Title::newFromURL($url);
			if( $title instanceof Title ) {
				$dbKeyName = $title->getDBKey();
				$dbKeyNameSplit = explode('/', $dbKeyName);
				$hubName = isset($dbKeyNameSplit[0]) ? $dbKeyNameSplit[0] : null;

				if ( $model->isHubsPage($hubName) && isset($dbKeyNameSplit[1])) {
					$url = $model->getCanonicalHrefForHub($hubName, $url);
				}
			}
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Backward compatibility for old hubs off-shot pages
	 *
	 * @param Parser parser
	 * @return true
	 */
	static public function onParserFirstCallInit( Parser $parser ) {
		wfProfileIn(__METHOD__);

		$app = F::app();
		$title = $app->wg->title;

		if ($title instanceof Title) {
			$dbKeyName = $title->getDBKey();
			$dbKeyNameSplit = explode('/', $dbKeyName);

			$model = new WikiaHubsV2HooksModel();
			$hubName = isset($dbKeyNameSplit[0]) ? $dbKeyNameSplit[0] : null;

			if( $model->isHubsPage($hubName) && self::isOffShotPage($title) ) {
				$parser->setHook('hubspopularvideos', array(new WikiaHubsParserHelper(), 'renderTag'));
			}
		}

		wfProfileOut(__METHOD__);
		return true;
	}

}
