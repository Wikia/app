<?php
namespace Extensions\Wikia\Blogs\Hooks\UserCan\Check;

use Extensions\Wikia\Blogs\DependencyFactory;

abstract class Check {
	/** @var DependencyFactory $dependencyFactory */
	protected $dependencyFactory;

	public function __construct( DependencyFactory $factory ) {
		$this->dependencyFactory = $factory;
	}

	abstract public function process( \Title $title, \User $user): bool;
}
