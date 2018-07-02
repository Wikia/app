<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_ALL ^ E_NOTICE );

require_once( dirname( __FILE__ ) . '/../../../../maintenance/Maintenance.php' );

use Swagger\Client\Discussion\Api\SitesApi;
use Wikia\Factory\ServiceFactory;
use Wikia\Logger\WikiaLogger;


class CloseSingleWiki extends Maintenance {
	protected $delay = 5;
	/**
	 * constructor
	 *
	 * @access public
	 */
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Closes single wiki';
		$this->addOption( 'delay', 'Set time before deletion starts (in seconds)', false, true, 'd' );
		$this->addOption( 'cluster', 'Which cluster to operate on', false, true, 'c');
	}

	public function execute() {
		global $wgUser, $wgCityId;

		$this->delay = $this->getOption( 'delay', 5 );
		$cluster   = isset( $this->mOptions[ "cluster" ] ) ? $this->mOptions[ "cluster" ] : false; // eg. c6

		$wgUser = User::newFromName( Wikia::BOT_USER ); // Make changes as FANDOMbot

		$this->output( 'Closing wiki with id: ' . $wgCityId );
		$where = array(
			"city_id" => $wgCityId,
		);

		if ($cluster !== false) {
			$where[ "city_cluster" ] = $cluster;
		}

		if( $this->delay > 0 ) {
			$this->output( sprintf( 'Will start deleting in %d seconds', $this->delay ) );
			sleep( $this->delay );
		}

		$dbr = WikiFactory::db( DB_SLAVE );
		$sth = $dbr->select(
			[ "city_list" ],
			[ "city_id", "city_flags", "city_dbname", "city_cluster", "city_url", "city_public", "city_last_timestamp" ],
			$where,
			__METHOD__,
			[ "LIMIT" => 1 ]
		);

		if( $sth->numRows() != 1 ) {
			$this->output( sprintf( "Could not fetch data from `city_list`, num rows: %d", $sth->numRows() ) );
			return 1;
		}

		$row = $dbr->fetchObject( $sth );

		$this->removeBucket( $wgCityId );

		$this->output( "Cleaning the shared database" );

		if( !WikiFactory::isInArchive( $wgCityId ) ) {
			$this->output( "Moving to archive" );
			WikiFactory::copyToArchive( $wgCityId );
		}

		$dbw = WikiFactory::db( DB_MASTER );
		$dbw->delete(
			"city_list",
			array(
				"city_id" => $wgCityId
			),
			__METHOD__
		);

		$dbw->delete(
			"city_variables",
			array(
				"cv_city_id" => $wgCityId
			),
			__METHOD__
		);
		$this->output( sprintf( "%d removed from WikiFactory tables", $wgCityId ) );

		$this->cleanupSharedData( intval( $wgCityId ) );

		/**
		 * drop database, get db handler for proper cluster
		 */
		global $wgDBadminuser, $wgDBadminpassword;
		$centralDB = empty( $cluster) ? "wikicities" : "wikicities_{$cluster}";

		/**
		 * get connection but actually we only need info about host
		 */
		$local = wfGetDB( DB_MASTER, array(), $centralDB );
		$server = $local->getLBInfo( 'host' );

		try {
			$dbw = new DatabaseMysqli([
				'host' => $server,
				'user' => $wgDBadminuser,
				'password' => $wgDBadminpassword,
				'dbname' => $centralDB,
				'flags' => 0,
				'tablePrefix' => 'get from global',
			]);
			$dbw->begin( __METHOD__ );
			$dbw->query( "DROP DATABASE `{$row->city_dbname}`" );
			$dbw->commit( __METHOD__ );
			$this->output( "{$row->city_dbname} dropped from cluster" );
		}
		catch( Exception $e ) {
			$this->output( "{$row->city_dbname} database drop failed! {$e->getMessage()}" );
			$this->info( 'drop database', [
				'cluster'   => $cluster,
				'dbname'    => $row->city_dbname,
				'exception' => $e,
				'server'    => $server
			] );
		}

		/**
		 * update search index
		 */
		$indexer = new Wikia\Search\Indexer();
		$indexer->deleteWikiDocs( $wgCityId );
		$this->output( "Wiki documents removed from index" );

		/**
		 * let other extensions remove entries for closed wiki
		 */
		try {
			Hooks::run( 'WikiFactoryDoCloseWiki', [ $row ] );
		} catch ( Exception $ex ) {
			// SUS-4606 | catch exceptions instead of stopping the script
			WikiaLogger::instance()->error( 'WikiFactoryDoCloseWiki hook processing returned an error', [
				'exception' => $ex,
				'wiki_id' => (int) $wgCityId
			] );
			$this->output( "Error running WikiFactoryDoCloseWiki hook: " . $ex->getMessage() );
			return 2;
		}

		$this->removeDiscussions( $wgCityId );

		$this->output( 'Wiki closed' );
	}

	/**
	 * Remove DFS bucket of a given wiki
	 * @param int $cityId
	 */
	private function removeBucket( int $cityId ) {
		try {
			$swift = \Wikia\SwiftStorage::newFromWiki( $cityId );
			$this->output( sprintf( "Removing DFS bucket /%s%s", $swift->getContainerName(), $swift->getPathPrefix() ) );

			// get the list of all objects in wiki images sub-bucket
			$path = ltrim( $swift->getPathPrefix(), '/' );
			$objectsToDelete = $swift->getContainer()->list_objects_recursively( $path );

			// now delete them all
			foreach( $objectsToDelete as $object ) {
				$swift->getContainer()->delete_object( $object );
			}
		} catch ( Exception $ex ) {
			$this->output( __METHOD__ . ' - ' . $ex->getMessage() );

			Wikia\Logger\WikiaLogger::instance()->error( 'Removing DFS files failed', [
				'exception' => $ex,
				'city_id' => $cityId
			] );
		}
	}

	/**
	 * Clean up the shared data for a given wiki ID
	 *
	 * @param int $city_id
	 */
	private function cleanupSharedData( $city_id ) {
		global $wgExternalDatawareDB, $wgSpecialsDB;
		$dataware = wfGetDB( DB_MASTER, [], $wgExternalDatawareDB );
		$specials = wfGetDB( DB_MASTER, [], $wgSpecialsDB );

		/**
		 * remove records from stats-related tables
		 */
		$this->doTableCleanup( $dataware, 'pages',              $city_id, 'page_wikia_id' );
		$this->doTableCleanup( $specials, 'events_local_users', $city_id );

		Hooks::run( 'CloseWikiPurgeSharedData', [ $city_id ] );
	}

	/**
	 * Perform a database cleanup for a given wiki
	 *
	 * This method waits for slaves to catch up after every DELETE query that affected at least one row
	 *
	 * @param DatabaseBase $db database handler
	 * @param string $table name of table to clean up
	 * @param int $city_id ID of wiki to remove from the table
	 * @param string $wiki_id_column table column name to use when querying for wiki ID (defaults to "wiki_id")
	 *
	 * @throws DBUnexpectedError
	 * @throws MWException
	 */
	private function doTableCleanup( DatabaseBase $db, $table, $city_id, $wiki_id_column = 'wiki_id' ) {
		$db->delete( $table, [ $wiki_id_column => $city_id ], __METHOD__ );

		$this->output( sprintf( "#%d: removed %d rows from %s.%s table", $city_id, $db->affectedRows(), $db->getDBname(), $table ) );

		// throttle delete queries
		if ( $db->affectedRows() > 0 ) {
			wfWaitForSlaves( $db->getDBname() );
		}
	}

	private function removeDiscussions( int $cityId ) {
		try {
			$this->getSitesApi()->hardDeleteSite( $cityId, F::app()->wg->TheSchwartzSecretToken );
		}
		catch ( \Swagger\Client\ApiException $e ) {
			WikiaLogger::instance()
				->error( "{$cityId} Failed to hard delete Discussion site: {$e->getMessage()} \n" );
			$this->output( "Failed to delete Discussion: " . $e->getMessage() );
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
}

$maintClass = "CloseSingleWiki";
require_once( RUN_MAINTENANCE_IF_MAIN );
