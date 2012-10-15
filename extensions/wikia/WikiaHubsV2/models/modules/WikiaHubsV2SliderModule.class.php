<?php

/**
 * Hubs Module for Slider
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

class WikiaHubsV2SliderModule extends WikiaHubsV2Module {
	public function __construct() {
		parent::__construct();
		//TODO: use Factory here
		//$this->setProvider(F::build('MysqlWikiaHubsV2SliderModuleDataProvider'));
		$this->setProvider(F::build('StaticWikiaHubsV2SliderModuleDataProvider'));
	}
}

