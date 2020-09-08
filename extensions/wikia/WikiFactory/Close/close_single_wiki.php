<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_ALL ^ E_NOTICE );

require_once __DIR__ . '/../../../../maintenance/Maintenance.php';
require_once __DIR__ . '/gcs_bucket_remover.php';

use Swagger\Client\Discussion\Api\SitesApi;
use Wikia\Factory\ServiceFactory;
use Wikia\Logger\WikiaLogger;

class CloseSingleWiki extends Maintenance {

	protected $delay = 5;
	protected $dropIndex = false;

	/**
	 * constructor
	 *
	 * @access public
	 */
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Closes single wiki';
		$this->addOption( 'delay', 'Set time before deletion starts (in seconds)', false, true, 'd' );
		$this->addOption( 'drop-search-index', 'Should we delete search results from Solr', false, false, 's' );
		$this->addOption( 'cluster', 'Which cluster to operate on', false, true, 'c' );
	}

	public function execute() {
		global $wgUser, $wgCityId;

		$this->delay = $this->getOption( 'delay', 5 );
		$this->dropIndex = $this->getOption( 'drop-search-index', false );
		$cluster = isset( $this->mOptions['cluster'] ) ? $this->mOptions['cluster'] : false; // eg. c6

		$wgUser = User::newFromName( Wikia::BOT_USER ); // Make changes as FANDOMbot

		$this->output( 'Closing wiki with id: ' . $wgCityId );
		$where = [
			'city_id' => $wgCityId,
		];

		if ( $cluster !== false ) {
			$where['city_cluster'] = $cluster;
		}

		if ( $this->delay > 0 ) {
			$this->output( sprintf( 'Will start deleting in %d seconds', $this->delay ) );
			sleep( $this->delay );
		}

		$dbr = WikiFactory::db( DB_SLAVE );
		$row = $dbr->selectRow( [ 'city_list' ], [
			'city_id',
			'city_flags',
			'city_dbname',
			'city_cluster',
			'city_url',
			'city_public',
			'city_last_timestamp',
		], $where, __METHOD__, [ 'LIMIT' => 1 ] );

		if ( $row == false ) {
			$this->output( sprintf( 'Could not fetch data from `city_list`' ) );

			return;
		}

		( new GcsBucketRemover() )->remove( $wgCityId );

		$this->output( 'Cleaning the shared database' );

		if ( !WikiFactory::isInArchive( $wgCityId ) ) {
			$this->output( 'Moving to archive' );
			WikiFactory::copyToArchive( $wgCityId );
		}

		$dbw = WikiFactory::db( DB_MASTER );
		$dbw->delete( 'city_list', [
			'city_id' => $wgCityId,
		], __METHOD__ );

		$dbw->delete( 'city_variables', [
			'cv_city_id' => $wgCityId,
		], __METHOD__ );
		$this->output( sprintf( '%d removed from WikiFactory tables', $wgCityId ) );

		$this->cleanupSharedData( intval( $wgCityId ) );

		/**
		 * drop database, get db handler for proper cluster
		 */ global $wgDBadminuser, $wgDBadminpassword;
		$centralDB = empty( $cluster ) ? 'wikicities' : "wikicities_{$cluster}";

		/**
		 * get connection but actually we only need info about host
		 */
		$local = wfGetDB( DB_MASTER, [], $centralDB );
		$server = $local->getLBInfo( 'host' );

		try {
			$dbw = new DatabaseMysqli( [
				'host' => $server,
				'user' => $wgDBadminuser,
				'password' => $wgDBadminpassword,
				'dbname' => $centralDB,
				'flags' => 0,
				'tablePrefix' => 'get from global',
			] );
			$dbw->begin( __METHOD__ );
			$dbw->query( "DROP DATABASE `{$row->city_dbname}`" );
			$dbw->commit( __METHOD__ );
			$this->output( "{$row->city_dbname} dropped from cluster" );
		}
		catch ( Exception $e ) {
			$this->output( "{$row->city_dbname} database drop failed! {$e->getMessage()}" );
			$this->info( 'drop database', [
				'cluster' => $cluster,
				'dbname' => $row->city_dbname,
				'exception' => $e,
				'server' => $server,
			] );
		}

		if ( $this->dropIndex ) {
			/**
			 * update search index
			 */
			$indexer = new Wikia\Search\Indexer();
			$indexer->deleteWikiDocs( $wgCityId );
			$this->output( 'Wiki documents removed from index' );
		}

		/**
		 * let other extensions remove entries for closed wiki
		 */
		try {
			Hooks::run( 'WikiFactoryDoCloseWiki', [ $row ] );
		}
		catch ( Exception $ex ) {
			// SUS-4606 | catch exceptions instead of stopping the script
			WikiaLogger::instance()->error( 'WikiFactoryDoCloseWiki hook processing returned an error', [
				'exception' => $ex,
				'wiki_id' => (int)$wgCityId,
			] );
			$this->output( 'Error running WikiFactoryDoCloseWiki hook: ' . $ex->getMessage() );

			return;
		}

		$this->removeDiscussions( $wgCityId );

		$this->purgeCachesForWiki( $wgCityId );

		$this->output( 'Wiki closed' );
	}

	/**
	 * Clean up the shared data for a given wiki ID
	 *
	 * @param int $cityId
	 */
	private function cleanupSharedData( $cityId ) {
		global $wgExternalDatawareDB, $wgSpecialsDB;
		$dataware = wfGetDB( DB_MASTER, [], $wgExternalDatawareDB );
		$specials = wfGetDB( DB_MASTER, [], $wgSpecialsDB );

		/**
		 * remove records from stats-related tables
		 */
		$this->doTableCleanup( $dataware, 'pages', $cityId, 'page_wikia_id' );
		$this->doTableCleanup( $specials, 'events_local_users', $cityId );
		$this->doTableCleanup( $specials, 'local_user_groups', $cityId );
	}

	/**
	 * Perform a database cleanup for a given wiki
	 *
	 * This method waits for slaves to catch up after every DELETE query that affected at least one row
	 *
	 * @param DatabaseBase $db database handler
	 * @param string $table name of table to clean up
	 * @param int $cityId ID of wiki to remove from the table
	 * @param string $wikiIdColumn table column name to use when querying for wiki ID (defaults to "wiki_id")
	 *
	 * @throws DBUnexpectedError
	 * @throws MWException
	 */
	private function doTableCleanup( DatabaseBase $db, $table, $cityId, $wikiIdColumn = 'wiki_id' ) {
		$db->delete( $table, [ $wikiIdColumn => $cityId ], __METHOD__ );

		$this->output( sprintf( '#%d: removed %d rows from %s.%s table', $cityId, $db->affectedRows(), $db->getDBname(),
			$table ) );

		// throttle delete queries
		if ( $db->affectedRows() > 0 ) {
			wfWaitForSlaves( $db->getDBname() );
		}
	}

	private function removeDiscussions( int $cityId ) {
		try {
			$this->getSitesApi()->softDeleteSite( $cityId, F::app()->wg->TheSchwartzSecretToken );
			$this->getSitesApi()->hardDeleteSite( $cityId, F::app()->wg->TheSchwartzSecretToken );
		}
		catch ( \Swagger\Client\ApiException $e ) {
			WikiaLogger::instance()->error( "{$cityId} Failed to hard delete Discussion site: {$e->getMessage()} \n" );
			$this->output( 'Failed to delete Discussion: ' . $e->getMessage() );
		}
	}

	/**
	 * @return SitesApi
	 */
	private function getSitesApi() {
		$apiProvider = ServiceFactory::instance()->providerFactory()->apiProvider();

		/** @var SitesApi $api */
		$api = $apiProvider->getApi( 'discussion', SitesApi::class );
		$api->getApiClient()->getConfig()->setCurlTimeout( 5 );

		return $api;
	}

	protected function output( $out, $channel = null ) {
		global $wgCityId;

		parent::output( sprintf( "%d: %s\n", $wgCityId, $out ), $channel );
	}

	private function purgeCachesForWiki( $wikiId ) {
		WikiFactory::clearCache( $wikiId );

		Wikia::purgeSurrogateKey( Wikia::wikiSurrogateKey( $wikiId ) );
	}
}

$maintClass = 'CloseSingleWiki';
require_once RUN_MAINTENANCE_IF_MAIN;
