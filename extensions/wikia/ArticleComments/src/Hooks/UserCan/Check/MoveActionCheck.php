<?php
namespace Extensions\Wikia\ArticleComments\Hooks\UserCan\Check;

use Extensions\Wikia\ArticleComments\Hooks\UserCan\Right;

class MoveActionCheck extends Check {
	public function process( \Title $title, \User $user ) {
		return $user->isAllowed( Right::COMMENT_MOVE );
	}
}
