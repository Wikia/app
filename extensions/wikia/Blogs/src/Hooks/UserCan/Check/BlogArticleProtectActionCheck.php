<?php
namespace Extensions\Wikia\Blogs\Hooks\UserCan\Check;

use Extensions\Wikia\Blogs\Hooks\UserCan\Right;

class BlogArticleProtectActionCheck extends Check {
	public function process( \Title $title, \User $user ): bool {
		return $user->isAllowed( Right::BLOG_ARTICLES_PROTECT );
	}
}
