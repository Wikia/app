<?php
namespace Extensions\Wikia\Blogs;

use Extensions\Wikia\Blogs\Hooks\UserCan\Check\BlogArticleCheckFactory;
use Extensions\Wikia\Blogs\Hooks\UserCan\Check\BlogCommentCheckFactory;

class DependencyFactory {
	public function newBlogArticle( \Title $title ): \BlogArticle {
		return new \BlogArticle( $title );
	}

	public function newArticleComment( \Title $title ): \ArticleComment {
		return new \ArticleComment( $title );
	}

	public function newBlogArticleCheckFactory(): BlogArticleCheckFactory {
		return new BlogArticleCheckFactory( $this );
	}

	public function newBlogCommentCheckFactory(): BlogCommentCheckFactory {
		return new BlogCommentCheckFactory( $this );
	}
}
