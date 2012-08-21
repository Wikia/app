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

		if( $this->isCorporateWiki() && $this->isHubsPage($title) ) {
			$article = F::build( 'WikiaHubsV2Article', array($title, $this->getHubPageId($title->getDBKey())) );
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * @return bool
	 */
	protected function isCorporateWiki() {
		return (F::app()->wg->CityId == 80433) ? true : false;
	}

	/**
	 * @param Title $title
	 * @return bool
	 */
	protected function isHubsPage($title) {
		return ($title->getDBKey() === 'Entertainment' && !$title->isSubpage() ) ? true : false;
	}

	/**
	 * @return bool
	 */
	protected function getHubPageId() {
		return (F::app()->wg->CityId == 80433) ? true : false;
	}
}
