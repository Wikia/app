<?php
/**
 * Controller for WikiaSeasons extension
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 */
class WikiaSeasonsController extends WikiaController {

	public function globalHeaderLights() {
		$this->response->addAsset("extensions/wikia/WikiaSeasons/css/WikiaSeasons.scss");
	}

	/**
	 * @desc Renders additional container above section#WikiaPage
	 */
	public function pencilUnit() {
		//only renders the container -- assets are loaded in pencilUnit()
	}

}
