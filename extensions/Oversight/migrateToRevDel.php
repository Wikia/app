<?php
/**
 * Migrate revisions hidden with the Oversight extension to revdel.
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
 * Migrate revisions hidden with the Oversight extension to revdel.
 *
 * @ingroup Maintenance
 */
class MigrateOversightRevisions extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->setBatchSize( 20 );
		$this->mDescription = "Migrate revisions hidden with the Oversight extension to revdel.";
		$this->addOption( 'migrate', "Turn off dry-run mode and actually insert OS data into revision/archive table." );
	}

	/**
	 * Copied from SpecialOversight::getSelectFields so the script
	 * can run without the extension being enabled
	 *
	 * @return array
	 */
	private function getSelectFields() {
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
		$this->output( "Migrating oversighted revisions to suppressed revisions. This will not add anything to recentchanges.\n" );
		if ( !$this->hasOption( 'migrate' ) ) {
			    $this->output( "Dry-run mode on. To actually migrate revisions, run again with --migrate.\n" );
		}
		$count = 0;
		$dbw = wfGetDB( DB_MASTER );

		$userNames = array();
		$userNameQuery = wfGetDB( DB_SLAVE )->select(
			array( 'user', 'hidden' ),
			array( 'user_id', 'user_name' ),
			array(),
			__METHOD__,
			array(),
			array( 'hidden' => array( 'JOIN', 'hidden_user = user_id OR hidden_by_user = user_id' ) )
		);
		foreach ( $userNameQuery as $userRow ) {
			$userNames[$userRow->user_id] = $userRow->user_name;
		}

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

			$insertLoggingData = array();
			$insertRevisionData = array();
			$insertArchiveData = array();
			foreach ( $hiddenRows as $hiddenRow ) {
				if ( Revision::newFromId( $hiddenRow->hidden_rev_id ) ) {
					$this->output( "Ignoring revision {$hiddenRow->hidden_rev_id} as it is already in the revision table.\n" );
					$lastRevId = $hiddenRow->hidden_rev_id;
					continue;
				}
				$insertData = array();

				$latestRevision = Revision::newFromPageId( $hiddenRow->hidden_page );
				$pageExists = $latestRevision !== null;
				if ( $pageExists && $latestRevision->getTimestamp() < wfTimestamp( TS_MW, $hiddenRow->hidden_timestamp ) ) {
					$this->output( "Warning: Revision ID {$hiddenRow->hidden_rev_id} will be inserted into the archive (like a deleted page) instead of revision to avoid revealing suppressed information (it is newer than any live revision).\n" );
					$pageExists = false;
				}

				$fieldPrefix = $pageExists ? 'rev_' : 'ar_';
				$tableName = $pageExists ? 'revision' : 'archive';

				$revIdFieldName = $tableName == 'archive' ? 'ar_rev_id' : 'rev_id';
				$pageIdFieldName = $fieldPrefix . 'page' . ( $tableName == 'archive' ? '_id' : '' );

				$insertData[$pageIdFieldName] = $hiddenRow->hidden_page;
				$insertData[$revIdFieldName] = $hiddenRow->hidden_rev_id;
				$insertData[$fieldPrefix . 'text_id'] = $hiddenRow->hidden_text_id;
				$insertData[$fieldPrefix . 'comment'] = $hiddenRow->hidden_comment;
				$insertData[$fieldPrefix . 'user'] = $hiddenRow->hidden_user;
				$insertData[$fieldPrefix . 'user_text'] = isset( $userNames[$hiddenRow->hidden_user] ) ? $userNames[$hiddenRow->hidden_user] : $hiddenRow->hidden_user_text;
				$insertData[$fieldPrefix . 'timestamp'] = $hiddenRow->hidden_timestamp;
				$insertData[$fieldPrefix . 'minor_edit'] = $hiddenRow->hidden_minor_edit;
				// Hide revision text, edit summary, editor's username/IP, even from admins.
				$insertData[$fieldPrefix . 'deleted'] = Revision::DELETED_TEXT | Revision::DELETED_COMMENT | Revision::DELETED_USER | Revision::DELETED_RESTRICTED;

				$rev = Revision::newFromRow( $hiddenRow );
				$text = $rev->getRawText();

				$insertData[$fieldPrefix . 'len'] = strlen( $text );
				$insertData[$fieldPrefix . 'sha1'] = Revision::base36Sha1( $text );

				if ( $dbw->selectField(
					'archive',
					'ar_rev_id',
					array(
						'ar_rev_id' => $hiddenRow->hidden_rev_id,
						'ar_sha1' => $insertData[$fieldPrefix . 'sha1'],
						'ar_timestamp' => $hiddenRow->hidden_timestamp
					),
					__METHOD__
				) ) {
					$this->output( "Ignoring revision {$hiddenRow->hidden_rev_id} as it is already in the archive table.\n" );
					$lastRevId = $hiddenRow->hidden_rev_id;
					continue;
				}

				if ( $tableName == 'archive' ) {
					$insertData['ar_parent_id'] = null;
					$insertData['ar_namespace'] = $hiddenRow->hidden_namespace;
					$insertData['ar_title'] = $hiddenRow->hidden_title;
				} else {
					$parentIdFromTables = array(
						$dbw->selectRow(
							'revision',
							array( 'rev_id', 'rev_timestamp AS timestamp' ),
							array(
								'rev_page' => $hiddenRow->hidden_page,
								'rev_timestamp < ' . $dbw->addQuotes( $hiddenRow->hidden_timestamp ),
								'rev_id < ' . $dbw->addQuotes( $hiddenRow->hidden_rev_id )
							),
							__METHOD__,
							array( 'ORDER BY' => 'rev_timestamp DESC' )
						),
						$dbw->selectRow(
							'hidden',
							array( 'hidden_rev_id AS rev_id', 'hidden_timestamp AS timestamp' ),
							array(
								'hidden_page' => $hiddenRow->hidden_page,
								'hidden_timestamp < ' . $dbw->addQuotes( $hiddenRow->hidden_timestamp ),
								'hidden_rev_id < ' . $dbw->addQuotes( $hiddenRow->hidden_rev_id )
							),
							__METHOD__,
							array( 'ORDER BY' => 'hidden_timestamp DESC' )
						),
						$dbw->selectRow(
							'archive',
							array( 'ar_rev_id AS rev_id', 'ar_timestamp AS timestamp' ),
							array(
								'ar_page_id' => $hiddenRow->hidden_page,
								'ar_timestamp < ' . $dbw->addQuotes( $hiddenRow->hidden_timestamp ),
								'ar_rev_id < ' . $dbw->addQuotes( $hiddenRow->hidden_rev_id ),
								'ar_namespace' => $hiddenRow->hidden_namespace,
								'ar_title' => $hiddenRow->hidden_title
							),
							__METHOD__,
							array( 'ORDER BY' => 'ar_timestamp DESC' )
						)
					);

					$timestampsToRevIds = array();
					foreach ( $parentIdFromTables as $parentIdFromTable ) {
						if ( $parentIdFromTable != false ) {
							$timestampsToRevIds[$parentIdFromTable->timestamp] = $parentIdFromTable->rev_id;
						}
					}

					if ( count( $timestampsToRevIds ) == 0 ) {
						$insertData['rev_parent_id'] = 0;
						$this->output( "Warning: There may be an issue with revision ID {$hiddenRow->hidden_rev_id}. It has rev_parent_id=0 which means that it may be treated as a revision which starts a new page.\n" );
					} else {
						$highestTimestamp = max( array_keys( $timestampsToRevIds ) );
						$insertData['rev_parent_id'] = $timestampsToRevIds[$highestTimestamp];
					}
				}

				if ( $tableName == 'revision' ) {
					$insertRevisionData[] = $insertData;
				} else {
					$insertArchiveData[] = $insertData;
				}

				$logData = array(
					'log_type'      => 'suppress',
					'log_action'    => 'revision',
					'log_timestamp' => $hiddenRow->hidden_on_timestamp,
					'log_user'      => $hiddenRow->hidden_by_user,
					'log_user_text' => isset( $userNames[$hiddenRow->hidden_by_user] ) ? $userNames[$hiddenRow->hidden_by_user] : null,
					'log_namespace' => $hiddenRow->hidden_namespace,
					'log_title'     => $hiddenRow->hidden_title,
					'log_page'      => $hiddenRow->hidden_page,
					'log_comment'   => $hiddenRow->hidden_reason,
					'log_params'    => "revision\n" . $hiddenRow->hidden_rev_id . "\nofield=" . $hiddenRow->hidden_deleted . "\nnfield=" . $insertData[$fieldPrefix . 'deleted'], //'revision', rev_id, old bits, new bits
				);
				if ( $logData['log_user_text'] === null ) {
					throw new Exception( 'Unable to get user text for user ID ' . $hiddenRow->hidden_by_user . ' who hid revision ID ' . $hiddenRow->hidden_rev_id );
				}
				$insertLoggingData[] = $logData;

				$lastRevId = $hiddenRow->hidden_rev_id;
				$count++;
			}

			if ( $this->getOption( 'migrate' ) ) {
				$dbw->begin( __METHOD__ );

				$dbw->insert( 'revision', $insertRevisionData, __METHOD__ );
				$dbw->insert( 'archive', $insertArchiveData, __METHOD__ );
				$dbw->insert( 'logging', $insertLoggingData, __METHOD__ );

				$dbw->commit( __METHOD__ );
			}
		} while ( $hiddenRows->numRows() === $this->mBatchSize );

		$this->output( "Done! $count oversighted revision(s) are now converted to suppressed revisions.\n" );
	}
}

$maintClass = "MigrateOversightRevisions";
require_once( RUN_MAINTENANCE_IF_MAIN );
