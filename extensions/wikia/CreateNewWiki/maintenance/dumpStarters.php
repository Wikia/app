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

	protected $mDescription = 'This script prepares XML dumps with the latest revisions of starter wikis';

	/**
	 * Generate and upload a starter XML dump
	 *
	 * @param string $starter
	 * @throws DumpStartersException
	 */
	private function dumpStarter($starter) {
		$this->output( "Preparing a dump of '{$starter}'..." );

		// 1. generate the dump
		$db = wfGetDB( DB_SLAVE, [], $starter );
		$fp = tmpfile();

		// export only the current revisions
		$exporter = new WikiExporter( $db, WikiExporter::CURRENT, WikiExporter::STREAM, WikiExporter::TEXT );

		// write to a stream
		$exporter->setOutputSink( new DumpStreamOutput( $fp ) );
		$exporter->openStream();
		$exporter->allPages();
		$exporter->closeStream();

		rewind( $fp );
		$dumpSize = fstat( $fp )[ 'size' ];

		if ( empty( $dumpSize ) ) {
			throw new DumpStartersException( 'XML dump is empty' );
		}

		// 2. store it on Ceph
		$swift = \Wikia\SwiftStorage::newFromContainer( \Wikia\CreateNewWiki\Starters::STARTER_DUMPS_BUCKET );
		$res = $swift->store(
			$fp,
			\Wikia\CreateNewWiki\Starters::getStarterDumpPath( $starter ),
			[
				'Last-Modified' => date( 'r' ),
			],
			'text/xml'
		);

		if ( !$res->isOK() ) {
			throw new DumpStartersException( 'XML dump upload failed - ' . json_encode( $res->getErrorsArray() ) );
		}

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
