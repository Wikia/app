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


class PreferencePersistenceModuleMySQL implements Module {
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
			PreferencePersistence::class => object(PreferencePersistenceMySQL::class),
			PreferencePersistenceMySQL::CONNECTION_MASTER => $this->masterProvider,
			PreferencePersistenceMySQL::CONNECTION_SLAVE => $this->slaveProvider,
		];
	}
}
