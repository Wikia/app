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
	public function pencilUnit() {
		//only renders the container -- assets has been loaded by globalHeaderLights()
	}

	public function globalHeaderLights() {
		$this->response->addAsset("extensions/wikia/WikiaSeasons/css/WikiaSeasons.scss");
	}

}
