<?php

namespace Wikia\DependencyInjection;

use DI\Container;
use DI\ContainerBuilder;
use Doctrine\Common\Cache\CacheProvider;
use Wikia\Service\User\PreferenceService;
use function DI\object;

class Injector {
	private static $injector = null;

	/** @var Container */
	private $container;

	/** @var ContainerBuilder */
	private $builder;

	private function __construct() {
		$this->builder = (new ContainerBuilder())
			->useAnnotations(true);
	}

	public function bindClass($key, $class) {
		return $this->bind($key, object($class));
	}

	public function bind($key, $value) {
		$this->builder->addDefinitions([$key => $value]);
		return $this;
	}

	/**
	 * @param Module $module
	 * @return Injector
	 */
	public function addModule(Module $module) {
		$this->builder->addDefinitions($module->configure());
		return $this;
	}

	public function withCache(CacheProvider $cacheProvider = null) {
		if ($cacheProvider != null) {
			$this->builder->setDefinitionCache($cacheProvider);
		}

		return $this;
	}

	/**
	 * @return Container
	 * @throws \Exception when trying to build an already-built injector
	 */
	public function build() {
		if ($this->container != null) {
			throw new \Exception("injector already initialized");
		}

		$this->container = $this->builder->build();
	}

	private function get($name) {
		return $this->container->get($name);
	}

	/**
	 * @return PreferenceService
	 */
	public function userPreferenceService() {
		return $this->get(PreferenceService::class);
	}

	/**
	 * @return Injector
	 */
	public static function getInjector() {
		if (self::$injector == null) {
			self::$injector = new Injector();
		}

		return self::$injector;
	}

	public static function resetInjector() {
		self::$injector = null;
	}
}
