<?php
namespace Extensions\Wikia\ArticleComments\Hooks\UserCan\Check;

use Extensions\Wikia\ArticleComments\Hooks\UserCan\Action;
use Extensions\Wikia\ArticleComments\Hooks\UserCan\DependencyFactory;

class CheckFactory {
	/** @var DependencyFactory $dependencyFactory */
	private $dependencyFactory;

	public function __construct( DependencyFactory $factory ) {
		$this->dependencyFactory = $factory;
	}

	/**
	 * Given a MediaWiki action, return the corresponding check class, or null if there is none.
	 *
	 * @see Action
	 * @param string $action
	 * @return Check|null
	 */
	public function newActionCheck( string $action ) {
		switch ( $action ) {
			case Action::CREATE:
				return new CreateActionCheck( $this->dependencyFactory );
				break;
			case Action::EDIT:
				return new EditActionCheck( $this->dependencyFactory );
				break;
			case Action::MOVE:
			case Action::MOVE_TARGET:
				return new MoveActionCheck( $this->dependencyFactory );
				break;
			case Action::DELETE:
			case Action::UNDELETE:
				return new DeleteActionCheck( $this->dependencyFactory );
				break;
			default:
				return null;
		}
	}
}
