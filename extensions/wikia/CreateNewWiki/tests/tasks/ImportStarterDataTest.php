<?php

namespace Wikia\CreateNewWiki\Tasks;

class ImportStarterDataTest extends \WikiaBaseTest {

	private $taskContextMock;

	public function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../../CreateNewWiki_setup.php';
		parent::setUp();

		$this->taskContextMock = $this->getMock( '\Wikia\CreateNewWiki\Tasks\TaskContext', [ 'setStarterDB' ] );
		$this->mockClass( 'TaskContext', $this->taskContextMock );
	}

	public function tearDown() {
		parent::tearDown();
	}

	/**
	 * @dataProvider checkDataProvider
	 * @param $return
	 * @param $expected
	 */
	public function testCheck( $return, $expected ) {
		$importStarterDataTask = $this->getMockBuilder( '\Wikia\CreateNewWiki\Tasks\ImportStarterData' )
			->enableOriginalConstructor()
			->setConstructorArgs( [ $this->taskContextMock ] )
			->setMethods( [ 'canExecute' ] )
			->getMock();

		$importStarterDataTask
			->expects( $this->any() )
			->method( 'canExecute' )
			->willReturn( $return );

		$this->mockStaticMethod( '\Wikia\CreateNewWiki\Tasks\TaskResult', 'createForSuccess', 'ok' );
		$this->mockStaticMethod( '\Wikia\CreateNewWiki\Tasks\TaskResult', 'createForError', 'error' );

		$result = $importStarterDataTask->check();

		$this->assertEquals( $expected, $result );
	}

	public function checkDataProvider() {
		return [
			[ true, 'ok' ],
			[ false, 'error' ]
		];
	}

	/**
	 * @param $shellExecReturn
	 * @param $expected
	 * @dataProvider runDataProvider
	 */
	public function testRun( $shellExecReturn, $expected ) {
		$this->taskContextMock
			->expects( $this->once() )
			->method( 'setStarterDB' );

		$importStarterDataTask = $this->getMockBuilder( '\Wikia\CreateNewWiki\Tasks\ImportStarterData' )
			->enableOriginalConstructor()
			->setConstructorArgs( [ $this->taskContextMock ] )
			->setMethods( [ 'executeShell' ] )
			->getMock();

		$importStarterDataTask
			->expects( $this->any() )
			->method( 'executeShell' )
			->willReturn( $shellExecReturn );

		$this->mockStaticMethod( '\Wikia\CreateNewWiki\Tasks\TaskResult', 'createForSuccess', 'ok' );
		$this->mockStaticMethod( '\Wikia\CreateNewWiki\Tasks\TaskResult', 'createForError', 'error' );
		$this->mockStaticMethod( '\Wikia\CreateNewWiki\Tasks\TaskHelper', 'waitForSlaves', null );
		$this->mockStaticMethod( '\Wikia\CreateNewWiki\Starters', 'getStarterByLanguage', null );

		$result = $importStarterDataTask->run();

		$this->assertEquals( $expected, $result );
	}

	public function runDataProvider() {
		return [
			[ 0, 'ok' ],
			[ 1, 'error' ]
		];
	}
}
