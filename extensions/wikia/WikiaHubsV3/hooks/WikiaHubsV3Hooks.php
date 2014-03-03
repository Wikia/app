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

		if( WikiaPageType::isWikiaHub() && WikiaPageType::isWikiaHubMain() ) { /* TODO decide what to do with offshots */
			$model = new WikiaHubsV3HooksModel();

			$dbKeyName = $title->getDBKey();
			$dbKeyNameSplit = explode('/', $dbKeyName);

			$hubTimestamp = $model->getTimestampFromSplitDbKey($dbKeyNameSplit);

			$app->wg->SuppressRail = true;
			$app->wg->SuppressFooter = true;

			if (!$app->wg->request->wasPosted()) {
				// don't change article object while saving data
				$article = new WikiaHubsV3Article($title, $model->getHubPageId($dbKeyNameSplit[0]), $hubTimestamp);
			}
		}
/*
		if( $isHubPage && self::isOffShotPage($title) ) {
			OasisController::addBodyClass('WikiaHubPage');

			$am = AssetsManager::getInstance();
			$app->wg->Out->addStyle($am->getSassCommonURL('extensions/wikia/WikiaHubsV3/css/WikiaHubsV3.scss'));

		}
*/
		wfProfileOut(__METHOD__);
		return true;

	}

	/**
	 * Off-shot pages are real subpages of a hub (real articles [Video_Games/Video_Game_Olympics/]
	 * instead of specific day's versions of a hub page [Video_Games/19-03-2013/])
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
			$model = new WikiaHubsV3HooksModel();
			
			$title = Title::newFromURL($url);
			if( $title instanceof Title ) {
				$dbKeyName = $title->getDBKey();
				$dbKeyNameSplit = explode('/', $dbKeyName);
				$hubName = isset($dbKeyNameSplit[0]) ? $dbKeyNameSplit[0] : null;

				if ( WikiaPageType::isWikiaHub() && isset($dbKeyNameSplit[1])) {
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

			$model = new WikiaHubsV3HooksModel();
			$hubName = isset($dbKeyNameSplit[0]) ? $dbKeyNameSplit[0] : null;

			if( WikiaPageType::isWikiaHub() && self::isOffShotPage($title) ) {
				$parser->setHook('hubspopularvideos', array(new WikiaHubsParserHelper(), 'renderTag'));
			}
		}

		wfProfileOut(__METHOD__);
		return true;
	}

}
