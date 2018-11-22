<?php
namespace Wikia\Tasks\Tasks;

/**
 * SRE-109: Background task to increment users' edit counts
 */
class IncrementEditCountTask extends BaseTask {

	/** @var IncrementEditCountTask[] $tasksByUser */
	private static $tasksByUser = [];

	/**
	 * Get a task instance prepared for the given user. At most one task instance per user will be prepared per request.
	 *
	 * @param \User $user
	 * @return IncrementEditCountTask
	 */
	public static function forUser( \User $user ): IncrementEditCountTask {
		$userId = $user->getId();

		if ( !isset( static::$tasksByUser[$userId] ) ) {
			// prepare and schedule the task for publication at the end of the request
			$task = static::newLocalTask();
			$task->createdBy( $user );
			$task->queue();

			static::$tasksByUser[$userId] = $task;
		}

		return static::$tasksByUser[$userId];
	}

	public function increment() {
		$userStatsService = new \UserStatsService( $this->createdByUser()->getId() );
		$userStatsService->increaseEditsCount();
	}
}
