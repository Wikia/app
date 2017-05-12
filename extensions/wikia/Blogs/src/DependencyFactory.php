<?php
namespace Extensions\Wikia\Blogs;

use Extensions\Wikia\Blogs\Hooks\UserCan\Check\BlogArticleCheckFactory;
use Extensions\Wikia\Blogs\Hooks\UserCan\Check\BlogCommentCheckFactory;

class DependencyFactory {
	public function newBlogArticle( \Title $title ): \BlogArticle {
		return new \BlogArticle( $title );
	}

	public function newBlogArticleCheckFactory() {
		return new BlogArticleCheckFactory( $this );
	}

	public function newBlogCommentCheckFactory() {
		return new BlogCommentCheckFactory( $this );
	}
}
