<?php
namespace Extensions\Wikia\ArticleComments\Hooks\UserCan\Check;

use Extensions\Wikia\ArticleComments\Hooks\UserCan\DependencyFactory;

abstract class Check {
	/** @var DependencyFactory $dependencyFactory */
	protected $dependencyFactory;

	public function __construct( DependencyFactory $factory ) {
		$this->dependencyFactory = $factory;
	}

	abstract public function process( \Title $title, \User $user );
}
