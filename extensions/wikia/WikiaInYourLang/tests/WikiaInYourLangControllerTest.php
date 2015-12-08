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

	public function getDomainsList() {
		return [
			['http://rio.wikia.com', 'rio.wikia.com'],
			['http://ru.rio.wikia.com', 'rio.wikia.com'],
			['http://zz.wikia.com', 'zz.wikia.com'],
			['http://ja.zz.wikia.com', 'zz.wikia.com'],
			['http://ru.rio.mari.wikia-dev.com', 'rio.wikia.com'],
			['http://destiny.mari.wikia-dev.com', 'destiny.wikia.com'],
			['http://ja.destiny.mari.wikia-dev.com', 'destiny.wikia.com'],
			['http://sandbox-s3.rio.wikia.com', 'rio.wikia.com'],
			['http://sandbox-s3.ru.rio.wikia.com', 'rio.wikia.com'],
			['http://sandbox-s3.zz.wikia.com', 'zz.wikia.com'],
			['http://verify.pt-br.123.wikia.com', '123.wikia.com'],
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
			['', false]
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
