<?php

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_ALL ^ E_NOTICE );

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

use \Wikia\Logger\WikiaLogger;
use Wikia\Util\Statistics\BernoulliTrial;

/**
 * Script to migrate a user creation log from www.wikia.com to community.fandom.com.
 *
 * It fetches all relevant rows from the logging table in wikiaglobal db and copies them to the
 * wikia db. While copying it checks for duplicates so running this twice shouldn't be a problem.
 */
class MigrateWikiaComLogging extends Maintenance {
	const BATCH_SIZE = 1000;
	const LOGGING_TABLE = 'logging';

	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Migrates newusers logs from www.wikia.com to community.fandom.com';
		$this->addOption( 'saveChanges', 'Migrate log data for real.',
			false, false,	'd' );
	}

	public function execute() {
		$saveChanges = $this->hasOption( 'saveChanges' );

		$srcDB = wfGetDB( DB_SLAVE, [], 'wikiaglobal' );
		$dstSlave = wfGetDB( DB_SLAVE, [], 'wikia' );
		$dstMaster = wfGetDB( DB_MASTER, [], 'wikia' );
		// this script would generate a lon of db logs, disable them
		$zeroSampler =  new BernoulliTrial( 0.0 );
		$srcDB->setSampler( $zeroSampler );
		$dstSlave->setSampler( $zeroSampler );
		$dstMaster->setSampler( $zeroSampler );

		$lastId = 0;
		$lastTimestamp = 0;
		$duplicates = 0;
		$migrated = 0;

		while(true) {
			$res = $srcDB->select(
				self::LOGGING_TABLE,
				'*',
				"log_id > $lastId AND log_type='newusers'",
				__METHOD__,
				[ 'ORDER BY' => 'log_id ASC', 'LIMIT' => self::BATCH_SIZE ] );
			$count = $res->numRows();
			WikiaLogger::instance()->info( 'Processing next batch',
				[ 'rows' => $count , 'lastTimestamp' => $lastTimestamp ]
			);
			if ($count <= 0) {
				break;
			}
			foreach ( $res as $row ) {
				$lastId = $row->log_id;
				$lastTimestamp = $row->log_timestamp;
				$duplicateRes = $dstSlave->select(
					self::LOGGING_TABLE,
					'log_id',
					[
						'log_timestamp' => $row->log_timestamp,
						'log_user' => $row->log_user,
					 	'log_type' => $row->log_type
					],
					__METHOD__
				);
				if ( $duplicateRes->numRows() >= 1 ) {
					$duplicates += 1;
				} else {
					$migrated += 1;
					if ( $saveChanges ) {
						$dstMaster->insert(
							self::LOGGING_TABLE,
							[
								'log_type' => $row->log_type,
								'log_action' => $row->log_action,
								'log_timestamp' => $row->log_timestamp,
								'log_user' => $row->log_user,
								'log_namespace' => $row->log_namespace,
								'log_title' => $row->log_title,
								'log_comment' => $row->log_comment,
								'log_params' => $row->log_params,
								'log_deleted' => $row->log_deleted,
								'log_page' => $row->log_page
							],
							__METHOD__
						);
					}
				}
			}
		}

		WikiaLogger::instance()->info('Finished',
			[
				'migrated' => $migrated,
				'duplicates' => $duplicates
			]
		);
	}
}

$maintClass = "MigrateWikiaComLogging";
require_once( RUN_MAINTENANCE_IF_MAIN );
