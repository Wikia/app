<?php
namespace Extensions\Wikia\Blogs\Hooks;

use Extensions\Wikia\Blogs\DependencyFactory;

class UserCan {
	/** @var DependencyFactory $dependencyFactory */
	private $dependencyFactory;

	public function __construct( DependencyFactory $factory ) {
		$this->dependencyFactory = $factory;
	}

	/**
	 * @param \Title $title
	 * @param \User $user
	 * @param string $action
	 * @param $result
	 * @return bool
	 */
	public function process( \Title $title, \User $user, string $action, &$result ): bool {

		if ( $title->inNamespace( NS_BLOG_ARTICLE ) ) {
			$check = $this->dependencyFactory->newBlogArticleCheckFactory()->newActionCheck( $action );
		} elseif ( $title->inNamespace( NS_BLOG_ARTICLE_TALK ) ) {
			$check = $this->dependencyFactory->newBlogCommentCheckFactory()->newActionCheck( $action );
		}

		if ( !empty( $check ) ) {
			$result = $check->process( $title, $user );
			return $result;
		}

		return true;
	}
}
