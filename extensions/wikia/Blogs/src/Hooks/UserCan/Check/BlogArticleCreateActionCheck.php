<?php
namespace Extensions\Wikia\Blogs\Hooks\UserCan\Check;

class BlogArticleCreateActionCheck extends Check {
	public function process( \Title $title, \User $user ): bool {
		return $user->isLoggedIn() &&
			$this->dependencyFactory->newBlogArticle( $title )->getBlogOwner() === $user->getName();
	}
}
