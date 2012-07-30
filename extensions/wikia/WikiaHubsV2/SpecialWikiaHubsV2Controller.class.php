<?php

/**
 * Hubs V2 Controller
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

class SpecialWikiaHubsV2Controller extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct('WikiaHubsV2');
	}

	public function index() {
		$this->response->setCacheValidity(24*60*60,24*60*60,array(WikiaResponse::CACHE_TARGET_BROWSER, WikiaResponse::CACHE_TARGET_VARNISH));

	}
}
