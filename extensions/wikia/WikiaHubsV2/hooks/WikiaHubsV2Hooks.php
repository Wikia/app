<?php

class WikiaHubsV2Hooks {
	const hubCategoryFailover = 'Gaming';

	/**
	 * @param Title $title
	 * @param Page $article
	 *
	 * @return true because it's a hook
	 */
	public function onArticleFromTitle(&$title, &$article) {
		wfProfileIn(__METHOD__);

		if( HubService::isCorporatePage(F::app()->wg->CityId) && $this->isHubsPage($title) ) {
			$article = F::build( 'WikiaHubsV2Article', array($title, $this->getHubPageId($title->getText())) );
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * @param Title $title
	 * @return bool
	 *
	 * @todo find a better way, global array variable?
	 */
	protected function isHubsPage($title) {
		return in_array($title->getDBKey(), array(
			'Video_Games',
			'Videospiele',
			'Entertainment',
			'Lifestyle'
		));
	}

	/**
	 * @return bool
	 *
	 * @todo find a better way, global array variable?
	 */
	protected function getHubPageId($hubName) {
		$id = WikiFactoryHub::getInstance()->getIdByName($hubName);

		if( !$id ) {
			$hubName = self::hubCategoryFailover;
			$id = WikiFactoryHub::getInstance()->getIdByName($hubName);
		}

		return $id;
	}
}