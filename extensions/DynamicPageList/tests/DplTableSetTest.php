<?php

use PHPUnit\Framework\TestCase;

class DplTableSetTest extends TestCase {
	/** @var DatabaseBase|PHPUnit_Framework_MockObject_MockObject $databaseConnectionMock */
	private $databaseConnectionMock;

	/** @var DplTableSet $dplTableSet */
	private $dplTableSet;

	protected function setUp() {
		parent::setUp();

		require_once __DIR__ . '/../DynamicPageList.php';

		$this->databaseConnectionMock = $this->createMock( DatabaseBase::class );
		$this->dplTableSet = new DplTableSet( $this->databaseConnectionMock );

		$this->databaseConnectionMock->expects( $this->any() )
			->method( 'tableName' )
			->willReturnArgument( 0 );

		$this->databaseConnectionMock->expects( $this->any() )
			->method( 'addIdentifierQuotes' )
			->willReturnArgument( 0 );
	}

	public function testAddTable() {
		$tables = [ 'revision', 'page', 'user' ];

		foreach ( $tables as $tableName ) {
			$this->dplTableSet->addTable( $tableName );
		}

		$this->assertEquals( 'revision, page, user,', $this->dplTableSet->getTables() );
	}

	public function testAddTableDoesNotDuplicateTables() {
		$tables = [ 'revision', 'page', 'page' ];

		foreach ( $tables as $tableName ) {
			$this->dplTableSet->addTable( $tableName );
		}

		$this->assertEquals( 'revision, page,', $this->dplTableSet->getTables() );
	}

	public function testAddTableAlias() {
		$tables = [
			'revision' => 'my_rev',
			'page' => 'my_page'
		];

		foreach ( $tables as $tableName => $alias ) {
			$this->dplTableSet->addTableAlias( $tableName, $alias );
		}

		$this->assertEquals(
			'revision AS my_rev, page AS my_page,',
			$this->dplTableSet->getTables()
		);
	}

	public function testAddTableAliasedAndNotAliased() {
		$tables = [ 'revision', 'page' ];
		$aliasTables = [
			'revision' => 'my_rev',
			'page' => 'my_page'
		];

		foreach ( $tables as $tableName ) {
			$this->dplTableSet->addTable( $tableName );
		}

		foreach ( $aliasTables as $tableName => $alias ) {
			$this->dplTableSet->addTableAlias( $tableName, $alias );
		}

		$this->assertEquals(
			'revision, page, revision AS my_rev, page AS my_page,',
			$this->dplTableSet->getTables()
		);
	}

	public function testTableAliasIsNotAddedIfTableWithSameNameIsSet() {
		$tables = [ 'revision', 'page' ];
		$aliasTables = [
			'revision' => 'my_rev',
			'foo_bar' => 'page'
		];

		foreach ( $tables as $tableName ) {
			$this->dplTableSet->addTable( $tableName );
		}

		foreach ( $aliasTables as $tableName => $alias ) {
			$this->dplTableSet->addTableAlias( $tableName, $alias );
		}

		$this->assertEquals(
			'revision, page, revision AS my_rev,',
			$this->dplTableSet->getTables()
		);
	}

	public function testTableIsNotAddedIfTableWithSomeAliasIsSet() {
		$aliasTables = [
			'revision' => 'my_rev',
			'foo_bar' => 'page'
		];
		$tables = [ 'revision', 'page' ];

		foreach ( $aliasTables as $tableName => $alias ) {
			$this->dplTableSet->addTableAlias( $tableName, $alias );
		}

		foreach ( $tables as $tableName ) {
			$this->dplTableSet->addTable( $tableName );
		}

		$this->assertEquals(
			'revision AS my_rev, foo_bar AS page, revision,',
			$this->dplTableSet->getTables()
		);
	}

	public function testNoTablesProducesEmptyStatement() {
		$this->assertEmpty( $this->dplTableSet->getTables() );
	}
}
