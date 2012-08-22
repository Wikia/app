<?php

/**
 * Base Class for Hubs V2 pulse module data provider
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

abstract class MysqlWikiaHubsV2ModuleDataProvider extends WikiaHubsV2ModuleDataProvider {
	protected $readconnection = false;
	protected $writeconnection = false;
}
