<?php

namespace Wikia\CreateNewWiki\Tasks;

class PrepareDomainTest extends \WikiaBaseTest {

	private $taskContextMock;

	public function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../../CreateNewWiki_setup.php';
		parent::setUp();

		$this->taskContextMock = $this->getMock(
			'\Wikia\CreateNewWiki\Tasks\TaskContext',
			[ 'setSiteName', 'setWikiName', 'setDomain', 'setUrl', 'getInputWikiName', 'getInputDomain', 'getLanguage' ]
		);
		$this->mockClass( 'TaskContext', $this->taskContextMock );

		$this->mockStaticMethod( '\Wikia\CreateNewWiki\Tasks\TaskResult', 'createForSuccess', 'ok' );
		$this->mockStaticMethod( '\Wikia\CreateNewWiki\Tasks\TaskResult', 'createForError', 'error' );
	}

	public function tearDown() {
		parent::tearDown();
	}

	/**
	 * @param $inputDomain
	 * @param $expected
	 * @dataProvider getDomainDataProvider
	 */
	public function testGetDomain( $inputDomain, $expected ) {
		$prepareDomainTask = new PrepareDomain( $this->taskContextMock );

		$result = $prepareDomainTask->getDomain( $inputDomain );

		$this->assertEquals( $expected, $result );
	}

	public function getDomainDataProvider() {
		return [
			[ 'foo', 'foo' ],
			[ 'FOO', 'foo' ],
			[ 'foo-bar', 'foo-bar' ],
			[ ' foo ', 'foo' ],
			[ '--foo', 'foo' ],
			[ '--foo--', 'foo' ]
		];
	}

	public function testPrepare() {
		$this->taskContextMock
			->expects( $this->once() )
			->method( 'setSiteName' );

		$this->taskContextMock
			->expects( $this->once() )
			->method( 'setWikiName' );

		$this->taskContextMock
			->expects( $this->once() )
			->method( 'setDomain' );

		$this->taskContextMock
			->expects( $this->once() )
			->method( 'setUrl' );

		$prepareDomainTask = $this->getMockBuilder( '\Wikia\CreateNewWiki\Tasks\PrepareDomain' )
			->enableOriginalConstructor()
			->setConstructorArgs( [ $this->taskContextMock ] )
			->setMethods( [ 'getDomain', 'getSiteName' ] )
			->getMock();

		$result = $prepareDomainTask->prepare();

		$this->assertEquals( $result, 'ok' );
	}

	/**
	 * @dataProvider checkDataProvider
	 * @param $errorMessage
	 * @param $expected
	 */
	public function testCheck( $errorMessage, $expected ) {
		$this->mockStaticMethod( '\CreateWikiChecks', 'checkDomainIsCorrect', $errorMessage );

		$prepareDomainTask = new PrepareDomain( $this->taskContextMock );

		$result = $prepareDomainTask->check();

		$this->assertEquals( $result, $expected );
	}

	public function checkDataProvider() {
		return [
			[ null, 'ok' ],
			[ 'an error occured', 'error' ]
		];
	}

	/**
	 * @dataProvider runDataProvider
	 * @param $status
	 * @param $expected
	 */
	public function testRun( $status, $expected ) {
		$prepareDomainTask = $this->getMockBuilder( '\Wikia\CreateNewWiki\Tasks\PrepareDomain' )
			->enableOriginalConstructor()
			->setConstructorArgs( [ $this->taskContextMock ] )
			->setMethods( [ 'lockDomain' ] )
			->getMock();

		$prepareDomainTask
			->expects( $this->any() )
			->method( 'lockDomain' )
			->willReturn( $status );

		$result = $prepareDomainTask->run();

		$this->assertEquals( $result, $expected );
	}

	public function runDataProvider() {
		return [
			[ true, 'ok' ],
			[ false, 'error' ]
		];
	}
}
