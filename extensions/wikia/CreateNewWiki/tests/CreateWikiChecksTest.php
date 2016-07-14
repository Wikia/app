<?php

class CreateWikiTestChecks extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../CreateNewWiki_setup.php';

		parent::setUp();

		$userMock = $this->getMock( 'stdClass', array( 'getGroups' ) );
		$userMock->expects( $this->any() )
			->method( 'getGroups' )
			->will( $this->returnValue( array() ) );

		$this->mockGlobalVariable( 'wgUser', $userMock );
	}

	/**
	 * @dataProvider getDomainCheckData
	 */
	public function testCheckDomainIsCorrect( $domainName, $lang, $isCorrect, $expectedErrorKey ) {

		$messageMock = $this->getMock( 'stdClass', array( 'text' ) );
		$messageMock->expects( $this->any() )
			->method( 'text' )
			->will( $this->returnValue( 'mocked-string' ) );

		if ( !$isCorrect ) {
			$this->getGlobalFunctionMock( 'wfMessage' )
				->expects( $this->exactly( 1 ) )
				->method( 'wfMessage' )
				->with( $this->equalTo( $expectedErrorKey ) )
				->will( $this->returnValue( $messageMock ) );
		}

		$this->mockStaticMethod( 'CreateWikiChecks', 'checkBadWords', true );
		$this->mockStaticMethod( 'CreateWikiChecks', 'checkDomainExists', false );
		$this->mockStaticMethod( 'CreateWikiChecks', 'getLanguageNames', array(
			'pl' => 'pl',
			'en' => 'en',
			'def' => 'def',
			'zzz' => 'zzz',
		) );

		$result = CreateWikiChecks::checkDomainIsCorrect( $domainName, $lang );

		if ( $isCorrect ) {
			$this->assertEquals( '', $result );
		} else {
			$this->assertEquals( 'mocked-string', $result );
		}
	}

	function getDomainCheckData() {
		return array(
			array( 'asd', 'pl', true, null ),
			array( 'as-d', 'en', true, null ),
			array( 'asd', 'en', true, null ),
			array( 'asd', 'pl', true, null ),
			array( 'asd-', 'pl', false, 'autocreatewiki-bad-name' ),
			array( 'asd-', 'pl', false, 'autocreatewiki-bad-name' ),
			array( 'as)d', 'pl', false, 'autocreatewiki-bad-name' ),
			array( 'as<d', 'pl', false, 'autocreatewiki-bad-name' ),
			array( 'as$d', 'pl', false, 'autocreatewiki-bad-name' ),
			array( 'as@d', 'pl', false, 'autocreatewiki-bad-name' ),
			array( 'as    d', 'pl', false, 'autocreatewiki-bad-name' ),
			array( 'as	d', 'pl', false, 'autocreatewiki-bad-name' ),
			array( '', 'pl', false, 'autocreatewiki-empty-field' ),
			array( 'a', 'pl', false, 'autocreatewiki-name-too-short' ),
			array( '012345678901234567890123456789012345678901234567890', 'pl', false, 'autocreatewiki-name-too-long' ),
			array( 'def', 'pl', false, 'autocreatewiki-violate-policy' ),
			array( 'zzz', 'en', false, 'autocreatewiki-violate-policy' ),
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.03061 ms
	 */
	function testCheckDomainIsCorrectBadWords() {
		$messageMock = $this->getMock( 'stdClass', array( 'text' ) );
		$messageMock->expects( $this->any() )
			->method( 'text' )
			->will( $this->returnValue( 'mocked-string' ) );

		$this->getGlobalFunctionMock( 'wfMessage' )
			->expects( $this->exactly( 1 ) )
			->method( 'wfMessage' )
			->with( $this->equalTo( 'autocreatewiki-violate-policy' ) )
			->will( $this->returnValue( $messageMock ) );

		$this->mockStaticMethod( 'CreateWikiChecks', 'checkBadWords', false );
		$this->mockStaticMethod( 'CreateWikiChecks', 'getLanguageNames', array(
			'pl' => 'pl',
		) );

		$result = CreateWikiChecks::checkDomainIsCorrect( 'woohooo', 'pl' );

		$this->assertEquals( 'mocked-string', $result );
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.03205 ms
	 */
	function testCheckDomainIsCorrectDomainExists() {
		$messageMock = $this->getMock( 'stdClass', array( 'text' ) );
		$messageMock->expects( $this->any() )
			->method( 'text' )
			->will( $this->returnValue( 'mocked-string' ) );

		$this->getGlobalFunctionMock( 'wfMessage' )
			->expects( $this->exactly( 1 ) )
			->method( 'wfMessage' )
			->with( $this->equalTo( 'autocreatewiki-name-taken' ) )
			->will( $this->returnValue( $messageMock ) );

		$this->mockStaticMethod( 'CreateWikiChecks', 'checkBadWords', true );
		$this->mockStaticMethod( 'CreateWikiChecks', 'checkDomainExists', true );
		$this->mockStaticMethod( 'CreateWikiChecks', 'getLanguageNames', array(
			'pl' => 'pl',
		) );

		$result = CreateWikiChecks::checkDomainIsCorrect( 'woohooo', 'pl' );

		$this->assertEquals( 'mocked-string', $result );
	}
}
