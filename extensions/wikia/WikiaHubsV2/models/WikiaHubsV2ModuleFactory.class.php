<?php

/**
 * Abstract Factory for Hubs V2 modules
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

abstract class WikiaHubsV2ModuleFactory {
	/**
	 * @abstract
	 * @return WikiaHubsV2Module
	 */
	public abstract function buildModule();
}
