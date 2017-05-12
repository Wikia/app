<?php
namespace Extensions\Wikia\Blogs\Hooks\UserCan;

abstract class Right {
	const BLOG_ARTICLES_EDIT = 'blog-articles-edit';
	const BLOG_ARTICLES_MOVE = 'blog-articles-move';
	const BLOG_ARTICLES_PROTECT = 'blog-articles-protect';
	const BLOG_COMMENTS_DELETE = 'blog-comments-delete';
}
