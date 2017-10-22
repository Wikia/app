<?php
/**
 * Fix log_search for revisions migrated from the Oversight extension to revdel.
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
 * @file
 * @ingroup Maintenance
 */

// Detect $IP
$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false ) {
	$IP = __DIR__ . '/../..';
}

// Require base maintenance class
require_once( "$IP/maintenance/Maintenance.php" );
/**
 * Fix log_search for revisions migrated from the Oversight extension to revdel.
 *
 * @ingroup Maintenance
 */
class FixMigratedOversightRevisions extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->setBatchSize( 20 );
		$this->mDescription = "Fix log_search for revisions migrated from the Oversight extension to revdel.";
		$this->addOption( 'fix', "Turn off dry-run mode and actually insert OS data into revision/archive table." );
	}

	/**
	 * Copied from SpecialOversight::getSelectFields so the script
	 * can run without the extension being enabled
	 *
	 * @return array
	 */
	public function getSelectFields() {
		return array( 'hidden_page as page_id',
			'hidden_namespace as page_namespace',
			'hidden_title as page_title',

			'hidden_page as rev_page',
			'hidden_comment as rev_comment',
			'hidden_user as rev_user',
			'hidden_user_text as rev_user_text',
			'hidden_timestamp as rev_timestamp',
			'hidden_minor_edit as rev_minor_edit',
			'hidden_deleted as rev_deleted',
			'hidden_rev_id as rev_id',
			'hidden_text_id as rev_text_id',

			'0 as rev_len',

			'hidden_by_user',
			'hidden_on_timestamp',
			'hidden_reason',

			'user_name',

			'0 as page_is_new',
			'0 as rc_id',
			'1 as rc_patrolled',
			'0 as rc_old_len',
			'0 as rc_new_len',
			'0 as rc_params',

			'NULL AS rc_log_action',
			'0 AS rc_deleted',
			'0 AS rc_logid',
			'NULL AS rc_log_type',
			'NULL AS rev_parent_id'
		);
	}

	public function execute() {
		$this->output( "Fixing log_search for revisions migrated from the Oversight extension to revdel.\n" );
		if ( !$this->hasOption( 'fix' ) ) {
			    $this->output( "Dry-run mode on. To actually fix log_search, run again with --fix.\n" );
		}

		$count = 0;
		$dbw = wfGetDB( DB_MASTER );

		$selectFields = array_merge( $this->getSelectFields(), array( "{$dbw->tableName('hidden')}.*" ) );
		$lastRevId = "-1";

		do {
			$hiddenRows = $dbw->select(
				array( 'hidden', 'user' ),
				$selectFields,
				array( 'hidden_rev_id > ' . $dbw->addQuotes( $lastRevId ) ),
				__METHOD__,
				array( 'LIMIT' => $this->mBatchSize, 'ORDER BY' => 'hidden_rev_id' ),
				array( 'user' => array( 'INNER JOIN', 'user_id = hidden_by_user' ) )
			);
			$insertLogSearchData = array();
			foreach ( $hiddenRows as $hiddenRow ) {
				$latestRevision = Revision::newFromPageId( $hiddenRow->hidden_page );
				$pageExists = $latestRevision !== null;
				if ( $pageExists && $latestRevision->getTimestamp() < wfTimestamp( TS_MW, $hiddenRow->hidden_timestamp ) ) {
					$this->output( "Warning: Revision ID {$hiddenRow->hidden_rev_id} will be inserted into the archive (like a deleted page) instead of revision to avoid revealing suppressed information (it is newer than any live revision).\n" );
					$pageExists = false;
				}

				// Hide revision text, edit summary, editor's username/IP, even from admins.
				$deletedBits = Revision::DELETED_TEXT | Revision::DELETED_COMMENT | Revision::DELETED_USER | Revision::DELETED_RESTRICTED;

				$logData = array(
					'log_type'      => 'suppress',
					'log_action'    => 'revision',
					'log_timestamp' => $hiddenRow->hidden_on_timestamp,
					'log_user'      => $hiddenRow->hidden_by_user,
					'log_namespace' => $hiddenRow->hidden_namespace,
					'log_title'     => $hiddenRow->hidden_title,
					'log_page'      => $hiddenRow->hidden_page,
					'log_comment'   => $hiddenRow->hidden_reason,
					'log_params'    => "revision\n" . $hiddenRow->hidden_rev_id . "\nofield=" . $hiddenRow->hidden_deleted . "\nnfield=" . $deletedBits, //'revision', rev_id, old bits, new bits
				);

				// Find suppression log entry ID that was generated at the time of the migration
				$logID = $dbw->selectField( 'logging', 'log_id', $logData, __METHOD__ );

				if ( !$logID ) {
					$this->output( "Skipping for hidden_rev_id=" . $hiddenRow->hidden_rev_id . ", no suppression log entry found.\n" );
					continue;
				}

				$insertLogSearchData[] = array(
					'ls_field' => 'rev_id',
					'ls_value' => $hiddenRow->hidden_rev_id,
					'ls_log_id' => $logID
				);

				if ( $hiddenRow->hidden_user ) {
					$targetField = 'target_author_id';
					$targetValue = $hiddenRow->hidden_user;
				} else {
					$targetField = 'target_author_ip';
					$targetValue = $hiddenRow->hidden_user_text;
				}
				$insertLogSearchData[] = array(
					'ls_field' => $targetField,
					'ls_value' => $targetValue,
					'ls_log_id' => $logID
				);

				$lastRevId = $hiddenRow->hidden_rev_id;
				$count++;
			}

			if ( $this->getOption( 'fix' ) ) {
				$dbw->insert( 'log_search', $insertLogSearchData, __METHOD__, array( 'IGNORE' ) );
			}
		} while ( $hiddenRows->numRows() === $this->mBatchSize );

		if ( $this->getOption( 'fix' ) ) {
			$this->output( "Done! $count oversighted revision(s) should now be searchable.\n" );
		}
	}
}

$maintClass = "FixMigratedOversightRevisions";
require_once( RUN_MAINTENANCE_IF_MAIN );
