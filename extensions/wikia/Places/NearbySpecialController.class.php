<?php

/**
 * Nearby Special Page
 * @author Macbre
 */
class NearbySpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct('Nearby');
	}

	public function index(){
		$this->wg->Out->setPageTitle(wfMessage('places-nearby')->text());
		$this->wg->Out->setSubtitle(wfMessage('places-nearby')->text());

		$this->wg->Out->addModules('ext.wikia.Nearby');

		// handle /Special:Nearby/52.386225,16.914219 URLS
		$par = $this->getPar();

		if ($par) {
			$coords = array_map(
				function($item) {
					return (float) $item;
				},
				explode(',', $par, 2)
			);

			$this->setVal('coords', $coords);
		}
	}
}
