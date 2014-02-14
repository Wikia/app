<?php

/**
 * Abstract Factory for Hubs V3 modules
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

abstract class WikiaHubsV3ModuleFactory {
	/**
	 * @abstract
	 * @return WikiaHubsV3Module
	 */
	public abstract function buildModule();
}
