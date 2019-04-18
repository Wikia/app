<?php
ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_ALL ^ E_NOTICE );

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

use \Wikia\Logger\WikiaLogger;
use Wikia\Util\Statistics\BernoulliTrial;

/**
 * Script to migrate a user changes log from www.wikia.com to community.fandom.com.
 *.
 */
class MigrateCheckUser extends Maintenance {
	const BATCH_SIZE = 1000;
	const CU_LOG_TABLE= 'cu_log';
	const CU_CHANGES_TABLE= 'cu_changes';

	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Migrates user changes logs from www.wikia.com to community.fandom.com';
		$this->addOption( 'saveChanges', 'Migrate log data for real.',
			false, false,	'd' );
	}

	public function execute() {
		$saveChanges = $this->hasOption( 'saveChanges' );

		$srcDB = wfGetDB( DB_SLAVE, [], 'wikiaglobal' );
		$dstMaster = wfGetDB( DB_MASTER, [], 'wikia' );
		// this script would generate a ton of db logs, disable them
		$zeroSampler =  new BernoulliTrial( 0.0 );
		$srcDB->setSampler( $zeroSampler );
		$dstMaster->setSampler( $zeroSampler );

		$logLastId = 0;
		$logLastTimestamp = 0;
		$logMigrated = 0;
		$changesLastId = 0;
		$changesLastTimestamp = 0;
		$changesMigrated = 0;

		while(true) {
			$res = $srcDB->select(
				self::CU_LOG_TABLE,
				'*',
				"cul_id > $logLastId",
				__METHOD__,
				[ 'ORDER BY' => 'cul_id ASC', 'LIMIT' => self::BATCH_SIZE ] );
			$count = $res->numRows();
			WikiaLogger::instance()->info( 'Processing next batch',
				[ 'rows' => $count , 'lastTimestamp' => $logLastTimestamp ]
			);
			if ($count <= 0) {
				break;
			}
			foreach ( $res as $row ) {
				$logLastId = $row->cul_id;
				$logLastTimestamp = $row->cul_timestamp;
				$logMigrated += 1;
				if ( $saveChanges ) {
					$dstMaster->insert(
						self::CU_LOG_TABLE,
						[
							'cul_timestamp' => $row->cul_timestamp,
							'cul_user' => $row->cul_user,
							'cul_user_text' => $row->cul_user_text,
							'cul_reason' => $row->cul_reason,
							'cul_type' => $row->cul_type,
							'cul_target_id' => $row->cul_target_id,
							'cul_target_text' => $row->cul_target_text,
							'cul_target_hex' => $row->cul_target_hex,
							'cul_range_start' => $row->cul_range_start,
							'cul_range_end' => $row->cul_range_end,
						],
						__METHOD__
					);
				}
			}
		}

		while(true) {
			$res = $srcDB->select(
				self::CU_CHANGES_TABLE,
				'*',
				"cuc_id > $changesLastId",
				__METHOD__,
				[ 'ORDER BY' => 'cuc_id ASC', 'LIMIT' => self::BATCH_SIZE ] );
			$count = $res->numRows();
			WikiaLogger::instance()->info( 'Processing next batch',
				[ 'rows' => $count , 'lastTimestamp' => $changesLastTimestamp ]
			);
			if ($count <= 0) {
				break;
			}
			foreach ( $res as $row ) {
				$changesLastId = $row->cuc_id;
				$changesLastTimestamp = $row->cuc_timestamp;
				$changesMigrated += 1;
				if ( $saveChanges ) {
					$dstMaster->insert(
						self::CU_CHANGES_TABLE,
						[
							'cuc_namespace' => $row->cuc_namespace,
							'cuc_title' => $row->cuc_title,
							'cuc_user' => $row->cuc_user,
							'cuc_actiontext' => $row->cuc_actiontext,
							'cuc_comment' => $row->cuc_comment,
							'cuc_minor' => $row->cuc_minor,
							'cuc_page_id' => $row->cuc_page_id,
							'cuc_this_oldid' => $row->cuc_this_oldid,
							'cuc_last_oldid' => $row->cuc_last_oldid,
							'cuc_type' => $row->cuc_type,
							'cuc_timestamp' => $row->cuc_timestamp,
							'cuc_ip' => $row->cuc_ip,
							'cuc_ip_hex' => $row->cuc_ip_hex,
							'cuc_xff' => $row->cuc_xff,
							'cuc_xff_hex' => $row->cuc_xff_hex,
							'cuc_agent' => $row->cuc_agent,
						],
						__METHOD__
					);
				}
			}
		}

		WikiaLogger::instance()->info('Finished',
			[
				'log_migrated' => $logMigrated
			]
		);
	}
}

$maintClass = "MigrateCheckUser";
require_once( RUN_MAINTENANCE_IF_MAIN );
