<?php

/**
 * Script that prepares XML dumps with the latest revisions of starter wikis
 *
 * Generate XML dumps for all starter wikis and upload them to DFS
 *
 * @see PLATFORM-1305
 *
 * @author Macbre
 * @ingroup Maintenance
 */

putenv('SERVER_ID=80433'); // run in the context of www.wikia.com (where CreateWiki is enabled)

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

class DumpStartersException extends Exception {}

class DumpStarters extends Maintenance {

	const DUMP_MIME_TYPE = 'application/bzip2';

	protected $mDescription = 'This script prepares XML dumps with the latest revisions of starter wikis';

	/**
	 * The following tables will be used to generate a SQL dump of a starter wiki
	 */
	static private $mTablesToDump = [
		'categorylinks',
		'externallinks',
		'langlinks',
		'pagelinks',
		'templatelinks',
	];

	/**
	 * Generate XML dump of a given starter database and writes it to a given file
	 *
	 * @param string $filename file to write the XML dump to
	 * @param string $starter
	 */
	private function generateContentDump($filename, $starter) {
		// export only the current revisions
		$dbr = wfGetDB( DB_SLAVE, [], $starter );
		$exporter = new WikiExporter( $dbr, WikiExporter::CURRENT, WikiExporter::STREAM, WikiExporter::TEXT );

		// write to a stream
		$exporter->setOutputSink( new DumpBzOutput( $filename ) );
		$exporter->openStream();
		$exporter->allPages();
		$exporter->closeStream();
	}

	/**
	 * Generate SQL dump of all tables that keep the links between tables
	 *
	 * This allows us to avoid running heavy maintenance scripts while creating a wiki
	 *
	 * @param string $filename file to write the SQL dump to
	 * @param string $starter
	 * @throws DumpStartersException
	 */
	private function generateSqlDump($filename, $starter) {
		// export only the current revisions
		$dbr = wfGetDB( DB_SLAVE, [], $starter );

		// get the DB host name, user and password to be used by mysqldump
		$info = $dbr->getLBInfo();

		// dump tables data only
		$cmd = sprintf("%s --no-create-info --set-gtid-purged=OFF -h%s -u%s -p%s %s %s",
			"/usr/bin/mysqldump",
			$info[ "host"      ],
			$info[ "user"      ],
			$info[ "password"  ],
			$starter,
			implode( " ", self::$mTablesToDump )
		);

		$dump = wfShellExec( $cmd, $retVal );

		if ($retVal > 0) {
			throw new DumpStartersException("Unable to generate a SQL dump of '{$starter}' (using {$info['host']})");
		}

		// save the compressed SQL dump
		file_put_contents( $filename, bzcompress($dump, 9) );
	}

	/**
	 * Stores the bzip2-compressed XML dump on Ceph
	 *
	 * Will remove the file internally
	 *
	 * @param string $filename file to upload to Ceph
	 * @param string $dest the destination to store the file at
	 * @throws DumpStartersException
	 */
	private function storeDump( $filename, $dest ) {
		$this->output( sprintf(" \n\t[%s / %.2f kB]", $dest, filesize($filename) / 1024 ) );

		$swift = \Wikia\CreateNewWiki\Starters::getStarterDumpStorage();
		$res = $swift->store(
			$filename,
			$dest,
			[],
			self::DUMP_MIME_TYPE
		);

		if ( !$res->isOK() ) {
			throw new DumpStartersException( ' upload failed - ' . json_encode( $res->getErrorsArray() ) );
		}

		// cleanup
		unlink($filename);

		$this->output( ' uploaded' );
	}

	/**
	 * @return string path to a temporary file
	 */
	private function getTempFile() {
		return tempnam( wfTempDir(), 'starter' );
	}

	/**
	 * Generate and upload a starter XML dump and SQL dump of "links" table
	 *
	 * @param string $starter
	 * @throws DumpStartersException
	 */
	private function dumpStarter($starter) {
		$this->output( sprintf("\n%s: preparing a dump of '%s'...", wfTimestamp( TS_DB ), $starter ) );

		// 1. generate content XML dump with only the latest revisions
		$tmpname = $this->getTempFile();
		$this->generateContentDump( $tmpname, $starter );
		$this->storeDump( $tmpname, \Wikia\CreateNewWiki\Starters::getStarterContentDumpPath( $starter ) );

		// 2. generate SQL dump of "links" tables
		$tmpname = $this->getTempFile();
		$this->generateSqlDump( $tmpname, $starter );
		$this->storeDump( $tmpname, \Wikia\CreateNewWiki\Starters::getStarterSqlDumpPath( $starter ) );
	}

	public function execute() {
		$this->output( sprintf("%s: %s - starting...", wfTimestamp( TS_DB ), __CLASS__ ) );

		foreach( Wikia\CreateNewWiki\Starters::getAllStarters() as $starter ) {
			try {
				$this->dumpStarter($starter);
			}
			catch (Exception $ex) {
				Wikia\Logger\WikiaLogger::instance()->error( __METHOD__, [
					'exception' => $ex,
				] );
				$this->output( " \t[err] {$ex->getMessage()}" );
			}
		}

		$this->output( "\n" . wfTimestamp( TS_DB ) .": completed!\n");
	}

}

$maintClass = "DumpStarters";
require_once( RUN_MAINTENANCE_IF_MAIN );
