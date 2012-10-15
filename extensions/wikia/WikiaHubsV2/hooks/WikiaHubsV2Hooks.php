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
		$dbKeyName = $title->getDBKey();
		if( !empty($app->wg->EnableWikiaHomePageExt) && $this->isHubsPage($dbKeyName) ) {
			$app->wg->SuppressPageHeader = true;
			$article = F::build( 'WikiaHubsV2Article', array($title, $this->getHubPageId($dbKeyName)) );
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
}