<?php

class WikiaInYourLangControllerTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../WikiaInYourLang.setup.php';
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
			['http://sandbox-s3.naruto.wikia.com', 'naruto.wikia.com'],
			['http://sandbox-s3.zh.naruto.wikia.com', 'naruto.wikia.com'],
			['http://sandbox-s3.pt-br.naruto.wikia.com', 'naruto.wikia.com'],
			['http://preview.naruto.wikia.com', 'naruto.wikia.com'],
			['http://preview.zh.naruto.wikia.com', 'naruto.wikia.com'],
			['http://preview.pt-br.naruto.wikia.com', 'naruto.wikia.com'],
			['http://verify.naruto.wikia.com', 'naruto.wikia.com'],
			['http://verify.zh.naruto.wikia.com', 'naruto.wikia.com'],
			['http://verify.pt-br.naruto.wikia.com', 'naruto.wikia.com'],
			['Just a random string', false],
		];
	}
}
