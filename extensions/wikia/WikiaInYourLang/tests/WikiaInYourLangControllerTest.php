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
			['http://rio.sandbox-s3.wikia.com', 'rio.wikia.com'],
			['http://ru.rio.sandbox-s3.wikia.com', 'rio.wikia.com'],
			['http://zz.sandbox-s3.wikia.com', 'zz.wikia.com'],
			['http://pt-br.123.verify.wikia.com', '123.wikia.com'],
			['http://naruto.wikia.com', 'naruto.wikia.com'],
			['http://zh.naruto.wikia.com', 'naruto.wikia.com'],
			['http://pt-br.naruto.wikia.com', 'naruto.wikia.com'],
			['http://naruto.sandbox-s3.wikia.com', 'naruto.wikia.com'],
			['http://zh.naruto.sandbox-s3.wikia.com', 'naruto.wikia.com'],
			['http://pt-br.naruto.sandbox-s3.wikia.com', 'naruto.wikia.com'],
			['http://naruto.sandbox-mercury.wikia.com', 'naruto.wikia.com'],
			['http://zh.naruto.sandbox-mercury.wikia.com', 'naruto.wikia.com'],
			['http://pt-br.naruto.sandbox-mercury.wikia.com', 'naruto.wikia.com'],
			['http://naruto.sandbox-xw2.wikia.com', 'naruto.wikia.com'],
			['http://zh.naruto.sandbox-xw2.wikia.com', 'naruto.wikia.com'],
			['http://pt-br.naruto.sandbox-xw2.wikia.com', 'naruto.wikia.com'],
			['http://naruto.preview.wikia.com', 'naruto.wikia.com'],
			['http://zh.naruto.preview.wikia.com', 'naruto.wikia.com'],
			['http://pt-br.naruto.preview.wikia.com', 'naruto.wikia.com'],
			['http://naruto.verify.wikia.com', 'naruto.wikia.com'],
			['http://zh.naruto.verify.wikia.com', 'naruto.wikia.com'],
			['http://pt-br.naruto.verify.wikia.com', 'naruto.wikia.com'],
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
