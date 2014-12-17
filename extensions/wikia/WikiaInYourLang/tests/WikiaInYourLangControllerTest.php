<?php

class WikiaInYourLangControllerTest extends WikiaBaseTest {

	public function setUp() {
		include_once __DIR__ . DIRECTORY_SEPARATOR
			. '..' . DIRECTORY_SEPARATOR
			. 'WikiaInYourLang.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider getDomainsList
	 */
	public function testGetWikiDomain( $sDomainToParse, $sParsedDomain ) {
		$oController = new WikiaInYourLangController();
		$this->assertEquals( $sParsedDomain, $oController->getWikiDomain( $sDomainToParse ) );
	}

	public function getDomainsList() {
		return [
			['http://naruto.wikia.com', 'naruto.wikia.com'],
			['http://zh.naruto.wikia.com', 'naruto.wikia.com'],
			['http://pt-br.naruto.wikia.com', 'naruto.wikia.com'],
			['http://zh.zh-pad.wikia.com', 'zh-pad.wikia.com'],
			['http://de.engelpedia.wikia.com', 'engelpedia.wikia.com'],
			['Just a random string', false],
		];
	}
}
