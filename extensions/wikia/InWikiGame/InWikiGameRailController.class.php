<?php
/**
 * Controller for InWikiGame rail module
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 */
class InWikiGameRailController extends WikiaController {
	/**
	 * @desc For the first time we're trying it only on one wiki
	 */
	const ROTMG_CITY_ID = 175762;

	const ARTICLE_WITH_GAME_TEXT = 'Play';

	/**
	 * @desc The idea is to look for an element in WF variable and if it's there display the rail module with proper image and link
	 */
	public function executeIndex() {
		//for the first time we're doing it only for ROTMG wiki then we'll use solution with WikiFactory
		if( $this->wg->cityId == self::ROTMG_CITY_ID ) {
			$this->response->addAsset('extensions/wikia/InWikiGame/css/InWikiGameRail.scss');
			$this->gameUrl = $this->getGameUrl();
		} else {
			$this->skipRendering();
		}
	}

	/**
	 * @return String artilce's page address
	 */
	protected function getGameUrl() {
		$url = '#';
		$title = Title::newFromText(self::ARTICLE_WITH_GAME_TEXT);

		if( $title instanceof Title ) {
			$url = $title->getFullUrl();
		}

		return $url;
	}

}
