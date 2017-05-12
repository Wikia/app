<?php
namespace Extensions\Wikia\Blogs\Hooks\UserCan\Check;

use Extensions\Wikia\Blogs\DependencyFactory;
use Extensions\Wikia\Blogs\Hooks\UserCan\Action;

class BlogArticleCheckFactory {
	/** @var DependencyFactory $dependencyFactory */
	private $dependencyFactory;

	public function __construct( DependencyFactory $factory ) {
		$this->dependencyFactory = $factory;
	}

	public function newActionCheck( string $action ) {
		switch ( $action ) {
			case Action::CREATE:
				return new BlogArticleCreateActionCheck( $this->dependencyFactory );
				break;
			case Action::EDIT:
				return new BlogArticleEditActionCheck( $this->dependencyFactory );
				break;
			case Action::MOVE:
			case Action::MOVE_TARGET:
				return new BlogArticleMoveActionCheck( $this->dependencyFactory );
				break;
			case Action::PROTECT:
				return new BlogArticleProtectActionCheck( $this->dependencyFactory );
				break;
			default:
				return null;
		}
	}
}
