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
	/** @var InMemorySqliteDatabase $db */
	private static $db = null;
	/** @var Connection $conn */
	private $conn = null;

	/**
	 * Initializes the in-memory database with the specified schema files,
	 * and sets MediaWiki up to direct all DB calls to the in-memory DB
	 */
	public static function setUpBeforeClass() {
		parent::setUpBeforeClass();
		self::$pdo = new PDO('sqlite::memory:' );
		self::$db = new InMemorySqliteDatabase( self::$pdo );

		// init core MW schema
		$schemaFile = self::$db->getSchemaPath();
		static::loadSchemaFile( $schemaFile );

		// SUS-3071: add shared db tables
		global $IP;
		static::loadSchemaFile( "$IP/tests/fixtures/user.sql" );
		static::loadSchemaFile( "$IP/tests/fixtures/user_properties.sql" );
		static::loadSchemaFile( "$IP/tests/fixtures/dataware.sql" );
		static::loadSchemaFile( "$IP/tests/fixtures/specials.sql" );
		static::loadSchemaFile( "$IP/tests/fixtures/wikicities.sql" );

		// destroy leaked user accounts from other tests
		User::$idCacheByName = [];
		\Wikia\Factory\ServiceFactory::clearState();
	}

	protected function setUp() {
		// override external databases to use the in-memory DB
		foreach ( static::GLOBAL_DB_VARS as $globalName ) {
			$this->mockGlobalVariable( $globalName, false );
		}

		// disable memcache and tasks queue
		$this->mockGlobalVariable( 'wgMemc', new EmptyBagOStuff() );
		$this->mockGlobalVariable( 'wgTaskBroker', false ); // @see PLATFORM-1740

		foreach ( $this->extraSchemaFiles() as $schemaFile ) {
			static::loadSchemaFile( $schemaFile );
		}

		// override MW load balancer before each test
		LBFactory::setInstance( new LBFactory_Single( [
			'connection' => new InMemorySqliteDatabase( self::$pdo )
		] ) );

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
			$this->conn = $this->createDefaultDBConnection( self::$pdo, ':memory:' );
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

	protected static function loadSchemaFile( string $schemaFile ) {
		self::$db->sourceFile( $schemaFile );
	}

	public function __sleep() {
		$this->conn = null;
		return [];
	}
}
