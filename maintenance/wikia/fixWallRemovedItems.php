<?php

/**
 * Script that fixes parent_comment_id in wall_history table
 * https://wikia-inc.atlassian.net/browse/CON-2022
 *
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '../../Maintenance.php' );

class FixWallRemovedItemsScript extends Maintenance {

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Wall Removed items fix';
	}

	public function execute() {
		global $wgCityId;

		$updateSQL = <<<EOD
update wall_history
set parent_comment_id = (
select parent_comment_id from (
/* need to create temporary table as we cannot update table from which we're selecting */
select * from wall_history
) wh2 where wh2.parent_comment_id is not null and comment_id = wh2.comment_id order by wh2.event_date desc limit 1
)
where parent_comment_id is null;
EOD;

		$db = wfGetDB(DB_MASTER);

		$countToUpdate = $db->selectField('wall_history', 'count(1)', ['parent_comment_id' => null]);
		if ($countToUpdate > 0) {
			$db->query($updateSQL);

			$countAfterUpdate = $db->selectField('wall_history', 'count(1)', ['parent_comment_id' => null]);

			$this->output("WikiId: $wgCityId, to update: $countToUpdate, after update: $countAfterUpdate\n");
		} else {
			$this->output("WikiId: $wgCityId, nothing to update\n");
		}
	}
}

$maintClass = 'FixWallRemovedItemsScript';
require_once( RUN_MAINTENANCE_IF_MAIN );
