<?php

class TaskManagerHooks {

	/**
	 * Add an entry with number of items queued in TaskManager to APIQuerySiteInfo module
	 *
	 * @see http://www.wikia.com/api.php?action=query&meta=siteinfo&siprop=statistics
	 *
	 * @param ApiQuerySiteinfo $apiModule
	 * @param array $stats
	 * @return bool true
	 */
	public static function onAPIQuerySiteInfoStatistics(ApiQuerySiteinfo $apiModule, Array &$stats) {
		$stats['tasks'] = self::getTasksCount();
		return true;
	}

	/**
	 * Get number of items queued in TaskManager
	 *
	 * @return int number of items in the queue
	 */
	private static function getTasksCount() {
		global $wgMemc;

		$key = __METHOD__;
		$cnt = $wgMemc->get($key);

		if (!is_numeric($cnt)) {
			$dbr = WikiFactory::db( DB_SLAVE );
			$cnt = $dbr->estimateRowCount('wikia_tasks');
			$wgMemc->set($key, $cnt, 60 * 1);
		}
		return $cnt;
	}
}
