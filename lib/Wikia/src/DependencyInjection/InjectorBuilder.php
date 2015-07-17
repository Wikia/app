<?php

namespace Wikia\DependencyInjection;

use DI\ContainerBuilder;
use Doctrine\Common\Cache\CacheProvider;
use function DI\object;

class InjectorBuilder {
	/** @var ContainerBuilder */
	private $builder;

	public function __construct() {
		$this->builder = (new ContainerBuilder())
			->useAnnotations(true);
	}

	public function bind($key) {
		return new InjectionBinding($key, $this);
	}

	/**
	 * @param Module $module
	 * @return InjectorBuilder
	 */
	public function addModule(Module $module) {
		$module->configure($this);
		return $this;
	}

	public function withCache(CacheProvider $cacheProvider = null) {
		if ($cacheProvider != null) {
			$this->builder->setDefinitionCache($cacheProvider);
		}

		return $this;
	}

	public function builder() {
		return $this->builder;
	}

	/**
	 * @return Injector
	 */
	public function build() {
		return new Injector($this->builder->build());
	}
}
