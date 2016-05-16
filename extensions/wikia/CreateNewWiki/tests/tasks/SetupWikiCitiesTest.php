<?php

namespace Wikia\CreateNewWiki\Tasks;

class SetupWikiCitiesTest extends \WikiaBaseTest {

	private $taskContextMock;

	public function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../../CreateNewWiki_setup.php';
		parent::setUp();

		$this->taskContextMock = $this->getMock( '\Wikia\CreateNewWiki\Tasks\TaskContext', [ 'setCityId', 'getSharedDBW' ] );
		$this->mockClass( 'TaskContext', $this->taskContextMock );
	}

	public function tearDown() {
		parent::tearDown();
	}

	/**
	 * @dataProvider runDataProvider
	 * @param $addToCityListReturn
	 * @param $setCityIdCalled
	 * @param $insertId
	 * @param $addToCityDomainsReturn
	 * @param $expected
	 */
	public function testRun( $addToCityListReturn, $setCityIdCalled, $insertId, $addToCityDomainsReturn, $expected ) {
		$setupWikiCitiesTask = $this->getMockBuilder( '\Wikia\CreateNewWiki\Tasks\SetupWikiCities' )
			->enableOriginalConstructor()
			->setConstructorArgs( [ $this->taskContextMock ] )
			->setMethods( [ 'addToCityList', 'addToCityDomains' ] )
			->getMock();

		$setupWikiCitiesTask
			->expects( $this->any() )
			->method( 'addToCityList' )
			->willReturn( $addToCityListReturn );

		$setupWikiCitiesTask
			->expects( $this->any() )
			->method( 'addToCityDomains' )
			->willReturn( $addToCityDomainsReturn );

		$sharedDBWMock = $this->getMock( '\DatabaseMysqli', [ 'insertId' ] );
		$sharedDBWMock
			->expects( $this->any() )
			->method( 'insertId' )
			->willReturn( $insertId );

		$this->taskContextMock
			->expects( $this->any() )
			->method( 'getSharedDBW' )
			->willReturn( $sharedDBWMock );

		$this->mockStaticMethod( '\Wikia\CreateNewWiki\Tasks\TaskResult', 'createForError', 'error' );
		$this->mockStaticMethod( '\Wikia\CreateNewWiki\Tasks\TaskResult', 'createForSuccess', 'ok' );

		$this->taskContextMock
			->expects( $this->$setCityIdCalled() )
			->method( 'setCityId' );

		$result = $setupWikiCitiesTask->run();

		$this->assertEquals( $expected, $result );
	}

	public function runDataProvider() {
		return [
			[ false, 'never', null, null, 'error' ],
			[ true, 'once', 0, null, 'error' ],
			[ true, 'once', 99, 0, 'error' ],
			[ true, 'once', 99, true, 'ok' ]
		];
	}

}
