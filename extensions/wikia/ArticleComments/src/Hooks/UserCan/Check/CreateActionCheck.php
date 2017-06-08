<?php
namespace Extensions\Wikia\ArticleComments\Hooks\UserCan\Check;

use Extensions\Wikia\ArticleComments\Hooks\UserCan\Right;

class CreateActionCheck extends Check {
	public function process( \Title $title, \User $user ) {
		$parentPage = $this->dependencyFactory->newArticleComment( $title )->getArticleTitle();

		if ( !$parentPage->exists() || $parentPage->isMainPage() ) {
			return false;
		}

		return $user->isAllowedAll( Right::COMMENT_CREATE, Right::EDIT );
	}
}
