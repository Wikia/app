<?php
namespace Extensions\Wikia\Blogs\Hooks\UserCan\Check;

class BlogArticleCreateActionCheck extends Check {
	public function process( \Title $title, \User $user ): bool {
		if ( $title->isUndeleting() ) {
			return true;
		}

		return $user->isLoggedIn() &&
			$this->dependencyFactory->newBlogArticle( $title )->getBlogOwner() === $user->getName();
	}
}
