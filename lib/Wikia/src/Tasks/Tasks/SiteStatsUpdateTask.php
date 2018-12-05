<?php
namespace Wikia\Tasks\Tasks;

/**
 * SRE-109: Background task to update site stats (articles count, number of edits etc.)
 */
class SiteStatsUpdateTask extends BaseTask {

	/**
	 * @param int[] $deltas
	 */
	public function doUpdate( array $deltas ) {
		$siteStatsUpdate = \SiteStatsUpdate::factory( $deltas );
		$siteStatsUpdate->doUpdate();
	}
}
