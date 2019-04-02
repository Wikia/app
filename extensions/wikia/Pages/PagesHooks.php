<?php

class PagesHooks {
	public static function scheduleDeleteTask( WikiPage $page, User $user, $reason, int $articleId ) {
		$task = UpdatePagesTask::newLocalTask();

		$task->call( 'deleteEntry', $articleId );
		$task->setQueue( \Wikia\Tasks\Queues\DeferredInsertsQueue::NAME );
		$task->queue();
	}

	public static function scheduleUpdateTask( WikiPage $page, Revision $revision ) {
		$pagesEntry = PagesEntry::newFromPageAndRevision( $page, $revision );
		$task = UpdatePagesTask::newLocalTask();

		$task->call( 'insertOrUpdateEntry', $pagesEntry );
		$task->setQueue( \Wikia\Tasks\Queues\DeferredInsertsQueue::NAME );
		$task->queue();
	}
}
