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

	/** @var PDO $pdo */
	private static $pdo = null;
	/** @var InMemorySqliteDatabase $db */
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
		\Wikia\Factory\ServiceFactory::clearState();
	}

	protected function setUp() {
		foreach ( $this->extraSchemaFiles() as $schemaFile ) {
			static::loadSchemaFile( $schemaFile );
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

	/**
	 * Acquire a connection to the in-memory database that DbUnit can use
	 * This is the same connection set up for MediaWiki
	 * @see WikiaDatabaseTest::setUpBeforeClass()
	 * @return Connection
	 */
	final protected function getConnection() {
		if ( !( $this->conn instanceof Connection ) ) {
			global $wgDBname;

			if ( !( self::$pdo instanceof PDO ) ) {
				global $wgDBserver, $wgDBuser, $wgDBpassword;
				self::$pdo = new PDO( "mysql:dbname=$wgDBname;host=$wgDBserver;charset=latin1", $wgDBuser, $wgDBpassword );
			}

			$this->conn = $this->createDefaultDBConnection( self::$pdo, $wgDBname );
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

		WikiFactory::clearVariablesCache();
	}

	protected function createYamlDataSet( string $fileName ): IDataSet {
		return new YamlDataSet( $fileName );
	}

	protected static function loadSchemaFile( string $schemaFile ) {
		wfGetDB( DB_MASTER )->sourceFile( $schemaFile );
	}

	public function __sleep() {
		$this->conn = null;
		return [];
	}
}
