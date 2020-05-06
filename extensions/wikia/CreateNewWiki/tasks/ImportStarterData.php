<?php

namespace Wikia\CreateNewWiki\Tasks;

use Wikia\CreateNewWiki\Starters;
use Wikia\Logger\Loggable;
use Google\Cloud\Storage\StorageClient;
use GuzzleHttp\Psr7\StreamWrapper;

class ImportStarterData extends Task {

	use Loggable;

	const ERR_OPEN_STARTER_DUMP_FAILED = 1;
	const ERR_NO_PAGES_IMPORTED = 2;
	const ERR_SQL_IMPORT_FAILED = 3;
	const ERR_RUN_UPDATES_FAILED = 4;

	const MAX_REPLICATION_WAIT_MILLIS = 1250;

	const BUCKET_NAME_PROD = 'create-new-wiki';
	const BUCKET_NAME_DEV = 'create-new-wiki-dev';

	public function run() {
		global $wgContLang;

		// I need to pass $this->sDbStarter to CreateWikiLocalJob::changeStarterContributions
		$starterDatabase = Starters::getStarterByLanguage( $this->taskContext->getLanguage() );
		$this->taskContext->setStarterDb( $starterDatabase );

		// import a starter database XML dump from DFS
		$then = microtime( true );

		$language = $wgContLang->getCode();
		$starter = Starters::getStarterByLanguage( $language );

		try {
			$contentDumpStream = $this->getDump( Starters::getStarterContentDumpPath( $starter ) );

			try {
				$this->importDump( $contentDumpStream );
			} finally {
				fclose( $contentDumpStream );
			}

			$this->waitUntilMainPageExists();
			$this->runUpdates();

		} catch ( \CreateWikiException $ex ) {
			$this->error( __METHOD__ - ' starter dump import failed', [ 'exception' => $ex ] );
			return TaskResult::createForError( 'starter dump import failed', [
				'starter' => $starterDatabase,
			] );
		}

		$took = microtime( true ) - $then;

		return TaskResult::createForSuccess( [
			'starter' => $starterDatabase,
			'took' => $took
		] );
	}

	/**
	 * Get the stream with starter dump
	 *
	 * @param string $path remote path to a dump from
	 * @return resource the stream with a dump
	 * @throws \CreateWikiException
	 */
	private function getDump( $path ) {
		global $wgWikiaEnvironment, $wgGcsConfig;

		$bucketName = self::BUCKET_NAME_PROD;

		if ( $wgWikiaEnvironment == 'dev' ) {
			$bucketName = self::BUCKET_NAME_DEV;
		}

		$storage = new StorageClient( [ 'keyFile' => $wgGcsConfig['gcsCredentials'] ] );
		$bucket = $storage->bucket( $bucketName );
		$gcsPath = sprintf( 'app/%s', $path );
		$object = $bucket->object( $gcsPath );

		if ( is_null( $object ) ) {
			throw new Exception( "Unable to fetch a dump from {$gcsPath}", self::ERR_OPEN_STARTER_DUMP_FAILED );
		}

		$stream = $object->downloadAsStream();
		$stream = StreamWrapper::getResource( $stream );

		if ( !is_resource( $stream ) ) {
			throw new \CreateWikiException( "Unable to create a memory stream for starter database dump", self::ERR_OPEN_STARTER_DUMP_FAILED );
		}

		$stats = fstat( $stream );

		$this->info( __METHOD__, [
			'path' => $path,
			'size' => $stats['size'],
		] );

		// prepare the stream to be read from, decompress the XML dump on the fly
		rewind( $stream );
		stream_filter_append( $stream, 'bzip2.decompress', STREAM_FILTER_READ );

		return $stream;
	}

	/**
	 * Import the provided XML dump
	 *
	 * @param resource $contentDumpStream stream with XML dump
	 * @throws \CreateWikiException
	 */
	private function importDump( $contentDumpStream ) {
		$then = microtime( true );

		// first, import the articles content
		$source = new \ImportStreamSource( $contentDumpStream );
		$importer = new \WikiImporter( $source );

		$bulkRevisionImporter = new \BulkRevisionImporter( $this->taskContext );

		// We don't want to invoke tasks (namely run Page::doEditUpdates) on each insert to revision table
		// The links will be updated by a run of refreshLinks.php script in post creation tasks
		$importer->setNoUpdates( true );

		$importer->setShouldCheckPermissions( false );

		$importer->setRevisionCallback( [ $bulkRevisionImporter, 'addRevision' ] );

		$importer->doImport();

		$pagesCnt = $bulkRevisionImporter->doBulkImport();

		if ( $pagesCnt === 0 ) {
			throw new \CreateWikiException( 'No pages were imported', self::ERR_NO_PAGES_IMPORTED );
		}

		$this->info( __METHOD__, [
			'pages' => $pagesCnt,
			'took' => microtime( true ) - $then,
		] );
	}

	/**
	 * Update articles count
	 *
	 * @throws \CreateWikiException
	 */
	private function runUpdates() {
		try {
			$then = microtime(true);

			$counter = new \SiteStatsInit( false );
			$result = $counter->articles();

			$dbw = wfGetDB( DB_MASTER );
			$dbw->insert( 'site_stats', [ 'ss_row_id' => 1, 'ss_good_articles' => $result ], __METHOD__ );

			$this->info(__METHOD__, [
				'took' => microtime(true) - $then
			]);
		} catch( \Exception $ex ) {
			throw new \CreateWikiException('runUpdates failed', self::ERR_RUN_UPDATES_FAILED, $ex);
		}
	}

	/**
	 * Wait until the main page exists on the local slave we're connected to
	 */
	private function waitUntilMainPageExists() {
		$main = wfMessage( 'mainpage' )->inContentLanguage()->useDatabase( false )->text();
		$title = \Title::newFromText( $main );

		$dbr = wfGetDB( DB_SLAVE );

		$helper = new ReplicationWaitHelper( $dbr );
		$helper->setCaller( __METHOD__ );
		$helper->setMaxWaitTimeMillis( static::MAX_REPLICATION_WAIT_MILLIS );

		$helper->waitUntil( function ( \DatabaseBase $dbr ) use ( $title ): bool {
			return $dbr->selectField(
				'page',
				'page_id',
				[ 'page_namespace' => $title->getNamespace(), 'page_title' => $title->getDBkey() ],
				__METHOD__
			);
		} );
	}
}
