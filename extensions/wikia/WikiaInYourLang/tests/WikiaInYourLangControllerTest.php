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
		$oController->response = $this->getMock( 'WikiaResponse', [], [ 'json' ] );
		$this->assertSame( $sParsedDomain, $oController->getWikiDomain( $sDomainToParse ) );
	}

	/**
	 * @dataProvider getLanguagesList
	 */
	public function testGetLanguageCore( $sFullLanguageCode, $sLanguageCore ) {
		$oController = new WikiaInYourLangController();
		$this->assertSame( $sLanguageCore, $oController->getLanguageCore( $sFullLanguageCode ) );
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

	public function getLanguagesList() {
		return [
			['en', 'en'],
			['be-tarask', 'be'],
			['crh-latin', 'crh'],
			['crh-cyrl', 'crh'],
			['zh', 'zh'],
			['zh-classical', 'zh'],
			['zh-cn', 'zh'],
		];
	}
}
