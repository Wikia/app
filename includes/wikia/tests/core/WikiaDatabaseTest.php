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
	use TestCaseTrait {
		setUp as protected databaseSetUp;
		tearDown as protected databaseTearDown;
	}

	const GLOBAL_DB_VARS = [ 'wgExternalSharedDB', 'wgSpecialsDB' ];

	/** @var InMemorySqliteDatabase $db */
	private static $db = null;
	/** @var Connection $conn */
	private $conn = null;

	private $globalVariableValues = [];

	/**
	 * Initializes the in-memory database with the specified schema files,
	 * and sets MediaWiki up to direct all DB calls to the in-memory DB
	 */
	public static function setUpBeforeClass() {
		parent::setUpBeforeClass();
		self::$db = new InMemorySqliteDatabase();

		LBFactory::destroyInstance();
		LBFactory::setInstance( new LBFactory_Single( [
			'connection' => self::$db
		] ) );

		// init core MW schema
		$schemaFile = self::$db->getSchemaPath();
		static::loadSchemaFile( $schemaFile );

		// SUS-3071: add shared db tables
		global $IP;
		static::loadSchemaFile( "$IP/tests/fixtures/user.sql" );
		static::loadSchemaFile( "$IP/tests/fixtures/user_properties.sql" );
	}

	protected function setUp() {
		// override external databases to use the in-memory DB
		foreach ( static::GLOBAL_DB_VARS as $globalName ) {
			$this->globalVariableValues[$globalName] = $GLOBALS[$globalName];
			$GLOBALS[$globalName] = false;
		}

		// schema is ready, let DbUnit populate the DB with fixtures
		$this->databaseSetUp();
	}

	/**
	 * Acquire a connection to the in-memory database that DbUnit can use
	 * This is the same connection set up for MediaWiki
	 * @see WikiaDatabaseTest::setUpBeforeClass()
	 * @return Connection
	 */
	final protected function getConnection() {
		if ( !( $this->conn instanceof Connection ) ) {
			if ( !( self::$db instanceof InMemorySqliteDatabase ) ) {
				self::$db = wfGetDB( DB_MASTER );
			}

			$this->conn = $this->createDefaultDBConnection( self::$db->getConnection(), ':memory:' );
		}

		return $this->conn;
	}

	protected function tearDown() {
		foreach ( static::GLOBAL_DB_VARS as $globalName ) {
			 $GLOBALS[$globalName] = $this->globalVariableValues[$globalName];
		}

		$this->databaseTearDown();
	}

	/**
	 * Destroy the load balancer set up for the in-memory DB to not affect other tests
	 */
	public static function tearDownAfterClass() {
		parent::tearDownAfterClass();
		LBFactory::destroyInstance();
	}

	protected function createYamlDataSet( string $fileName ): IDataSet {
		return new YamlDataSet( $fileName );
	}

	protected static function loadSchemaFile( string $schemaFile ) {
		self::$db->sourceFile( $schemaFile );
	}
}
