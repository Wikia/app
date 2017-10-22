<?php
/**
 * Makes the required database updates for Special:ProtectedPages
 * to show all protected pages, even ones before the page restrictions
 * schema change. All remaining page_restriction column values are moved
 * to the new table.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/Maintenance.php' );

class PopulateLogUsertext extends LoggedUpdateMaintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Populates the log_user_text field";
		$this->setBatchSize( 100 );
	}

	protected function getUpdateKey() {
		return 'populate log_usertext';
	}

	protected function updateSkippedMessage() {
		return 'log_user_text column of logging table already populated.';
	}

	protected function doDBUpdates() {
		$db = $this->getDB( DB_MASTER );
		$start = $db->selectField( 'logging', 'MIN(log_id)', false, __METHOD__ );
		if ( !$start ) {
			$this->output( "Nothing to do.\n" );
			return true;
		}
		$end = $db->selectField( 'logging', 'MAX(log_id)', false, __METHOD__ );

		# Do remaining chunk
		$end += $this->mBatchSize - 1;
		$blockStart = $start;
		$blockEnd = $start + $this->mBatchSize - 1;

		while ( $blockEnd <= $end ) {
			$this->output( "...doing log_id from $blockStart to $blockEnd\n" );
			$res = $db->select(
				'logging',
				[ 'log_id', 'log_user' ],
				"log_id BETWEEN $blockStart AND $blockEnd",
				__METHOD__
			);

			$ids = [];

			foreach ( $res as $row ) {
				$ids[] = $row->log_user;
			}

			$res->rewind();

			$users = User::whoAre( $ids );

			$db->begin();
			foreach ( $res as $row ) {
				$db->update(
					'logging',
					[ 'log_user_text' => $users[ $row->log_user ] ],
					[ 'log_id' => $row->log_id ],
					__METHOD__
				);
			}
			$db->commit();
			$blockStart += $this->mBatchSize;
			$blockEnd += $this->mBatchSize;
			wfWaitForSlaves();
		}
		$this->output( "Done populating log_user_text field.\n" );
		return true;
	}
}

$maintClass = "PopulateLogUsertext";
require_once( RUN_MAINTENANCE_IF_MAIN );

