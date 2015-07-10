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
	 * Generate XML dump of a given starter database and writes it to a given stream
	 *
	 * @param resource $fp stream to write XML dump to
	 * @param string $starter
	 */
	private function generateDump($fp, $starter) {
		// 1. generate the dump
		// export only the current revisions
		$db = wfGetDB( DB_SLAVE, [], $starter );
		$exporter = new WikiExporter( $db, WikiExporter::CURRENT, WikiExporter::STREAM, WikiExporter::TEXT );

		// write to a stream
		$exporter->setOutputSink( new DumpStreamOutput( $fp ) );
		$exporter->openStream();
		$exporter->allPages();
		$exporter->closeStream();

		fclose( $fp );
	}

	/**
	 * Stores the bzip2-compressed XML dump on Ceph
	 *
	 * @param resource $fp stream to use to get the data to be stored
	 * @param string $starter
	 * @return Status
	 */
	private function storeDump( $fp, $starter ) {
		$swift = \Wikia\SwiftStorage::newFromContainer( \Wikia\CreateNewWiki\Starters::STARTER_DUMPS_BUCKET );
		$res = $swift->store(
			$fp,
			\Wikia\CreateNewWiki\Starters::getStarterDumpPath( $starter ),
			[
				'Last-Modified' => date( 'r' ),
			],
			self::DUMP_MIME_TYPE
		);

		return $res;
	}

	/**
	 * Generate and upload a starter XML dump
	 *
	 * @param string $starter
	 * @throws DumpStartersException
	 */
	private function dumpStarter($starter) {
		$this->output( "Preparing a dump of '{$starter}'..." );

		// 0. set up the XML dump file
		$tmpname = tempnam( wfTempDir(), 'starter' );
		$fp = fopen( $tmpname, 'w' );

		if ( !is_resource( $fp ) ) {
			throw new DumpStartersException( 'Cannot create a temporary file' );
		}

		// compress the XML dump on the fly
		stream_filter_append( $fp, 'bzip2.compress', STREAM_FILTER_WRITE );

		// 1. generate the dump
		// export only the current revisions
		$this->generateDump( $fp, $starter );

		// check if the file is not empty
		$dumpSize = filesize($tmpname);
		if ( empty( $dumpSize ) ) {
			throw new DumpStartersException( 'XML dump is empty' );
		}

		// 2. store it on Ceph
		$fp = fopen($tmpname, 'r' );
		$res = $this->storeDump( $fp, $starter );

		if ( !$res->isOK() ) {
			throw new DumpStartersException( 'XML dump upload failed - ' . json_encode( $res->getErrorsArray() ) );
		}

		// cleanup
		unlink($tmpname);

		$this->output( sprintf(" \t[done] %.2f kB\n", $dumpSize / 1024 ) );
	}

	public function execute() {
		foreach( Wikia\CreateNewWiki\Starters::getAllStarters() as $starter ) {
			try {
				$this->dumpStarter($starter);
			}
			catch (Exception $ex) {
				$this->output( " \t[err] {$ex->getMessage()}\n" );
			}
		}

		$this->output("Completed!\n");
	}

}

$maintClass = "DumpStarters";
require_once( RUN_MAINTENANCE_IF_MAIN );
