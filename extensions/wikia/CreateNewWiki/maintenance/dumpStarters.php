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
	 * Generate XML dump of a given starter database and writes it to a given file
	 *
	 * The file will be bzip2 compressed
	 *
	 * @param string $filename file to write the XML dump to
	 * @param string $starter
	 */
	private function generateContentDump($filename, $starter) {
		// export only the current revisions
		$db = wfGetDB( DB_SLAVE, [], $starter );
		$exporter = new WikiExporter( $db, WikiExporter::CURRENT, WikiExporter::STREAM, WikiExporter::TEXT );

		// write to a stream
		$exporter->setOutputSink( new DumpBZip2Output( $filename ) );
		$exporter->openStream();
		$exporter->allPages();
		$exporter->closeStream();
	}

	/**
	 * Stores the bzip2-compressed XML dump on Ceph
	 *
	 * @param string $filename file to upload to Ceph
	 * @param string $dest the destination to store the file at
	 * @throws DumpStartersException
	 */
	private function storeDump( $filename, $dest ) {
		$swift = \Wikia\CreateNewWiki\Starters::getStarterDumpStorage();
		$res = $swift->store(
			$filename,
			$dest,
			[],
			self::DUMP_MIME_TYPE
		);

		if ( !$res->isOK() ) {
			throw new DumpStartersException( 'XML dump upload failed - ' . json_encode( $res->getErrorsArray() ) );
		}
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

		// generate content XML dump with only the latest revisions
		$tmpname = $this->getTempFile();
		$this->generateContentDump( $tmpname, $starter );
		$this->storeDump( $tmpname, \Wikia\CreateNewWiki\Starters::getStarterContentDumpPath( $starter ) );

		// cleanup
		$dumpSize = filesize($tmpname);
		unlink($tmpname);

		$this->output( sprintf(" \t[content] %.2f kB", $dumpSize / 1024 ) );
	}

	public function execute() {
		$this->output( sprintf("%s: %s - starting...", wfTimestamp( TS_DB ), __CLASS__ ) );

		foreach( Wikia\CreateNewWiki\Starters::getAllStarters() as $starter ) {
			try {
				$this->dumpStarter($starter);
			}
			catch (Exception $ex) {
				$this->output( " \t[err] {$ex->getMessage()}" );
			}
		}

		$this->output( "\n" . wfTimestamp( TS_DB ) .": completed!\n");
	}

}

$maintClass = "DumpStarters";
require_once( RUN_MAINTENANCE_IF_MAIN );
