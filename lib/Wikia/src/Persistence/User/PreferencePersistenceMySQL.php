<?php

namespace Wikia\Persistence\User;

use Wikia\Service\User\PreferencePersistence;

class PreferencePersistenceMySQL implements PreferencePersistence {

	private $master;
	private $slave;

	function __construct(\DatabaseMysqli $master, \DatabaseMysqli $slave) {
		$this->master = $master;
		$this->slave = $slave;
	}

	public function save( $userId, array $preferences ) {

	}

	public function get( $userId ) {

	}

}
