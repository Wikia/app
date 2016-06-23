<?php

/**
 * This script imports a starter XML dump into a newly created wiki
 *
 * Performs all required statistics updates as well
 *
 * @see PLATFORM-1305
 *
 * @author Macbre
 * @ingroup Maintenance
 */

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

class ImportStarter extends Maintenance {

	protected $mDescription = 'This script imports a starter XML dump into a newly created wiki';

	/* @var Wikia\Logger\WikiaLogger $logger */
	protected $logger;

	const ERR_OPEN_STARTER_DUMP_FAILED = 1;
	const ERR_NO_PAGES_IMPORTED = 2;
	const ERR_SQL_IMPORT_FAILED = 3;
	const ERR_RUN_UPDATES_FAILED = 4;

	/**
	 * Get the stream with starter dump
	 *
	 * @param string $path remote path to a dump from
	 * @return resource the stream with a dump
	 * @throws CreateWikiException
	 */
	private function getDump( $path ) {
		$stream = fopen( "php://memory", "wb" );

		if (!is_resource($stream)) {
			throw new CreateWikiException("Unable to create a memory stream for starter database dump", self::ERR_OPEN_STARTER_DUMP_FAILED);
		}

		$swift = \Wikia\CreateNewWiki\Starters::getStarterDumpStorage();
		$res = $swift->read( $path, $stream );

		if (is_null($res)) {
			throw new CreateWikiException("Unable to fetch a dump from {$path}", self::ERR_OPEN_STARTER_DUMP_FAILED);
		}

		$stats = fstat($stream);
		$this->output( sprintf("Fetched XML dump from '%s' (%.2f kB)\n", $path, $stats['size'] / 1024) );

		$this->logger->info( __METHOD__, [
			'path'       => $path,
			'size'       => $stats['size']
		] );

		// prepare the stream to be read from, decompress the XML dump on the fly
		rewind($stream);
		stream_filter_append( $stream, 'bzip2.decompress', STREAM_FILTER_READ );

		return $stream;
	}

	/**
	 * Import the provided XML dump
	 *
	 * @param resource $contentDumpStream stream with XML dump
	 * @param resource $sqlDumpStream stream with SQL tables dump
	 */
	private function importDump($contentDumpStream, $sqlDumpStream) {
		$pagesCnt = 0;
		$then = microtime(true);

		// WikiImporter uses methods which in turn use slaves
		wfWaitForSlaves();

		// perform the import in a transaction
		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin( __METHOD__ );

		// first, import the articles content
		$source = new ImportStreamSource( $contentDumpStream );
		$importer = new WikiImporter( $source );

		/**
		 * We don't want to invoke tasks (namely run Page::doEditUpdates) on each insert to revision table
		 *
		 * The links will be updated thanks to a SQL dump of links tables
		 */
		$importer->setNoUpdates(true);

		$importer->setRevisionCallback(function(WikiRevision $rev) use (&$pagesCnt) {
			$rev->importOldRevision();

			#$this->output(sprintf("Importing '%s'...\n", $rev->getTitle()->getPrefixedDBkey()));
			$pagesCnt++;
		});

		$this->output("\n\nImporting a XML content dump...\n");
		$importer->doImport();

		$this->output( sprintf("Imported %d pages\n", $pagesCnt) );
		if ($pagesCnt === 0) {
			$dbw->rollback(__METHOD__);
			throw new CreateWikiException('No pages were imported', self::ERR_NO_PAGES_IMPORTED);
		}

		// now, import the SQL tables with article links
		try {
			$this->output("\n\nImporting a SQL tables dump...\n");
			$ret = $dbw->sourceStream($sqlDumpStream, false, false, __METHOD__);
		}
		catch(DBError $ex) {
			$ret = $ex->getMessage();
		}

		if ($ret !== true) {
			$dbw->rollback(__METHOD__);
			throw new CreateWikiException('SQL import failed: ' . $ret, self::ERR_SQL_IMPORT_FAILED);
		}

		// ok, we're done
		$dbw->commit(__METHOD__);

		$this->logger->info(__METHOD__, [
			'pages' => $pagesCnt,
			'took' => microtime(true) - $then
		]);
	}

	/**
	 * Update articles count
	 *
	 * @throws CreateWikiException
	 */
	private function runUpdates() {
		global $IP;
		require_once( $IP . '/maintenance/updateArticleCount.php' );

		try {
			$then = microtime(true);

			// php updateArticleCount.php --update
			$updateArticlesCount = new UpdateArticleCount();
			$updateArticlesCount->loadParamsAndArgs(null, ['update' => true]);
			$updateArticlesCount->execute();

			$this->logger->info(__METHOD__, [
				'took' => microtime(true) - $then
			]);
		}
		catch(Exception $ex) {
			throw new CreateWikiException('runUpdates failed', self::ERR_RUN_UPDATES_FAILED, $ex);
		}
	}

	public function execute() {
		/* @var Language $wgContLang */
		global $wgContLang, $wgCityId, $wgDBname;
		$language = $wgContLang->getCode();
		$starter = Wikia\CreateNewWiki\Starters::getStarterByLanguage( $language );

		// set up the logger to work similar to the one in CreateWiki class
		$this->logger = Wikia\Logger\WikiaLogger::instance();
		$this->logger->pushContext([
			'cityid'   => $wgCityId,
			'dbname'   => $wgDBname,
			'logGroup' => 'createwiki',
		]);

		try {
			$this->output("Getting starter dump for '{$language}' language ('{$starter}' database)...\n");

			$contentDumpStream = $this->getDump(\Wikia\CreateNewWiki\Starters::getStarterContentDumpPath( $starter ));
			$sqlDumpStream = $this->getDump(\Wikia\CreateNewWiki\Starters::getStarterSqlDumpPath( $starter ));

			$this->importDump($contentDumpStream, $sqlDumpStream);

			fclose($contentDumpStream);
			fclose($sqlDumpStream);

			$this->runUpdates();
		}
		catch( CreateWikiException $ex ) {
			$this->error( 'Error: ' . $ex->getMessage(), $ex->getCode() );
		}

		$this->output( "\n\nDone\n" );
	}
}

$maintClass = "ImportStarter";
require_once( RUN_MAINTENANCE_IF_MAIN );
