<?php

use Wikia\Logger\Loggable;

class UserPageDeleter {
	use Loggable;

	public function deletePages( array $pageNames, User $requester, string $reason ): void {
		foreach ( $pageNames as $pageName ) {
			$page = WikiPage::factory(Title::newFromText($pageName));
			if ($page === null) {
				$this->warning("CoppaTool: Page selected to delete is missing {$pageName}");
				return;
			}

			$error = '';
			$successfullyDeleted = $page->doDeleteArticle($reason, true, 0, true, $error, $requester);

			if (!$successfullyDeleted) {
				$this->warning("CoppaTool: Page selected to delete is missing {$pageName}", ['error' => $error]);
			}
		}
	}
}
