<?php
namespace Wikia\DB;

use PHPUnit\Framework\TestCase;
use \Wikia\DependencyInjection\Injector;

/**
 * @package Wikia\DB
 * @group UsingDB
 */
class DatabaseTest extends TestCase {
	/** @var Injector $injector */
	private $injector;

	protected function setUp() {
		parent::setUp();
		$this->injector = Injector::getInjector();
	}

	public function testInjectedSlaveConnectionIsReused() {
		$dbConn = $this->injector->get( Database::DB_SLAVE );
		$secondDbConn = $this->injector->get( Database::DB_SLAVE );

		$this->assertSame( $dbConn, $secondDbConn );
	}

	public function testInjectedMasterConnectionIsAlwaysFresh() {
		$dbConn = $this->injector->get( Database::DB_MASTER );
		$secondDbConn = $this->injector->get( Database::DB_MASTER );

		$this->assertNotSame( $dbConn, $secondDbConn );
	}

	/**
	 * @dataProvider provideInjectedDatabaseNames
	 *
	 * @param string $injectName
	 * @param string $expectedDbName
	 */
	public function testInjectedDatabaseNameIsCorrect( string $injectName, string $expectedDbName ) {
		/** @var \DatabaseBase $db */
		$db = $this->injector->get( $injectName );

		$this->assertInstanceOf( \DatabaseBase::class, $db );
		$this->assertEquals( $expectedDbName, $db->getDBname() );
	}

	public function provideInjectedDatabaseNames(): array {
		global $wgDBname, $wgExternalSharedDB, $wgSpecialsDB, $wgStatsDB, $wgExternalDatawareDB;

		return [
			'local slave DB' => [
				Database::DB_SLAVE, $wgDBname
			],
			'local master DB' => [
				Database::DB_MASTER, $wgDBname
			],
			'external shared slave DB' => [
				ExternalSharedDatabase::DB_SLAVE, $wgExternalSharedDB
			],
			'external shared master DB' => [
				ExternalSharedDatabase::DB_MASTER, $wgExternalSharedDB
			],
			'specials slave DB' => [
				SpecialsDatabase::DB_SLAVE, $wgSpecialsDB
			],
			'specials master DB' => [
				SpecialsDatabase::DB_MASTER, $wgSpecialsDB
			],
			'stats slave DB' => [
				StatsDatabase::DB_SLAVE, $wgStatsDB
			],
			'stats master DB' => [
				StatsDatabase::DB_MASTER, $wgStatsDB
			],
			'dataware slave DB' => [
				DatawareDatabase::DB_SLAVE, $wgExternalDatawareDB
			],
			'dataware master DB' => [
				DatawareDatabase::DB_MASTER, $wgExternalDatawareDB
			],
		];
	}
}
