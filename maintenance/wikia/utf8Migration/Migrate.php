<?php

require_once( dirname( __FILE__ ) . '../../../Maintenance.php' );

class Migrate extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->addOption( 'files-path', 'Path for storing migration files', false, true, 'f' );
		$this->addOption( 'dumper-path', 'Path for mydumper', false, true, 'd' );
		$this->addOption( 'restore', 'Restore backup only', false );
	}

	public function execute() {
		global $wgDBadminuser, $wgDBadminpassword;
		$errors = [];

		$db = wfGetDB( DB_MASTER );
		$dbname = $db->getDBname();
		$dbOptions = [
			$db->getServer(),
			$this->getOption( 'dbuser', $wgDBadminuser ),
			$this->getOption( 'dbpass', $wgDBadminpassword ),
			$dbname
		];

		$dumperPath = $this->getOption( 'dumper-path', '' );
		$migrationPath = $this->getOption( 'files-path', "/tmp/{$dbname}" );
		$backupPath = "{$migrationPath}/backup";

		$restoreOnly = $this->getOption( 'restore', false );

		if ( !$restoreOnly ) {
			$backupErrors = $this->backup( $backupPath, $dumperPath, $db, $dbOptions );
			$errors = array_merge( $errors, $backupErrors );
			if ( empty( $backupErrors ) ) {
				$migrationErrors = $this->migrate( $migrationPath, $dbOptions );
				$errors = array_merge( $errors, $migrationErrors );
			}
		}

		if ( $restoreOnly || !empty( $migrationErrors ) ) {
			$restoreErrors = $this->restore( $backupPath, $dumperPath, $dbOptions );
			$errors = array_merge( $errors, $restoreErrors );
		}

		if ( !empty( $errors ) ) {
			\Wikia\Logger\WikiaLogger::instance()->error( 'Migration failed', $errors );
			throw new Exception( 'Failed with errors: ' . implode( ",", $errors ) );
		}
		if ( !$restoreOnly ) {
			$this->cleanup( $dbname, $migrationPath, $backupPath );
		}
		$this->output( "...done\n" );
	}

	protected function backup( $backupPath, $dumperPath, $db, $options ) {
		list( $host, $user, $password, $dbname ) = $options;
		$dbEncodingBackupFile = "{$backupPath}/_db.{$dbname}.sql";
		$errors = [];

		$this->output( "...creating a backup for {$dbname} in {$backupPath}\n" );
		$backupOutput = $this->createBackup( $host, $user, $password, $dbname, $backupPath, $dumperPath );
		if ( !empty( $backupOutput ) ) {
			$this->output( "...{$backupOutput}\n" );
			$errors[] = $backupOutput;
		}

		$defaults = $this->getEncodings( $db, $dbname );
		$encodingBackupOutput = $this->createDBEncodingBackup( $dbEncodingBackupFile, $dbname, $defaults );
		if ( $encodingBackupOutput && $encodingBackupOutput === false ) {
			$this->output( "...database encoding backup failed\n" );
			$errors[] = "Database encoding backup file creation failed";
		}

		return $errors;
	}

	protected function migrate( $backupPath, $options ) {
		list( $host, $user, $password, $dbname ) = $options;
		$convertionScriptPath = "{$backupPath}/_convert.{$dbname}.sql";
		$errors = [];

		$this->output( "...migration starting\n" );
		$migrationFileOutput = $this->createMigrationFile( $dbname, $convertionScriptPath );
		if ( !empty( $migrationFileOutput ) ) {
			$this->output( "...ERROR! migration file creation failed\n" );
			$errors[] = $migrationFileOutput;
		}

		$output = $this->runMigration( $host, $user, $password, $dbname, $convertionScriptPath );
		if ( !empty( $output ) && strpos( $output, 'Warning' ) !== 0 ) {
			$this->output( "...ERROR! migration failed\n" );
			$errors[] = $output;
		}

		return $errors;
	}

	protected function restore( $backupPath, $dumperPath, $options ) {
		list( $host, $user, $password, $dbname ) = $options;
		$errors = [];

		$this->output( "...restoring backup to {$dbname}\n" );
		$restoreOutput = $this->restoreBackup( $host, $user, $password, $dbname, $backupPath, $dumperPath );
		if ( !empty( $restoreOutput ) ) {
			$this->output( "...{$restoreOutput}\n" );
			$errors[] = "{$dbname} data restoration failed!";
			$errors[] = $restoreOutput;
			$this->output( '...ERROR! database restore failed!' );
		}
		if ( empty( $errors ) ) {
			$this->output( "...backup restored successfully\n" );
		}

		return $errors;
	}

	protected function cleanup( $dbname, $path ) {
		$time = time();
		return exec( "tar -zcf {$path}/{$dbname}.{$time}.tar.gz --directory=\"{$path}\" backup" );
	}

	/** COMMANDS METHODS */
	protected function getEncodings( $db, $dbname ) {
		return $db->query( "SELECT DEFAULT_CHARACTER_SET_NAME AS charset, DEFAULT_COLLATION_NAME as collation FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '{$dbname}'", __METHOD__ )
			->fetchObject();
	}

	protected function createDBEncodingBackup( $filePath, $dbname, $data ) {
		$date = date( "Y-m-d H:i:sT" );
		$contents = <<<SQL
-- backup database encoding for {$dbname} created on {$date}
ALTER DATABASE {$dbname} DEFAULT CHARACTER SET {$data->charset} COLLATE {$data->collation};

SQL;

		return file_put_contents( $filePath, $contents );
	}

	protected function createBackup( $host, $user, $password, $dbname, $backupPath = '.', $dumperPath = '' ) {
		return exec( "{$dumperPath}mydumper -h {$host} -u {$user} -p {$password} -B {$dbname} -o {$backupPath} 2>&1" );
	}

	protected function restoreBackup( $host, $user, $password, $dbname, $backupPath = '.', $dumperPath = '' ) {
		return exec( "{$dumperPath}myloader -h {$host} -u {$user} -p {$password} -B {$dbname} -d {$backupPath} -o 2>&1" );
	}

	protected function createMigrationFile( $dbname, $convertionScriptPath ) {
		$dir = __DIR__;
		return exec( "SERVER_DBNAME={$dbname} php {$dir}/UTF8ConvertionScript.php > {$convertionScriptPath}" );
	}

	protected function runMigration( $host, $user, $password, $dbname, $filePath ) {
		return exec( "mysql -h {$host} -u {$user} -p{$password} -D {$dbname} < {$filePath} 2>&1" );
	}
}

$maintClass = 'Migrate';
require_once( RUN_MAINTENANCE_IF_MAIN );
