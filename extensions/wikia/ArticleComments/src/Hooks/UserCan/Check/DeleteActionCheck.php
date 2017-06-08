<?php
namespace Extensions\Wikia\ArticleComments\Hooks\UserCan\Check;

use Extensions\Wikia\ArticleComments\Hooks\UserCan\Right;

class DeleteActionCheck extends Check {
	public function process( \Title $title, \User $user ) {
		return $user->isAllowed( Right::COMMENT_DELETE );
	}
}
