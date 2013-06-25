<?php

class CreateNewWikiControllerTest extends WikiaBaseTest {

	public function __construct() {
		$this->setupFile = dirname(__FILE__) . '/../CreateNewWiki_setup.php';
	}
	
	/**
	 * @group hyun
	 */
	public function testCreateWikiSuccess() {
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
		$wgUser->expects($this->once())
			->method('getId')
			->will($this->returnValue(6));
		$app = $this->getMock('WikiaApp', array('getGlobal', 'runFunction'));
		$app->expects($this->exactly(3))
			->method('getGlobal')
			->will($this->onConsecutiveCalls($wgRequest, $wgDevelDomains, $wgUser));

		$createWiki = $this->getMock('CreateWiki', array('create', 'getWikiInfo'), array(), '', false);
		$createWiki->expects($this->once())
			->method('create');
		$createWiki->expects($this->exactly(2))
			->method('getWikiInfo')
			->will($this->onConsecutiveCalls($wikiId, $siteName));

		$mainPageTitle = $this->getMock('GlobalTitle', array(), array(), '', false);
		$mainPageTitle->expects($this->once())
			->method('getFullURL')
			->will($this->returnValue($mainPageUrl));

		$this->mockClass('CreateWiki', $createWiki);
		$this->mockClass('GlobalTitle', $mainPageTitle);

		$response = $app->sendRequest('CreateNewWiki', 'CreateWiki');

		$this->assertEquals("ok", $response->getVal('status'));
		$this->assertEquals($siteName, $response->getVal('siteName'));
		$this->assertEquals($mainPageUrl, $response->getval('finishCreateUrl'));

	}

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