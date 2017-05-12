<?php
namespace Extensions\Wikia\Blogs\Hooks\UserCan\Check;

use Extensions\Wikia\Blogs\DependencyFactory;
use Extensions\Wikia\Blogs\Hooks\UserCan\Action;

class BlogCommentCheckFactory {
	/** @var DependencyFactory $dependencyFactory */
	private $dependencyFactory;

	public function __construct( DependencyFactory $factory ) {
		$this->dependencyFactory = $factory;
	}

	public function newActionCheck( string $action ) {
		if ( $action === Action::CREATE ) {
			return new BlogCommentCreateActionCheck( $this->dependencyFactory );
		}

		return null;
	}
}
