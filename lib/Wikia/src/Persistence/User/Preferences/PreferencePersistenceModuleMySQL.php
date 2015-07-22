<?php

namespace Wikia\Persistence\User\Preferences;

use Wikia\DependencyInjection\InjectorBuilder;
use Wikia\DependencyInjection\Module;

class PreferencePersistenceModuleMySQL implements Module {
	/** @var callable */
	private $masterProvider;

	/** @var callable */
	private $slaveProvider;

	/** @var callable */
	private $whiteListProvider;

	public function __construct(callable $masterProvider, callable $slaveProvider, callable $whiteListProvider) {
		$this->masterProvider = $masterProvider;
		$this->slaveProvider = $slaveProvider;
		$this->whiteListProvider = $whiteListProvider;
	}

	public function configure(InjectorBuilder $builder) {
		$builder
			->bind(PreferencePersistence::class)->toClass(PreferencePersistenceMySQL::class)
			->bind(PreferencePersistenceMySQL::CONNECTION_MASTER)->to($this->masterProvider)
			->bind(PreferencePersistenceMySQL::CONNECTION_SLAVE)->to($this->slaveProvider)
			->bind(PreferencePersistenceMySQL::WHITE_LIST)->to($this->whiteListProvider);
	}
}
