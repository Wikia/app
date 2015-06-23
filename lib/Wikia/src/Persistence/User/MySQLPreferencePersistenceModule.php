<?php
/**
 * PreferencePersistenceModule
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Persistence\User;

use function DI\object;

use Wikia\DependencyInjection\Module;
use Wikia\Service\User\PreferencePersistence;


class MySQLPreferencePersistenceModule implements Module {
	/** @var callable */
	private $masterProvider;

	/** @var callable */
	private $slaveProvider;

	public function __construct(callable $masterProvider, callable $slaveProvider) {
		$this->masterProvider = $masterProvider;
		$this->slaveProvider = $slaveProvider;
	}

	public function configure() {
		return [
			PreferencePersistence::class => object(MySQLPreferencePersistence::class),
			MySQLPreferencePersistence::CONNECTION_MASTER => $this->masterProvider,
			MySQLPreferencePersistence::CONNECTION_SLAVE => $this->slaveProvider,
		];
	}
}
