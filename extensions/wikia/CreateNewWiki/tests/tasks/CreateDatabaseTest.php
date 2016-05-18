<?php

namespace Wikia\CreateNewWiki\Tasks;

class CreateDatabaseTest extends \WikiaBaseTest {

	public function setUp() {
		$this->setupFile = dirname(__FILE__) . '/../../CreateNewWiki_setup.php';
		parent::setUp();

	}

	public function tearDown() {
		parent::tearDown();
	}

	private function mockSharedDBConnectionDBNameFree() {
		$resultWithoutRow = (object) array( 'count' => 0 );
		$wfDBWMock = $this->getMock( 'DatabaseMysqli', [ 'selectRow' ] );
		$wfDBWMock
			->expects( $this->any() )
			->method( 'selectRow' )
			->willReturn( $resultWithoutRow );
		$this->mockStaticMethod( '\WikiFactory', 'db', $wfDBWMock );
	}

	private function mockSharedDBConnectionDBNameTaken() {
		$resultWithRow = (object) array( 'count' => 1 );
		$resultWithoutRow = (object) array( 'count' => 0 );
		$wfDBWMock = $this->getMock( 'DatabaseMysqli', [ 'selectRow' ] );
		$wfDBWMock
			->expects( $this->at( 0 ) )
			->method( 'selectRow' )
			->willReturn( $resultWithRow );
		$wfDBWMock
			->expects( $this->at( 1 ) )
			->method( 'selectRow' )
			->willReturn( $resultWithoutRow );
		$this->mockStaticMethod( '\WikiFactory', 'db', $wfDBWMock );
	}

	private function mockLocalClusterConnectionDBNameFree() {
		$wikiDBWMock = $this->getMock( 'DatabaseMysqli', [ 'query', 'numRows' ] );
		$this->mockGlobalFunction( 'wfGetDB', $wikiDBWMock);
		$wikiDBWMock
			->expects( $this->once() )
			->method( 'query' );
		$wikiDBWMock
			->expects( $this->once() )
			->method( 'numRows' )
			->willReturn( 0 );
	}

	private function mockLocalClusterConnectionDBNameOneTaken() {
		$wikiDBWMock = $this->getMock( 'DatabaseMysqli', [ 'query', 'numRows' ] );
		$this->mockGlobalFunction( 'wfGetDB', $wikiDBWMock);
		$wikiDBWMock
			->expects( $this->any() )
			->method( 'query' );
		$wikiDBWMock
			->expects(  $this->at( 1 ) )
			->method( 'numRows' )
			->willReturn( 1 );
		$wikiDBWMock
			->expects( $this->at( 3 ) )
			->method( 'numRows' )
			->willReturn( 0 );
	}

	private function mockLocalClusterConnectionDBNameAllTaken() {
		$wikiDBWMock = $this->getMock( 'DatabaseMysqli', [ 'query', 'numRows' ] );
		$this->mockGlobalFunction( 'wfGetDB', $wikiDBWMock);
		$wikiDBWMock
			->expects( $this->any() )
			->method( 'query' );
		$wikiDBWMock
			->expects(  $this->any() )
			->method( 'numRows' )
			->willReturn( 1 );
	}

	/**
	 * @param $taskContextInputData input data
	 * @param $taskContextExpected expected data
	 * @dataProvider dataProviderPrepare
	 */
	public function testPrepareShouldTakeDefaultDbName( $taskContextInputData, $taskContextExpected ) {
		///given
		$taskContext = new TaskContext( $taskContextInputData );
		$task = new CreateDatabase( $taskContext );

		$this->mockSharedDBConnectionDBNameFree();
		$this->mockLocalClusterConnectionDBNameFree();

		//when
		$result = $task->prepare();

		//then
		$taskContextData = $taskContext->getAllProperties();
		foreach ($taskContextExpected as $key => $value) {
			$this->assertEquals( $value, $taskContextData[ $key ] );
		}
		$this->assertEquals( true, $result->isOk());
	}

	/**
	 * @param $taskContextInputData input data
	 * @param $taskContextExpected expected data
	 * @dataProvider dataProviderPrepare
	 */
	public function testPrepareShouldTakeOtherDbNameWhenWikiCitiesTaken( $taskContextInputData, $taskContextExpected ) {
		//given
		$taskContext = new TaskContext( $taskContextInputData );
		$task = new CreateDatabase( $taskContext );

		$this->mockSharedDBConnectionDBNameTaken();
		$this->mockLocalClusterConnectionDBNameFree();

		//when
		$result = $task->prepare();

		//then
		$taskContextData = $taskContext->getAllProperties();
		$this->assertEquals( true, $result->isOk());
		//We expect that the db name will have the original name + some suffix i.e. textWiki123
		$this->assertNotEquals( $taskContextExpected[ 'dbName' ], $taskContextData[ 'dbName' ] );
		$this->assertContains( $taskContextExpected[ 'dbName' ], $taskContextData[ 'dbName' ] );
	}

	/**
	 * @param $taskContextInputData input data
	 * @param $taskContextExpected expected data
	 * @dataProvider dataProviderPrepare
	 */
	public function testPrepareShouldTakeOtherDbNameWhenLocalClusterTaken( $taskContextInputData, $taskContextExpected ) {
		//given
		$taskContext = new TaskContext( $taskContextInputData );
		$task = new CreateDatabase( $taskContext );

		$this->mockSharedDBConnectionDBNameFree();
		$this->mockLocalClusterConnectionDBNameOneTaken();

		//when
		$result = $task->prepare();

		//then
		$taskContextData = $taskContext->getAllProperties();
		$this->assertEquals( true, $result->isOk());
		//We expect that the db name will have the original name + some suffix i.e. textWiki123
		$this->assertNotEquals( $taskContextExpected[ 'dbName' ], $taskContextData[ 'dbName' ] );
		$this->assertContains( $taskContextExpected[ 'dbName' ], $taskContextData[ 'dbName' ] );
	}

	public function testPrepareShouldReturnErrorAllDbNamesTaken(  ) {
		//given
		$taskContext = new TaskContext( [ 'wikiName' => 'testWiki', 'language' => 'en' ] );
		$task = new CreateDatabase( $taskContext );

		$this->mockSharedDBConnectionDBNameFree();
		$this->mockLocalClusterConnectionDBNameAllTaken();

		//when
		$result = $task->prepare();

		//then
		$this->assertEquals( false, $result->isOk());
		$this->assertEquals( null, $taskContext->getDbName() );
	}

	public function dataProviderPrepare() {
		return [
			[
				[ 'wikiName' => 'testWiki', 'language' => 'en' ],
				[ 'dbName' => 'testWiki' ],
			],
			[
				[ 'wikiName' => 'testWiki', 'language' => 'de' ],
				[ 'dbName' => 'detestWiki' ],
			]
		];
	}

	public function testCheckReadOnlyModeOn(  ) {
		//given
		$taskContext = new TaskContext( [] );
		$task = new CreateDatabase( $taskContext );

		$this->mockGlobalVariable( 'wgReadOnly', true );

		//when
		$result = $task->check();

		//then
		$this->assertEquals( false, $result->isOk());
	}

	public function testCheckLocalClusterReadOnly(  ) {
		//given
		$wikiDBWMock = $this->getMock( 'DatabaseMysqli', [ 'getLBInfo' ] );
		$wikiDBWMock
			->expects( $this->once() )
			->method( 'getLBInfo' )
			->willReturn( 'Test Reason' );

		$this->mockGlobalVariable( 'wgReadOnly', false );
		$taskContext = new TaskContext( [ 'wikiDBW' => $wikiDBWMock ] );
		$task = new CreateDatabase( $taskContext );

		//when
		$result = $task->check();

		//then
		$this->assertEquals( false, $result->isOk());
	}

	public function testCheckOk(  ) {
		//given
		$wikiDBWMock = $this->getMock( 'DatabaseMysqli', [ 'getLBInfo' ] );
		$wikiDBWMock
			->expects( $this->once() )
			->method( 'getLBInfo' )
			->willReturn( false );

		$this->mockGlobalVariable( 'wgReadOnly', false );
		$taskContext = new TaskContext( [ 'wikiDBW' => $wikiDBWMock ] );
		$task = new CreateDatabase( $taskContext );

		//when
		$result = $task->check();

		//then
		$this->assertEquals( true, $result->isOk());
	}
}
