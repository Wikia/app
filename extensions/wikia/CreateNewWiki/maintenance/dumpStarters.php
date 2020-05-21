<?php
use Google\Cloud\Storage\StorageClient;

/**
 * Script that prepares XML and SQL dumps with the latest revisions and *links tables rows of starter wikis
 *
 * Generate XML and SQL dumps for all starter wikis and upload them to DFS
 *
 * s3cmd -c /etc/s3cmd/sjc_prod.cfg ls s3://starter/dumps/
 *
 * @see PLATFORM-1305
 *
 * @author Macbre
 * @ingroup Maintenance
 */

putenv( 'SERVER_ID=80433' ); // run in the context of www.wikia.com (where CreateWiki is enabled)

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

class DumpStartersException extends Exception {}

class DumpStarters extends Maintenance {

	const DUMP_MIME_TYPE = 'application/bzip2';
	
	const BUCKET_NAME_DEV = 'create-new-wiki-dev';
	const BUCKET_NAME_PROD = 'create-new-wiki';

	protected $mDescription = 'This script prepares XML and SQL dumps of starter wikis';

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
	 * Generate XML dump of a given starter database and write it to a given temporary file
	 *
	 * @param string $filename file to write the XML dump to
	 * @param string $langCode
	 * @param string $starter
	 */
	private function generateContentDump( string $filename, string $langCode, string $starter ) {
		// SUS-458: use a proper content language for a given starter to be able to generate localized namespace names
		// set wgMetaNamespace to properly generate NS_PROJECT namespace names
		$contentLanguageWrapper = new Wikia\Util\GlobalStateWrapper( [
			'wgContLang' => Language::factory( $langCode ),
			'wgMetaNamespace' => MWNamespace::getCanonicalName( NS_PROJECT )
		] );

		$contentLanguageWrapper->wrap( function() use ( $starter, $filename ) {
			// export only the current revisions
			$dbr = wfGetDB( DB_SLAVE, [], $starter );
			$exporter = new WikiExporter( $dbr, WikiExporter::CURRENT, WikiExporter::STREAM, WikiExporter::TEXT );

			// write to a stream
			$sink = new DumpBzOutput( $filename );
			$exporter->setOutputSink( $sink );
			$exporter->openStream();
			$exporter->allPages();
			$exporter->closeStream();
		} );
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
	private function generateSqlDump( $filename, $starter ) {
		// export only the current revisions
		$dbr = wfGetDB( DB_SLAVE, [], $starter );

		// get the DB host name, user and password to be used by mysqldump
		$info = $dbr->getLBInfo();

		// dump tables data only
		$cmd = sprintf( "%s --no-create-info -h%s -u%s -p%s %s %s",
			"/usr/bin/mysqldump",
			$info[ "host"      ],
			$info[ "user"      ],
			$info[ "password"  ],
			$starter,
			implode( " ", self::$mTablesToDump )
		);

		$dump = wfShellExec( $cmd, $retVal );

		// SUS-5500 | clean up the dump
		$dump = str_replace( "\nSET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;", '', $dump );
		$dump = str_replace( "\nSET @@SESSION.SQL_LOG_BIN= 0;", '', $dump );
		$dump = str_replace( "\nSET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;", '', $dump );

		// SET @@GLOBAL.GTID_PURGED='018e4e66-f918-11e6-8a27-00163ed20501:1-1713138, ...;
		$dump = preg_replace( '#SET @@GLOBAL.GTID_PURGED=[^;]+;#', '', $dump );

		if ( $retVal > 0 ) {
			throw new DumpStartersException( "Unable to generate a SQL dump of '{$starter}' (using {$info['host']})" );
		}

		// save the compressed SQL dump
		file_put_contents( $filename, bzcompress( $dump, 9 ) );
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
		global $wgWikiaEnvironment, $wgGcsConfig;

		$bucketName = self::BUCKET_NAME_PROD;

		if ( $wgWikiaEnvironment == 'dev' ) {
			$bucketName = self::BUCKET_NAME_DEV;
		}

		$this->output( sprintf( " \n\t[%s / %.2f kB]", $dest, filesize( $filename ) / 1024 ) );

		$storage = new StorageClient( [ 'keyFile' => $wgGcsConfig['gcsCredentials'] ] );
		$content = fopen( $filename, 'r' );
		$bucket = $storage->bucket( $bucketName );
		$gcsPath = sprintf( 'app/%s', $dest );
		$object = $bucket->upload( $content, [ 'name' => $gcsPath ] );

		if ( is_null( $object ) ) {
			throw new Exception( "Unable to store a dump for {$dest}" );
		}

		if ( is_resource( $content ) ) {
			fclose( $content );
		}

		// cleanup
		unlink( $filename );

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
	 * @param string $langCode language code of a given starter
	 * @param string $starter database name of a given starter
	 * @throws DumpStartersException
	 */
	private function dumpStarter( string $langCode, string $starter ) {
		$this->output( sprintf( "\n%s: preparing a dump of '%s' (%s)...", wfTimestamp( TS_DB ), $starter, $langCode ) );

		// 1. generate content XML dump with only the latest revisions
		$tmpname = $this->getTempFile();
		$this->generateContentDump( $tmpname, $langCode, $starter );
		$this->storeDump( $tmpname, \Wikia\CreateNewWiki\Starters::getStarterContentDumpPath( $starter ) );

		// 2. generate SQL dump of "links" tables
		$tmpname = $this->getTempFile();
		$this->generateSqlDump( $tmpname, $starter );
		$this->storeDump( $tmpname, \Wikia\CreateNewWiki\Starters::getStarterSqlDumpPath( $starter ) );
	}

	public function execute() {
		$this->output( sprintf( "%s: %s - starting...", wfTimestamp( TS_DB ), __CLASS__ ) );

		foreach ( Wikia\CreateNewWiki\Starters::getAllStarters() as $langCode => $starter ) {
			if ( $langCode === '*' ) {
				$langCode = 'en';
			}

			try {
				$this->dumpStarter( $langCode, $starter );
			}
			catch ( Exception $ex ) {
				Wikia\Logger\WikiaLogger::instance()->error( __METHOD__, [
					'exception' => $ex,
				] );
				$this->output( " \t[err] {$ex->getMessage()}" );
			}
		}

		$this->output( "\n" . wfTimestamp( TS_DB ) . ": completed!\n" );
	}

}

$maintClass = "DumpStarters";
require_once( RUN_MAINTENANCE_IF_MAIN );
