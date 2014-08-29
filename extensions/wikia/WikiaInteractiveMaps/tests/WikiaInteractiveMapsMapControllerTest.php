<?php
class WikiaInteractiveMapsMapControllerTest extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->setupFile = "$IP/extensions/wikia/WikiaInteractiveMaps/WikiaInteractiveMaps.setup.php";
		parent::setUp();
	}

	public function testGetOriginFromProdUrl() {
		$prodUrl = 'http://mediawiki119.wikia.com/Special:Maps';
		$validParsedUrl = 'http://mediawiki119.wikia.com';
		$parsedUrl = WikiaInteractiveMapsMapController::getOriginFromUrl( $prodUrl );
		$this->assertEquals( $validParsedUrl, $parsedUrl );
	}

	public function testGetOriginFromSandboxUrl() {
		$sandboxUrl = 'http://sandbox-qa01.mediawiki119.wikia.com/Special:Maps';
		$validParsedUrl = 'http://mediawiki119.wikia.com';
		$parsedUrl = WikiaInteractiveMapsMapController::getOriginFromUrl( $sandboxUrl );
		$this->assertEquals( $validParsedUrl, $parsedUrl );
	}

	public function testGetOriginFromPreviewUrl() {
		$previewUrl = 'http://preview.mediawiki119.wikia.com/Special:Maps';
		$validParsedUrl = 'http://mediawiki119.wikia.com';
		$parsedUrl = WikiaInteractiveMapsMapController::getOriginFromUrl( $previewUrl );
		$this->assertEquals( $validParsedUrl, $parsedUrl );
	}

	public function testGetOriginFromVerifyUrl() {
		$verifyUrl = 'http://verify.mediawiki119.wikia.com/Special:Maps';
		$validParsedUrl = 'http://mediawiki119.wikia.com';
		$parsedUrl = WikiaInteractiveMapsMapController::getOriginFromUrl( $verifyUrl );
		$this->assertEquals( $validParsedUrl, $parsedUrl );
	}

	public function testGetOriginFromDevUrl() {
		$devUrl = 'http://mediawiki119.devbox.wikia-dev.com/Special:Maps?param=value';
		$validParsedUrl = 'http://mediawiki119.devbox.wikia-dev.com';
		$parsedUrl = WikiaInteractiveMapsMapController::getOriginFromUrl( $devUrl );
		$this->assertEquals( $validParsedUrl, $parsedUrl );
	}

}
