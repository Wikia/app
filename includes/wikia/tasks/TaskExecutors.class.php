<?php
/**
 * TaskExecutors
 *
 * Manages migration of tasks/jobs to new job queue
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

class TaskExecutors {
	private static $modernExecutors = [
//		'BloglistDeferredPurgeJob',
//		'BlogTask',
//		'CreatePdfThumbnailsJob',
//		'CreateWikiLocalJob',
		'ParsoidCacheUpdateJob',
	];

	static function isLegacy($taskName) {
		return !self::isModern($taskName);
	}

	static function isModern($taskName) {
		return in_array($taskName, self::$modernExecutors);
	}
}