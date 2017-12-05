<?php

use PHPUnit\Framework\TestCase;

class TemporaryTableManagerTest extends TestCase {
	/** @var DatabaseBase|PHPUnit_Framework_MockObject_MockObject */
	private $databaseConnectionMock;

	/** @var TemporaryTableManager $temporaryTableManager */
	private $temporaryTableManager;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../includes/TemporaryTableManager.php';

		$this->databaseConnectionMock = $this->createMock( DatabaseMysqli::class );

		$this->temporaryTableManager = new TemporaryTableManager( $this->databaseConnectionMock );
	}

	/**
	 * @dataProvider sqlProvider
	 * @param string $sqlQuery
	 */
	public function testTransactionStateAndFlagsAreNotManipulatedWhenDboTrxIsNotSet( $sqlQuery ) {
		$this->databaseConnectionMock->expects( $this->any() )
			->method( 'getFlag' )
			->with( DBO_TRX )
			->willReturn( false );

		$this->databaseConnectionMock->expects( $this->once() )
			->method( 'query' )
			->with( $sqlQuery, $this->anything() );

		$this->databaseConnectionMock->expects( $this->never() )
			->method( 'commit' );
		$this->databaseConnectionMock->expects( $this->never() )
			->method( 'setFlag' );

		$this->temporaryTableManager->queryWithAutoCommit( $sqlQuery );
	}

	/**
	 * @dataProvider sqlProvider
	 * @param string $sqlQuery
	 */
	public function testDboTrxFlagIsPreservedButCommitIsNotCalledIfDboTrxIsSetWithNoOpenTransaction(
		$sqlQuery
	) {
		$this->databaseConnectionMock->expects( $this->any() )
			->method( 'getFlag' )
			->with( DBO_TRX )
			->willReturn( true );
		$this->databaseConnectionMock->expects( $this->any() )
			->method( 'trxLevel' )
			->willReturn( false );

		$this->databaseConnectionMock->expects( $this->once() )
			->method( 'query' )
			->with( $sqlQuery, $this->anything() );

		$this->databaseConnectionMock->expects( $this->never() )
			->method( 'commit' );
		$this->databaseConnectionMock->expects( $this->once() )
			->method( 'setFlag' )
			->with( DBO_TRX );

		$this->temporaryTableManager->queryWithAutoCommit( $sqlQuery );
	}

	/**
	 * @dataProvider sqlProvider
	 * @param string $sqlQuery
	 */
	public function testDboTrxFlagIsPreservedAndCommitIsCalledIfDboTrxIsSetWithOpenTransaction(
		$sqlQuery
	) {
		$this->databaseConnectionMock->expects( $this->any() )
			->method( 'getFlag' )
			->with( DBO_TRX )
			->willReturn( true );
		$this->databaseConnectionMock->expects( $this->any() )
			->method( 'trxLevel' )
			->willReturn( true );

		$this->databaseConnectionMock->expects( $this->once() )
			->method( 'query' )
			->with( $sqlQuery, $this->anything() );

		$this->databaseConnectionMock->expects( $this->once() )
			->method( 'commit' );
		$this->databaseConnectionMock->expects( $this->once() )
			->method( 'setFlag' )
			->with( DBO_TRX );

		$this->temporaryTableManager->queryWithAutoCommit( $sqlQuery );
	}

	public function sqlProvider() {
		return array(
			array( 'CREATE TEMPORARY TABLE semantic_drilldown_values ( id INT NOT NULL )' ),
			array( 'CREATE INDEX id_index ON semantic_drilldown_values ( id )' ),
			array( 'INSERT INTO semantic_drilldown_values SELECT ids.smw_id AS id\n' ),
		);
	}
}
