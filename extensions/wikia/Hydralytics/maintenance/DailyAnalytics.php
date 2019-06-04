<?php
/**
 * Curse Inc.
 * Hydralytics
 * Daily Analytics Cron Class
 *
 * @author		Alexia E. Smith
 * @copyright	(c) 2014 Curse Inc.
 * @license		GNU General Public License v2.0 or later
 * @package		Hydralytics
 * @link		https://gitlab.com/hydrawiki
 *
 **/

require_once(dirname(__DIR__, 3)."/maintenance/Maintenance.php");

class DailyAnalytics extends Maintenance {
	/**
	 * Main Executor
	 *
	 * @access	public
	 * @return	void
	 */
	public function execute() {
		\Hydralytics\DailyAnalyticsJob::run([], false);
	}
}

$maintClass = 'DailyAnalytics';
require_once(RUN_MAINTENANCE_IF_MAIN);
?>