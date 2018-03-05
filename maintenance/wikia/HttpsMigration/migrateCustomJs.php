<?php

/**
 * Maintenance script to migrate image urls included in custom JS files to https/protocol relative
 * @usage
 *  # this will migrate assets for wiki with ID 119:
 *  run_maintenance --script='wikia/HttpsMigration/migrateCustomJs.php  --saveChanges' --id=119
 *  # running on some wikis in dry mode and dumping url changes to a csv file:
 *  run_maintenance --script='wikia/HttpsMigration/migrateCustomJss.php --file migrate_js.csv' --where='city_id < 10000'
 *
 */

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_ALL ^ E_NOTICE );

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

use \Wikia\Logger\WikiaLogger;

/**
 * Class MigrateCustomCJsToHttps
 */
class MigrateCustomJsToHttps extends Maintenance {

	protected $saveChanges  = false;
	protected $fh;	// handle to the output csv file

	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Migrates image urls in custom JS assets to HTTPS';
		$this->addOption( 'saveChanges', 'Edit articles for real.', false, false, 'd' );
		$this->addOption( 'file', 'CSV file where to save values that are going to be altered', false, true, 'f' );
	}

	public function __destruct()  {
		if ( $this->fh ) {
			fclose( $this->fh );
		}
	}

	/**
	 * Logs urls value change if the new value is different than the old one.
	 */
	public function logUrlChange( $description, $oldValue, $newValue ) {
		global $wgCityId;
		if ( $oldValue !== $newValue ) {
			if ( $this->fh ) {
				fputcsv( $this->fh,
					[ $wgCityId, $this->currentTitle->getDBkey(), $description, $oldValue, $newValue ] );
			}
		}
	}


	/**
	 * Process JS source code upgrading urls to https/protocol-relative.
	 * @param $text JS source code
	 * @return mixed Updated JS source code
	 */
	public function updateJSContent( $text ) {
		return $text;
	}

	/**
	 * If possible, make the JS https-ready and save the updated content (if not running in dry mode)
	 */
	public function migrateJS( Title $title ) {
		$revId = $title->getLatestRevID();
		$this->currentTitle = $title;
		$revision = Revision::newFromId( $revId );
		if( !is_null( $revision ) ) {
			$text = $revision->getText();
			$updatedText = $this->updateJSContent( $text );
			if ($text !== $updatedText) {
				if ( $this->saveChanges ) {
					// make changes
					// pay attention to JS-review process. if the latest revision is the same as
					// the one returned from ContentReviewHelper's getReviewedRevisionId, just autoapprove
					// (which requires FANDOMBot to be added to the content review group.
					// autoapprove can be set by using wpApprove parameter.
					// if the current JS revision is not approved yet, do not autoapprove JS changes!
				}
				return true;
			}
		}
		return false;
	}

	public function execute() {
		global $wgUser, $wgCityId;

		$wgUser = User::newFromName( Wikia::BOT_USER ); // Make changes as FANDOMbot

		$this->saveChanges = $this->hasOption( 'saveChanges' );
		$fileName = $this->getOption( 'file', false );
		if ( $fileName ) {
			$this->fh = fopen( $fileName, "a" );
			if ( !$this->fh ) {
				$this->error( "Could not open file '$fileName' for write!'\n" );
				return false;
			}
		}

		$this->output( "Running on city " . $wgCityId . "\n" );

		$this->db = wfGetDB( DB_SLAVE );

		$where = [ 'page_namespace' => NS_MEDIAWIKI, 'page_is_redirect' => 0 ];
		$options = [ 'ORDER BY' => 'page_title ASC' ];
		$result = $this->db->select( 'page', [ 'page_id', 'page_title', 'page_is_redirect' ], $where, __METHOD__, $options );
		$migratedFiles = 0;
		foreach( $result as $row ) {
			$title = Title::makeTitle( NS_MEDIAWIKI, $row->page_title );
			if ( $title->isJsPage() ) {
				$this->output( "Processing JS file {$row->page_title}...\n" );
				if ( $this->migrateJS( $title ) ) {
					$migratedFiles += 1;
				}
			}
		}
		$result->free();
		$this->output( "Migrated {$migratedFiles} JS files.\n" );
	}

}

$maintClass = "MigrateCustomJsToHttps";
require_once( RUN_MAINTENANCE_IF_MAIN );