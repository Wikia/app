<?php

namespace Wikia\CreateNewWiki\Tasks;

class ConfigureUsersTest extends \WikiaBaseTest {

	/** @var TaskContext $taskContext */
	private $taskContext;

	public function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../../CreateNewWiki_setup.php';
		parent::setUp();

		$this->taskContext = new TaskContext( [] );
	}

	public function testPrepare() {
		$configureUsersTask = new ConfigureUsers( $this->taskContext );
		$configureUsersTask->prepare();

		$this->assertSame( $this->app->wg->User, $this->taskContext->getFounder() );
	}

	/**
	 * @dataProvider checkDataProvider
	 * @param $isAnon
	 * @param $expected
	 */
	public function testCheck( $isAnon, $expected ) {
		$userMock = $this->getMockBuilder( \User::class )
			->setMethods( [ 'isAnon' ] )
			->getMock();
		$userMock
			->expects( $this->any() )
			->method( 'isAnon' )
			->will( $this->returnValue( $isAnon ) );

		$this->taskContext->setFounder( $userMock );

		$configureUsersTask = new ConfigureUsers( $this->taskContext );

		$this->mockStaticMethod( '\Wikia\CreateNewWiki\Tasks\TaskResult', 'createForError', 'error' );
		$this->mockStaticMethod( '\Wikia\CreateNewWiki\Tasks\TaskResult', 'createForSuccess', 'ok' );

		$result = $configureUsersTask->check();

		$this->assertEquals( $expected, $result );

	}

	public function checkDataProvider() {
		return [
			[ true, 'error' ],
			[ false, 'ok' ]
		];
	}

	/**
	 * @param int $userId
	 * @param int $replaceCalledCount
	 * @param bool $expected
	 * @dataProvider addUserToGroupDataProvider
	 */
	public function testAddUserToGroup( $userId, $replaceCalledCount, $expected ) {
		$userMock = $this->getMockBuilder( \User::class )
			->setMethods( [ 'getId' ] )
			->getMock();
		$userMock
			->expects( $this->any() )
			->method( 'getId' )
			->will( $this->returnValue( $userId ) );

		$this->taskContext->setFounder( $userMock );

		$wikiDBWMock = $this->getDatabaseMock( [ 'replace' ] );
		$wikiDBWMock
			->expects( $this->exactly( $replaceCalledCount ) )
			->method( 'replace' );

		$this->taskContext->setWikiDBW( $wikiDBWMock );

		$configureUsersTask = $this->getMockBuilder( '\Wikia\CreateNewWiki\Tasks\ConfigureUsers' )
			->enableOriginalConstructor()
			->setConstructorArgs( [ $this->taskContext ] )
			->setMethods( [ 'warning', 'debug' ] )
			->getMock();

		$result = $configureUsersTask->addUserToGroups();

		$this->assertEquals( $expected, $result );
	}

	public function addUserToGroupDataProvider() {
		return [
			[ 99, 2, true ],
			[ 0, 0, false ]
		];
	}
}
