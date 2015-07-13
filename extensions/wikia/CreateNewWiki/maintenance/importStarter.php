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
	const ERR_RUN_UPDATE_FAILED = 3;

	/**
	 * Get the stream with starter XML dump
	 *
	 * @param string $language the language to get the starter for
	 * @return resource the stream with XML dump
	 * @throws CreateWikiException
	 */
	private function getStarterDump( $language ) {
		$stream = fopen( "php://memory", "wb" );

		if (!is_resource($stream)) {
			throw new CreateWikiException("Unable to create a memory stream for starter database dump", self::ERR_OPEN_STARTER_DUMP_FAILED);
		}

		$starter = Wikia\CreateNewWiki\Starters::getStarterByLanguage( $language );

		$swift = \Wikia\CreateNewWiki\Starters::getStarterDumpStorage();
		$res = $swift->read( \Wikia\CreateNewWiki\Starters::getStarterDumpPath( $starter ),  $stream );

		if (is_null($res)) {
			throw new CreateWikiException("Unable to open a starter database dump for {$language} language", self::ERR_OPEN_STARTER_DUMP_FAILED);
		}

		$stats = fstat($stream);
		$this->output( sprintf("Fetched XML dump of '%s' (%.2f kB)\n", $starter, $stats['size'] / 1024) );

		$this->logger->info( __METHOD__, [
			'language'   => $language,
			'starter_db' => $starter,
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
	 * @param resource $stream stream with XML dump
	 */
	private function importDump($stream) {
		$pagesCnt = 0;
		$then = microtime(true);

		$source = new ImportStreamSource( $stream );
		$importer = new WikiImporter( $source );

		/**
		 * We don't want to invoke tasks (namely run Page::doEditUpdates) on each insert to revision table
		 *
		 * Let's do it once when the import is completed
		 */
		$importer->setNoUpdates(true);

		$importer->setRevisionCallback(function(WikiRevision $rev) use (&$pagesCnt) {
			$rev->importOldRevision();

			$this->output(sprintf("Importing '%s'...\n", $rev->getTitle()->getPrefixedDBkey()));
			$pagesCnt++;
		});

		$dbw = wfGetDB( DB_MASTER );

		$dbw->begin( __METHOD__ );
		$importer->doImport();
		$dbw->commit(__METHOD__);

		$this->output( sprintf("Imported %d pages\n", $pagesCnt) );

		if ($pagesCnt === 0) {
			throw new CreateWikiException('No pages were imported', self::ERR_NO_PAGES_IMPORTED);
		}

		$this->logger->info(__METHOD__, [
			'pages' => $pagesCnt,
			'took' => microtime(true) - $then
		]);
	}

	/**
	 * Update statistics (articles count) and links
	 *
	 * @throws CreateWikiException
	 */
	private function runUpdates() {
		global $IP;
		require_once( $IP . '/maintenance/updateArticleCount.php' );
		require_once( $IP . '/maintenance/refreshLinks.php' );

		try {
			$then = microtime(true);

			// php updateArticleCount.php --update
			$updateArticlesCount = new UpdateArticleCount();
			$updateArticlesCount->loadParamsAndArgs(null, ['update' => true]);
			$updateArticlesCount->execute();

			// php refreshLinks.php
			$refreshLinks = new RefreshLinks();
			$refreshLinks->execute();

			$this->logger->info(__METHOD__, [
				'took' => microtime(true) - $then
			]);
		}
		catch(Exception $ex) {
			throw new CreateWikiException('runUpdate failed', self::ERR_RUN_UPDATE_FAILED, $ex);
		}
	}

	public function execute() {
		/* @var Language $wgContLang */
		global $wgContLang, $wgCityId, $wgDBname;
		$language = $wgContLang->getCode();

		// set up the logger to work similar to the one in CreateWiki class
		$this->logger = Wikia\Logger\WikiaLogger::instance();
		$this->logger->pushContext([
			'cityid'   => $wgCityId,
			'dbname'   => $wgDBname,
			'logGroup' => 'createwiki',
		]);

		try {
			$this->output("Getting starter database for '{$language}' language...\n");
			$stream = $this->getStarterDump($language);

			$this->output("\n\nImporting a dump...\n");
			$this->importDump($stream);

			fclose($stream);

			$this->output("\n\nRunning post-import updates...\n");
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
