<?php

namespace Wikia\Persistence\User;

use Wikia\DependencyInjection\InjectorBuilder;
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

	public function configure(InjectorBuilder $builder) {
		$builder
			->bind(PreferencePersistence::class)->toClass(PreferencePersistenceMySQL::class)
			->bind(PreferencePersistenceMySQL::CONNECTION_MASTER)->to($this->masterProvider)
			->bind(PreferencePersistenceMySQL::CONNECTION_SLAVE)->to($this->slaveProvider);
	}
}
