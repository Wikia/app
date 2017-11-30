<?php

class CreateNewWikiControllerTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = dirname(__FILE__) . '/../CreateNewWiki_setup.php';
		parent::setUp();
	}

	public function tearDown() {
		parent::tearDown();
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.07 ms
	 * @group hyun
	 * @dataProvider getCreateWikiDataProvider
	 */
	public function testCreateWikiSuccess( $testData ) {
		$wikiName = 'Muppet is great';
		$wikiDomain = 'muppet';
		$wikiLanguage = 'en';
		$wikiVertical = '3';
		$wikiId = 322389;
		$siteName = 'asdfasdf';
		$mainPageUrl = 'muppet.wikia.com/wiki/Main_page';

		$requestParams = array("wName" => $wikiName,
			"wDomain" => $wikiDomain,
			"wLanguage" => $wikiLanguage,
			"wVertical" => $wikiVertical);

		$wgRequest = $this->getMock('WebRequest');
		$wgRequest->expects($this->any())
			->method('getArray')
			->will($this->returnValue($requestParams));

		$wgDevelDomains = array();

		$wgUser = $this->createMock( User::class );
		$wgUser->expects($this->any())
			->method('getId')
			->will($this->returnValue(6));
		$wgUser->expects($this->any())
			->method('isLoggedIn')
			->will($this->returnValue( $testData['userLogged'] ) );
		$wgUser->expects($this->any())
			->method('isEmailConfirmed')
			->will( $this->returnValue( $testData['userEmailConfirmed'] ) );

		$app = $this->getMock('WikiaApp', array('getGlobal', 'runFunction'));
		$app->expects( $this->any() )
			->method('getGlobal')
			->will($this->onConsecutiveCalls($wgRequest, $wgDevelDomains, $wgUser));

		$this->mockGlobalVariable( 'wgUser', $wgUser );

		$createWiki = $this->getMockBuilder(CreateWiki::class )
			->disableOriginalConstructor()
			->setMethods( [ 'create', 'getWikiInfo', 'getCityId', 'getSiteName' ] )
			->getMock();
		$createWiki->expects($this->any())
			->method('create');
		$createWiki->expects($this->any())
			->method('getWikiInfo')
			->will($this->onConsecutiveCalls($wikiId, $siteName));

		$createWiki
			->expects($this->any())
			->method('getCityId')
			->willReturn(99);

		$createWiki->expects( $this->any() )
			->method( 'getSiteName' )
			->willReturn( $siteName );

		$mainPageTitle = $this->getMock('GlobalTitle', array(), array(), '', false);
		$mainPageTitle->expects($this->any())
			->method('getFullURL')
			->will($this->returnValue($mainPageUrl));

		$this->mockClass('CreateWiki', $createWiki);
		$this->mockClass('GlobalTitle', $mainPageTitle, 'newFromText');

		$requestMock = $this->getMockBuilder( WikiaRequest::class )
			->setMethods( [ 'assertValidWriteRequest' ] )
			->setConstructorArgs( [ [] ] )
			->getMock();

		if ( !$testData['validRequest'] ) {
			$requestMock->expects( $this->any() )
				->method( 'assertValidWriteRequest' )
				->willThrowException( new BadRequestException() );
		}

		$response = new WikiaResponse( 'json', $requestMock );

		if ( !empty( $testData['expectedException'] ) ) {
			$this->expectException( $testData['expectedException'] );
		}

		$createNewWikiController = new CreateNewWikiController();

		$createNewWikiController->setRequest( $requestMock );
		$createNewWikiController->setResponse( $response );
		$createNewWikiController->setApp( $app );

		$createNewWikiController->CreateWiki();

		$response = $createNewWikiController->getResponse();

		$this->assertEquals( $testData['status'], $response->getVal( 'status' ) );

		if ( $testData['userLogged'] && $testData['userEmailConfirmed'] ) {
			$this->assertEquals($siteName, $response->getVal('siteName'));
			$this->assertEquals($mainPageUrl, $response->getval('finishCreateUrl'));
		}
	}

	public function getCreateWikiDataProvider() {
		return [
			'Everything is OK' => [ [
				'validRequest' => true,
				'userLogged' => true,
				'userEmailConfirmed' => true,
				'status' => 'ok',
				'expectedException' => false
			] ],
			'User logged-in but without confirmed e-mail' => [ [
				'validRequest' => true,
				'userLogged' => true,
				'userEmailConfirmed' => false,
				'status' => 'error',
				'expectedException' => false,
			] ],
			'User not logged-in and therefore without confirmed e-mail' => [ [
				'validRequest' => true,
				'userLogged' => false,
				'userEmailConfirmed' => false,
				'status' => 'error',
				'expectedException' => false,
			] ],
			"Bad request" => [ [
				'validRequest' => false,
				'userLogged' => true,
				'userEmailConfirmed' => true,
				'status' => null,
				'expectedException' => 'BadRequestException',
			] ]
		];
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.03212 ms
	 */
	public function testCheckWikiNameSuccess() {

		$wikiName = 'muppet';
		$wikiLang = 'en';

		$wgRequest = $this->getMock('WebRequest');
		$wgRequest->expects($this->exactly(2))
			->method('getVal')
			->will($this->onConsecutiveCalls($wikiName, $wikiLang));

		$app = $this->getMock('WikiaApp', array('getGlobal', 'runFunction'));

		$this->mockGlobalVariable('wgRequest',$wgRequest);
		$this->mockStaticMethod('CreateWikiChecks','checkWikiNameIsCorrect','');

		$response = $app->sendRequest('CreateNewWiki', 'CheckWikiName');

		$this->assertEquals("", $response->getVal('res'));
	}
}
