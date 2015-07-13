<?php

namespace Wikia\DependencyInjection;

use DI\Container;

class Injector {
	private static $injector = null;

	/** @var Container */
	private $container;

	public function __construct(Container $container) {
		$this->container = $container;
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
