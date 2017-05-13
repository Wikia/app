<?php
namespace Extensions\Wikia\Blogs\Hooks\UserCan\Check;

class BlogCommentCreateActionCheck extends Check {
	public function process( \Title $title, \User $user ): bool {
		$parentPage = $this->dependencyFactory->newArticleComment( $title )->getArticleTitle();
		$blogArticleProps = $this->dependencyFactory->newBlogArticle( $parentPage )->getPageProps();

		return $blogArticleProps['commenting'] === 1 || $blogArticleProps['commenting'] === null;
	}
}
