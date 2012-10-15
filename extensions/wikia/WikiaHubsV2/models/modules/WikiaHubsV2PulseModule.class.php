<?php

/**
 * Hubs Module for Pulse
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

class WikiaHubsV2PulseModule extends WikiaHubsV2Module {
	public function __construct() {
		parent::__construct();
		//TODO: use Factory here
		//$this->setProvider(F::build('MysqlWikiaHubsV2PulseModuleDataProvider'));
		$this->setProvider(F::build('StaticWikiaHubsV2PulseModuleDataProvider'));
	}
}

