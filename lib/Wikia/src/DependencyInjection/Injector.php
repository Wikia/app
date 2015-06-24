<?php

namespace Wikia\DependencyInjection;

use DI\Container;
use Wikia\Service\User\PreferenceService;

class Injector {
	private static $injector = null;

	/** @var Container */
	private $container;

	public function __construct(Container $container) {
		$this->container = $container;
	}

	/**
	 * @return PreferenceService
	 */
	public function userPreferenceService() {
		return $this->get(PreferenceService::class);
	}

	public function get($name) {
		return $this->container->get($name);
	}

	/**
	 * @return Injector
	 */
	public static function getInjector() {
		return self::$injector;
	}

	public static function setInjector(Injector $injector = null) {
		self::$injector = $injector;
	}
}
