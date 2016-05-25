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
	public function testCreateWikiSuccess( $testCase, $testData ) {
		$wikiName = 'Muppet is great';
		$wikiDomain = 'muppet';
		$wikiLanguage = 'en';
		$wikiVertical = '3';
		$wikiId = 322389;
		$wikiAnswer = 12345;
		$siteName = 'asdfasdf';
		$mainPageUrl = 'muppet.wikia.com/wiki/Main_page';

		$requestParams = array("wName" => $wikiName,
			"wDomain" => $wikiDomain,
			"wLanguage" => $wikiLanguage,
			"wVertical" => $wikiVertical,
			"wAnswer" => $wikiAnswer);

		$wgRequest = $this->getMock('WebRequest');
		$wgRequest->expects($this->any())
			->method('getArray')
			->will($this->returnValue($requestParams));

		$wgDevelDomains = array();

		$wgUser = $this->getMock( 'User', [ 'getId', 'isLoggedIn', 'isEmailConfirmed', 'getEditToken' ] );
		$wgUser->expects($this->any())
			->method('getId')
			->will($this->returnValue(6));
		$wgUser->expects($this->any())
			->method('isLoggedIn')
			->will($this->returnValue( $testData['userLogged'] ) );
		$wgUser->expects($this->any())
			->method('isEmailConfirmed')
			->will( $this->returnValue( $testData['userEmailConfirmed'] ) );
		$wgUser->expects( $this->any() )
			->method( 'getEditToken' )
			->will( $this->returnValue( $testData['userToken'] ) );

		$app = $this->getMock('WikiaApp', array('getGlobal', 'runFunction'));
		$app->expects( $this->any() )
			->method('getGlobal')
			->will($this->onConsecutiveCalls($wgRequest, $wgDevelDomains, $wgUser));

		$this->mockGlobalVariable( 'wgUser', $wgUser );

		$createWiki = $this->getMock('CreateWiki', array('create', 'getWikiInfo'), array(), '', false);
		$createWiki->expects($this->any())
			->method('create');
		$createWiki->expects($this->any())
			->method('getWikiInfo')
			->will($this->onConsecutiveCalls($wikiId, $siteName));

		$mainPageTitle = $this->getMock('GlobalTitle', array(), array(), '', false);
		$mainPageTitle->expects($this->any())
			->method('getFullURL')
			->will($this->returnValue($mainPageUrl));

		$this->mockClass('CreateWiki', $createWiki);
		$this->mockClass('GlobalTitle', $mainPageTitle, 'newFromText');

		$requestMock = $this->getMock( 'WikiaRequest', [ 'wasPosted' ], [ [ 'token' => $testData['requestToken'] ] ] );
		$requestMock->expects( $this->once() )
			->method( 'wasPosted' )
			->will( $this->returnValue( $testData['wasPosted'] ) );
		$response = new WikiaResponse( 'json', $requestMock );

		if ( !empty( $testData['expectedException'] ) ) {
			$this->setExpectedException( $testData['expectedException'] );
		}

		$createNewWikiController = new CreateNewWikiController();

		$createNewWikiController->setRequest( $requestMock );
		$createNewWikiController->setResponse( $response );
		$createNewWikiController->setApp( $app );

		$createNewWikiController->CreateWiki();

		$response = $createNewWikiController->getResponse();

		$this->assertEquals( $testData['status'], $response->getVal( 'status' ), $testCase );

		if ( $userLoggedIn && $userEmailConfirmed ) {
			$this->assertEquals($siteName, $response->getVal('siteName'));
			$this->assertEquals($mainPageUrl, $response->getval('finishCreateUrl'));
		}
	}

	public function getCreateWikiDataProvider() {
		return [
			[
				'testCase' => 'Everything is OK',
				'testData' => [
					'wasPosted' => true,
					'userToken' => '1234',
					'requestToken' => '1234',
					'userLogged' => true,
					'userEmailConfirmed' => true,
					'status' => 'ok',
					'expectedException' => false,
				],
			],
			[
				'testCase' => 'User logged-in but without confirmed e-mail',
				'testData' => [
					'wasPosted' => true,
					'userToken' => '1234',
					'requestToken' => '1234',
					'userLogged' => true,
					'userEmailConfirmed' => false,
					'status' => 'error',
					'expectedException' => false,
				],
			],
			[
				'testCase' => 'User not logged-in and therefore without confirmed e-mail',
				'testData' => [
					'wasPosted' => true,
					'userToken' => '1234',
					'requestToken' => '1234',
					'userLogged' => false,
					'userEmailConfirmed' => false,
					'status' => 'error',
					'expectedException' => false,
				],
			],
			[
				'testCase' => "Request wasn't POSTed",
				'testData' => [
					'wasPosted' => false,
					'userToken' => '1234',
					'requestToken' => '1234',
					'userLogged' => true,
					'userEmailConfirmed' => true,
					'status' => null,
					'expectedException' => 'BadRequestException',
				],
			],
			[
				'testCase' => "Invalid token provided",
				'testData' => [
					'wasPosted' => true,
					'userToken' => '1234',
					'requestToken' => '4321',
					'userLogged' => true,
					'userEmailConfirmed' => true,
					'status' => null,
					'expectedException' => 'BadRequestException',
				],
			],
			[
				'testCase' => "Request wasn't POSTed and invalid token provided",
				'testData' => [
					'wasPosted' => false,
					'userToken' => '1234',
					'requestToken' => '4321',
					'userLogged' => true,
					'userEmailConfirmed' => true,
					'status' => null,
					'expectedException' => 'BadRequestException',
				],
			],
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
