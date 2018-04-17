<?php
namespace Wikia\Factory;

abstract class AbstractFactory {
	private $serviceFactory;

	public function __construct( ServiceFactory $factory ) {
		$this->serviceFactory = $factory;
	}

	protected function serviceFactory(): ServiceFactory {
		return $this->serviceFactory;
	}
}
