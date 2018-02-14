<?php
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\DataSet\IDataSet;
use PHPUnit\DbUnit\DataSet\YamlDataSet;
use PHPUnit\DbUnit\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;

/**
 * Class WikiaDatabaseTest serves as an abstract base class for database integration tests
 */
abstract class WikiaDatabaseTest extends TestCase {
	use MockGlobalVariableTrait;
	use TestCaseTrait {
		setUp as protected databaseSetUp;
		tearDown as protected databaseTearDown;
	}

	const GLOBAL_DB_VARS = [ 'wgExternalSharedDB', 'wgSpecialsDB', 'wgDefaultExternalStore' ];

	/** @var PDO $pdo */
	private static $pdo = null;
	/** @var Connection $conn */
	private $conn = null;

	/**
	 * Initializes the in-memory database with the specified schema files,
	 * and sets MediaWiki up to direct all DB calls to the in-memory DB
	 */
	public static function setUpBeforeClass() {
		parent::setUpBeforeClass();

		// destroy leaked user accounts from other tests
		User::$idCacheByName = [];
	}

	protected function setUp() {
		// override external databases to use the in-memory DB
		foreach ( static::GLOBAL_DB_VARS as $globalName ) {
			$this->mockGlobalVariable( $globalName, false );
		}

		$this->mockGlobalVariable( 'wgMemc', new EmptyBagOStuff() );

		$dbw = wfGetDB( DB_MASTER );

		foreach ( $this->extraSchemaFiles() as $schemaFile ) {
			$dbw->sourceFile( $schemaFile );
		}

		// schema is ready, let DbUnit populate the DB with fixtures
		$this->databaseSetUp();
	}

	/**
	 * Override this in the test class to load extra schema files
	 */
	protected function extraSchemaFiles() {
		return [];
	}

	final protected function getConnection() {
		if ( !( $this->conn instanceof Connection ) ) {
			global $wgDBname;

			if ( !( static::$pdo instanceof PDO ) ) {
				global $wgDBserver, $wgDBuser, $wgDBpassword;
				static::$pdo = new PDO( "mysql:dbname=$wgDBname;host=$wgDBserver", $wgDBuser, $wgDBpassword );
			}

			$this->conn = $this->createDefaultDBConnection( static::$pdo, $wgDBname );
		}

		return $this->conn;
	}

	protected function tearDown() {
		$this->unsetGlobals();
		$this->databaseTearDown();
	}

	/**
	 * Destroy the load balancer set up for the in-memory DB to not affect other tests
	 */
	public static function tearDownAfterClass() {
		parent::tearDownAfterClass();
		LBFactory::destroyInstance();

		// do not leak cached test user accounts to other tests
		User::$idCacheByName = [];
	}

	protected function createYamlDataSet( string $fileName ): IDataSet {
		return new YamlDataSet( $fileName );
	}
}
