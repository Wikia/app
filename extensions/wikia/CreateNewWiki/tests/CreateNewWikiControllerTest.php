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
	public function testCreateWikiSuccess( $testCase, $userLoggedIn, $userEmailConfirmed, $status) {
		$wikiName = 'Muppet is great';
		$wikiDomain = 'muppet';
		$wikiLanguage = 'en';
		$wikiCategory = '3';
		$wikiId = 322389;
		$wikiAnswer = 12345;
		$siteName = 'asdfasdf';
		$mainPageUrl = 'muppet.wikia.com/wiki/Main_page';

		$requestParams = array("wName" => $wikiName,
			"wDomain" => $wikiDomain,
			"wLanguage" => $wikiLanguage,
			"wCategory" => $wikiCategory,
			"wAnswer" => $wikiAnswer);

		$wgRequest = $this->getMock('WebRequest');
		$wgRequest->expects($this->once())
			->method('getArray')
			->will($this->returnValue($requestParams));
		$wgDevelDomains = array();
		$wgUser = $this->getMock('User');
		$wgUser->expects($this->any())
			->method('getId')
			->will($this->returnValue(6));
		$wgUser->expects($this->once())
			->method('isLoggedIn')
			->will($this->returnValue($userLoggedIn));
		$wgUser->expects($this->any())
			->method('isEmailConfirmed')
			->will($this->returnValue($userEmailConfirmed));
		$app = $this->getMock('WikiaApp', array('getGlobal', 'runFunction'));
		$app->expects($this->exactly(3))
			->method('getGlobal')
			->will($this->onConsecutiveCalls($wgRequest, $wgDevelDomains, $wgUser));

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
		$this->mockClass('GlobalTitle', $mainPageTitle);

		$response = $app->sendRequest('CreateNewWiki', 'CreateWiki');

		$this->assertEquals($status, $response->getVal('status'), $testCase);

		if( $userLoggedIn && $userEmailConfirmed ) {
			$this->assertEquals($siteName, $response->getVal('siteName'));
			$this->assertEquals($mainPageUrl, $response->getval('finishCreateUrl'));
		}
	}

	public function getCreateWikiDataProvider() {
		return [
			[
				'testCase' => 'Everything is OK',
				'userLogged' => true,
				'userEmailConfirmed' => true,
				'status' => 'ok'
			],
			[
				'testCase' => 'User logged-in but without confirmed e-mail',
				'userLogged' => true,
				'userEmailConfirmed' => false,
				'status' => 'error'
			],
			[
				'testCase' => 'User not logged-in and therefore without confirmed e-mail',
				'userLogged' => false,
				'userEmailConfirmed' => false,
				'status' => 'error'
			]
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
		$this->mockStaticMethod('AutoCreateWiki','checkWikiNameIsCorrect','');

		$response = $app->sendRequest('CreateNewWiki', 'CheckWikiName');

		$this->assertEquals("", $response->getVal('res'));
	}
}
