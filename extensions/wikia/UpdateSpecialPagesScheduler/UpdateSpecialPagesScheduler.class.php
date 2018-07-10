<?php

use Wikia\Tasks\Tasks\MaintenanceTask;
use Wikia\Tasks\Queues\ScheduledMaintenanceQueue;

class UpdateSpecialPagesScheduler {

	private static function isAllowed( User $user ) : bool {
		return $user->isAllowed( 'schedule-update-special-pages' );
	}

	private static function doSchedule( int $wikiId ) : string {
		$task = new MaintenanceTask();
		$task->call( 'run', 'maintenance/updateSpecialPages.php', '--quiet' );
		$taskId = $task
			->setQueue(ScheduledMaintenanceQueue::NAME)
			->wikiId( $wikiId )
			->queue();

		return $taskId;
	}

	/**
	 * @param SpecialStatistics $page
	 * @param string $text
	 */
	static public function onCustomSpecialStatistics( SpecialStatistics $page, string &$text ) {
		$context = $page->getContext();

		if ( !self::isAllowed( $context->getUser() )) {
			return;
		}

		// handle POST request, user wants to schedule a run of the script
		$request = $context->getRequest();

		if ( $request->wasPosted() &&
		     $request->getVal('updateSpecialPagesScheduler') &&
		     $context->getUser()->matchEditToken( $request->getVal( 'editToken' ) ) ) {

			global $wgCityId;
			$taskId = self::doSchedule( $wgCityId );

			$text = Wikia::successbox(
				$page->msg( 'update-special-pages-scheduler-requested', $taskId )
			) . $text;
		}

		$tpl = new EasyTemplate(__DIR__ . '/templates');

		$tpl->set( 'title', $context->getTitle() );
		$tpl->set( 'editToken', $context->getUser()->getEditToken() );

		$text .= $tpl->render('scheduler');
	}
}
