<?php

namespace Wikia\CreateNewWiki\Tasks;

class SetupWikiCitiesTest extends \WikiaBaseTest {

	public function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../../CreateNewWiki_setup.php';
		parent::setUp();
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

		/** @var TaskContext|\PHPUnit_Framework_MockObject_MockObject $taskContextMock */
		$taskContextMock = $this->getMockBuilder( TaskContext::class )
			->disableOriginalConstructor()
			->setMethods( [ 'setCityId', 'getSharedDBW' ] )
			->getMock();

		$setupWikiCitiesTask = $this->getMockBuilder( '\Wikia\CreateNewWiki\Tasks\SetupWikiCities' )
			->enableOriginalConstructor()
			->setConstructorArgs( [ $taskContextMock ] )
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

		$taskContextMock
			->expects( $this->any() )
			->method( 'getSharedDBW' )
			->willReturn( $sharedDBWMock );

		$this->mockStaticMethod( '\Wikia\CreateNewWiki\Tasks\TaskResult', 'createForError', 'error' );
		$this->mockStaticMethod( '\Wikia\CreateNewWiki\Tasks\TaskResult', 'createForSuccess', 'ok' );

		$taskContextMock
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

	/**
	 * @dataProvider addToCityDomainsProvider
	 * @param $cityDomain
	 * @param $expectedDomains
	 */
	public function testAddToCityDomains( $cityDomain, $expectedDomains ) {
		$taskContext = $this->getMockBuilder( TaskContext::class )
			->disableOriginalConstructor()
			->setMethods( [ 'setCityId', 'getSharedDBW', 'getCityId' ] )
			->getMock();

		$taskContext->setUrl( 'http://' . $cityDomain . '/' );
		$taskContext->setDomain( $cityDomain );
		$taskContext
			->expects( $this->any() )
			->method( 'getCityId' )
			->willReturn( 321 );

		$mockedDB = $this->getMockBuilder( 'stdObject' )
			->disableOriginalConstructor()
			->setMethods( [ 'insert' ] )
			->getMock();

		$taskContext
			->expects( $this->any() )
			->method( 'getSharedDBW' )
			->willReturn( $mockedDB );

		$expectedDbValues = [];
		foreach($expectedDomains as $domain) {
			$expectedDbValues[] = ['city_id' => 321, 'city_domain' => $domain];

		}
		$mockedDB
			->expects( $this->once() )
			->method( 'insert' )
			->with( "city_domains", $expectedDbValues, $this->anything() );

		$setupWikiCitiesTask = new \Wikia\CreateNewWiki\Tasks\SetupWikiCities( $taskContext );

		$setupWikiCitiesTask->addToCityDomains();

	}

	public function addToCityDomainsProvider() {
		return [
			[ 'wiki1.wikia.com', [ 'wiki1.wikia.com', 'www.wiki1.wikia.com' ] ],
			[ 'wiki1.fandom.com', [ 'wiki1.fandom.com', 'wiki1.wikia.com' ] ],
		];
	}
}
