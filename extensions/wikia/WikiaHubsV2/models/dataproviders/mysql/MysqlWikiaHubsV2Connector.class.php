<?php

/**
 * Singleton for Hubs V2 mysql connector
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

class MysqlWikiaHubsV2Connector extends WikiaModel {
	private static $instance = false;
	private $readconnection = false;
	private $writeconnection = false;

	public static function  getInstance() {
		if (self::$instance == false) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function getReadConnection() {
		if(!$this->readconnection) {
			$this->readconnection = $this->wf->getDB(DB_SLAVE, array(), $this->wg->sharedDB);
		}
		return $this->readconnection;
	}

	public function getWriteConnection() {
		if(!$this->writeconnection) {
			$this->writeconnection = $this->wf->getDB(DB_MASTER, array(), $this->wg->sharedDB);
		}
		return $this->writeconnection;
	}
}