<?php

class PagesHooks {
	public static function onArticleDeleteComplete( WikiPage $page, User $user, $reason, int $articleId ) {
		$task = UpdatePagesTask::newLocalTask();

		$task->call( 'deleteEntry', $articleId );
		$task->queue();
	}

	public static function onNewRevisionFromEditComplete( WikiPage $page, Revision $revision ) {
			static::scheduleArticleUpdate( $revision->getPage(), $page->getTitle()->isContentPage() );
	}

	public static function onTitleMoveComplete( Title $oldTitle, Title $newTitle, User $user, int $articleId ) {
		static::scheduleArticleUpdate( $articleId, $newTitle->isContentPage() );
	}

	public static function onArticleUndeleteComplete( Title $title, bool $created, string $comment, int $oldId, int $newId ) {
		static::scheduleArticleUpdate( $newId, $title->isContentPage() );
	}

	private static function scheduleArticleUpdate( int $articleId, bool $isContentPage ) {
		if ( $articleId ) {
			$task = UpdatePagesTask::newLocalTask();

			$task->call( 'insertOrUpdateEntry', $articleId, $isContentPage );
			$task->queue();
		}
	}
}
