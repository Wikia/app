<?php

namespace Wikia\CreateNewWiki\Tasks;

class PrepareDomainTest extends \WikiaBaseTest {

	private $taskContextMock;

	public function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../../CreateNewWiki_setup.php';
		parent::setUp();

		$this->taskContextMock = $this->getMockBuilder( TaskContext::class )
			->disableOriginalConstructor()
            ->setMethods( [ 'setSiteName', 'setWikiName', 'setDomain', 'setUrl', 'getInputWikiName', 'getInputDomain', 'getLanguage', 'setInputDomain' ] )
			->getMock();
	}

	/**
	 * @param $inputDomain
	 * @param $expected
	 * @dataProvider sanitizeInputDomainDataProvider
	 */
	public function testSanitizeInputDomain( $inputDomain, $expected ) {
		$prepareDomainTask = new PrepareDomain( $this->taskContextMock );

		$result = $prepareDomainTask->sanitizeInputDomain( $inputDomain );

		$this->assertEquals( $expected, $result );
	}

	public function sanitizeInputDomainDataProvider() {
		return [
			[ 'foo', 'foo' ],
			[ 'foo-bar', 'foo-bar' ],
			[ '--foo', 'foo' ],
			[ '--foo--', 'foo' ]
		];
	}

	/**
	 * @param $inputDomain
	 * @param $expected
	 * @dataProvider sanitizeDomainDataProvider
	 */
	public function testSanitizeDomain( $inputDomain, $expected ) {
		$prepareDomainTask = new PrepareDomain( $this->taskContextMock );

		$result = $prepareDomainTask->sanitizeDomain( $inputDomain );

		$this->assertEquals( $expected, $result );
	}

	public function sanitizeDomainDataProvider() {
		return [
			[ 'FOO', 'foo' ],
			[ ' foo ', 'foo' ],
		];
	}

	public function testPrepareEnglishWiki() {
		global $wgFandomBaseDomain;

		$taskContext = new TaskContext( [
			'language' => 'en',
			'inputDomain' => 'starwars',
		] );

		$prepareDomainTask = new PrepareDomain( $taskContext );

		$result = $prepareDomainTask->prepare();

		$this->assertTrue( $result->isOk() );

		$this->assertEquals( "starwars.$wgFandomBaseDomain", $taskContext->getDomain() );
		$this->assertEquals( "http://starwars.$wgFandomBaseDomain/", $taskContext->getURL() );
	}

	public function testPrepareLanguageWikiWithPath() {
		global $wgFandomBaseDomain;

		$taskContext = new TaskContext( [
			'language' => 'de',
			'inputDomain' => 'starwars',
		] );

		$prepareDomainTask = new PrepareDomain( $taskContext );

		$result = $prepareDomainTask->prepare();

		$this->assertTrue( $result->isOk() );

		$this->assertEquals( "starwars.$wgFandomBaseDomain/de", $taskContext->getDomain() );
		$this->assertEquals( "http://starwars.$wgFandomBaseDomain/de/", $taskContext->getURL() );
	}

	/**
	 * @dataProvider checkDataProvider
	 * @param $errorMessage
	 * @param $shouldSucceed
	 */
	public function testCheck( $errorMessage, $shouldSucceed ) {
		$this->mockStaticMethod( '\CreateWikiChecks', 'checkDomainIsCorrect', $errorMessage );

		$prepareDomainTask = new PrepareDomain( $this->taskContextMock );

		$result = $prepareDomainTask->check();

		if ( $shouldSucceed ) {
			$this->assertTrue( $result->isOk() );
		} else {
			$this->assertFalse( $result->isOk() );
		}
	}

	public function checkDataProvider() {
		return [
			[ null, true ],
			[ 'an error occured', false ]
		];
	}

	/**
	 * @dataProvider runDataProvider
	 * @param $status
	 * @param $shouldSucceed
	 */
	public function testRun( $status, $shouldSucceed ) {
		/** @var PrepareDomain $prepareDomainTask */
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

		if ( $shouldSucceed ) {
			$this->assertTrue( $result->isOk() );
		} else {
			$this->assertFalse( $result->isOk() );
		}
	}

	public function runDataProvider() {
		return [
			[ true, true ],
			[ false, false ]
		];
	}
}
