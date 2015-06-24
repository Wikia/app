<?php

namespace Wikia\DependencyInjection;

use function DI\object;

class InjectionBinding {
	/** @var string */
	private $key;

	/** @var InjectorBuilder */
	private $builder;

	/**
	 * @param string $key
	 * @param InjectorBuilder $builder
	 */
	public function __construct($key, InjectorBuilder $builder) {
		$this->key = $key;
		$this->builder = $builder;
	}

	/**
	 * bind to a specific value, or instance
	 * @param mixed $value
	 * @return InjectorBuilder
	 */
	public function to($value) {
		return $this->bind($value);
	}

	/**
	 * bind to a class, such as an interface to an implementation of that interface
	 * @param string $class name of the class to bind to
	 * @return InjectorBuilder
	 */
	public function toClass($class) {
		return $this->bind(object($class));
	}

	/**
	 * perform the actual binding, returning the InjectorBuilder that now contains the binding
	 * @param $value
	 * @return InjectorBuilder
	 */
	private function bind($value) {
		$this->builder->builder()->addDefinitions([$this->key => $value]);
		return $this->builder;
	}
}
