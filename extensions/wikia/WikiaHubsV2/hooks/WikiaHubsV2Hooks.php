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

		if( !empty($app->wg->EnableWikiaHomePageExt)) {
			$dbKeyName = $title->getDBKey();
			$dbKeyNameSplit = explode('/', $dbKeyName);

			$hubName = isset($dbKeyNameSplit[0]) ? $dbKeyNameSplit[0] : null;

			if ( $this->isHubsPage($hubName) ) {
				$hubTimestamp = $this->getTimestampFromSplitDbKey($dbKeyNameSplit);

				// TODO handle if date is wrong

				// TODO ask Matt if anon user can see future hubs

				$app->wg->SuppressPageHeader = true;
				$article = F::build( 'WikiaHubsV2Article', array($title, $this->getHubPageId($dbKeyName), $hubTimestamp) );
			}
		}

		wfProfileOut(__METHOD__);
		return true;

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

			$dbKeyName = $title->getDBKey();
			$dbKeyNameSplit = explode('/', $dbKeyName);
			$hubName = isset($dbKeyNameSplit[0]) ? $dbKeyNameSplit[0] : null;

			if ( $this->isHubsPage($hubName) && isset($dbKeyNameSplit[1])) {
				$url = $this->getCanonicalHrefForHub($hubName, $url);
			}
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * @desc Uses $wgWikiaHubsPages array to find out if the page is a hub page
	 *
	 * @param String $dbKeyName
	 * @return bool
	 */
	protected function isHubsPage($dbKeyName) {
		foreach(F::app()->wg->WikiaHubsV2Pages as $hubPageTitleDbKey) {
			if( $dbKeyName === $hubPageTitleDbKey ) return true;
		}

		return false;
	}

	/**
	 * @desc Uses flipped $wgWikiaHubsPages array to return comscore id of a hub page
	 *
	 * @param String $dbKeyName
	 * @return bool
	 */
	protected function getHubPageId($dbKeyName) {
		$verticals = array_flip(F::app()->wg->WikiaHubsV2Pages);
		if( isset($verticals[$dbKeyName]) ) {
			return $verticals[$dbKeyName];
		}

		return false;
	}

	protected function getTimestampFromSplitDbKey($dbKeyNameSplit) {
		if (isset($dbKeyNameSplit[1])) {
			unset($dbKeyNameSplit[0]);
			$hubDate = implode('/', $dbKeyNameSplit);
			$hubTimestamp = $this->getTimestampFromUserDate($hubDate);
		} else {
			$hubTimestamp = null;
		}
		return $hubTimestamp;
	}

	protected function getTimestampFromUserDate($date) {
		return strtotime($date);
	}

	protected function getCanonicalHrefForHub($hubName, $url) {
		return mb_substr($url, 0, mb_strpos($url, $hubName) + mb_strlen($hubName));
	}
}