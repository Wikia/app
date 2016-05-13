<?php

namespace Wikia\CreateNewWiki\Tasks;

class ConfigureUsersTest extends \WikiaBaseTest {

	private $taskContextMock;

	public function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../../CreateNewWiki_setup.php';
		parent::setUp();

		$this->taskContextMock = $this->getMock( '\Wikia\CreateNewWiki\Tasks\TaskContext', [ 'setFounder', 'getFounder' ] );
		$this->mockClass( 'TaskContext', $this->taskContextMock );
	}

	public function tearDown() {
		parent::tearDown();
	}

	public function testPrepare() {
		$configureUsersTask = new ConfigureUsers( $this->taskContextMock );

		$this->taskContextMock
			->expects( $this->once() )
			->method( 'setFounder' );

		$configureUsersTask->prepare();
	}

	/**
	 * @dataProvider checkDataProvider
	 * @param $isAnon
	 * @param $expected
	 */
	public function testCheck( $isAnon, $expected ) {
		$userMock = $this->getMock( 'User', [ 'isAnon' ] );
		$userMock
			->expects( $this->any() )
			->method( 'isAnon' )
			->will( $this->returnValue( $isAnon ) );

		$this->taskContextMock
			->expects( $this->any() )
			->method( 'getFounder' )
			->willReturn( $userMock );

		$configureUsersTask = new ConfigureUsers( $this->taskContextMock );

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
}
