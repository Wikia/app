<?php
require_once dirname(__FILE__) . '/../CreateNewWikiModule.class.php';

class CreateNewWikiModuleTest extends PHPUnit_Framework_TestCase {

	protected function setUp() {
		$this->originalApp = F::build('App');
	}

	protected function tearDown() {
		F::setInstance('App', $this->originalApp);
		F::unsetInstance('CreateWiki');
		F::unsetInstance('GlobalTitle');
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
		$siteName = 'asdfasdf';
		$mainPageUrl = 'muppet.wikia.com/wiki/Main_page';

		$requestParams = array("wikiaName" => $wikiName,
			"wikiaDomain" => $wikiDomain,
			"wikiaLanguage" => $wikiLanguage,
			"wikiaCategory" => $wikiCategory);

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

		F::setInstance('CreateWiki', $createWiki);
		F::setInstance('GlobalTitle', $mainPageTitle);

		$wgUser = $this->getMock('User');

		$cnwModule = $this->getMock( 'CreateNewWikiModule', array( 'countCreatedWikis' ), array($app) );
		/*
		$cnwModule->expects($this->once())
			->method('countCreatedWikis')
			->with($this->equalTo(6))
			->will($this->returnValue(1));
		*/
		$cnwModule->executeCreateWiki();

		$this->assertEquals("ok", $cnwModule->status);
		$this->assertEquals($siteName, $cnwModule->siteName);
		$this->assertEquals($mainPageUrl, $cnwModule->finishCreateUrl);

	}

	public function testCheckWikiNameSuccess() {

		$wikiName = 'muppet';
		$wikiLang = 'en';

		$wgRequest = $this->getMock('WebRequest');
		$wgRequest->expects($this->exactly(2))
			->method('getVal')
			->will($this->onConsecutiveCalls($wikiName, $wikiLang));

		$app = $this->getMock('WikiaApp', array('getGlobal', 'runFunction'));
		$app->expects($this->once())
			->method('getGlobal')
			->with($this->equalTo('wgRequest'))
			->will($this->returnValue($wgRequest));
		$app->expects($this->once())
			->method('runFunction')
			->with($this->equalTo('AutoCreateWiki::checkWikiNameIsCorrect'), $this->equalTo($wikiName), $this->equalTo($wikiLang))
			->will($this->returnValue(""));

		$cnwModule = new CreateNewWikiModule($app);

		$cnwModule->executeCheckWikiName();

		$this->assertEquals("", $cnwModule->res);
	}

}