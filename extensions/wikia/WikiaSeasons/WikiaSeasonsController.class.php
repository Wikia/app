<?php
/**
 * Controller for WikiaSeasons extension
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 */
class WikiaSeasonsController extends WikiaController {

	/**
	 * @desc Renders additional container above section#WikiaPage
	 */
	public function renderBar() {
		if( HubService::isCorporatePage($this->wg->CityId) ) {
			$this->response->addAsset("extensions/wikia/WikiaSeasons/css/WikiaSeasons.scss");
		} else {
			$this->skipRendering();
		}
	}

}
