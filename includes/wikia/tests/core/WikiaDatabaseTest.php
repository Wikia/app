<?php
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\TestCaseTrait;

/**
 * Class WikiaDatabaseTest serves as an abstract base class for database integration tests
 */
abstract class WikiaDatabaseTest extends WikiaBaseTest {
	use TestCaseTrait;

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
		self::$db = new InMemorySqliteDatabase();

		LBFactory::destroyInstance();
		LBFactory::setInstance( new LBFactory_Single( [
			'connection' => self::$db
		] ) );

		foreach ( static::getSchemaFiles() as $schemaFile ) {
			self::$db->sourceFile( $schemaFile );
		}

		self::$db->commit();
	}

	/**
	 * Returns the list of schema files which will be used to initialize the in-memory database
	 * @return string[]
	 */
	protected static function getSchemaFiles() {
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
			if ( !( self::$db instanceof InMemorySqliteDatabase ) ) {
				self::$db = wfGetDB( DB_MASTER );
			}

			$this->conn = $this->createDefaultDBConnection( self::$db->getConnection(), ':memory:' );
		}

		return $this->conn;
	}

	/**
	 * Destroy the load balancer set up for the in-memory DB to not affect other tests
	 */
	public static function tearDownAfterClass() {
		parent::tearDownAfterClass();
		LBFactory::destroyInstance();
	}
}
