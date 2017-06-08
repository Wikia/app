<?php
namespace Extensions\Wikia\ArticleComments\Hooks;

use Extensions\Wikia\ArticleComments\Hooks\UserCan\DependencyFactory;

/**
 * Handler for UserCan hook
 *
 * @see https://github.com/Wikia/app/blob/dev/docs/hooks.txt
 * @package Extensions\Wikia\ArticleComments\Hooks
 */
class UserCan {
	/** @var DependencyFactory $dependencyFactory */
	private $dependencyFactory;

	public function __construct( DependencyFactory $factory ) {
		$this->dependencyFactory = $factory;
	}

	/**
	 * Process the hook.
	 *
	 * @param \Title $title
	 * @param \User $user
	 * @param string $action
	 * @param mixed $result Whether this user should be allowed to perform this action on this title
	 * @return bool True to continue hook processing, false to abort
	 */
	public function process( \Title $title, \User $user, string $action, &$result ): bool {

		if ( $this->isACommentPage( $title ) ) {
			$check = $this->dependencyFactory->newCheckFactory()->newActionCheck( $action );

			if ( !empty( $check ) ) {
				$result = $check->process( $title, $user );
				return $result;
			}
		}

		return true;
	}

	private function isACommentPage( \Title $title ): bool {
		$commentNamespaces = $this->dependencyFactory->getCommentsNamespaces();
		return $title->inNamespaces( $commentNamespaces ) &&
		       strpos( $title->getText(), '/' . ARTICLECOMMENT_PREFIX );
	}
}
