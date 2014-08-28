<?php
class WikiaInteractiveMapsMapControllerTest extends WikiaBaseTest {

	public function testGetOriginFromProdUrl() {
		$prodUrl = 'http://mediawiki119.wikia.com/Special:Maps';
		$validParsedUrl = 'http://mediawiki119.wikia.com'
		$parsedUrl = WikiaInteractiveMapsMapController::getOriginFromUrl( $prodUrl );
		$this->assertEquals( $validParsedUrl, $parsedUrl );
	}

	public function testGetOriginFromDevUrl() {
		$devUrl = 'http://mediawiki119.devbox.wikia-dev.com/Special:Maps?param=value';
		$validParsedUrl = 'http://mediawiki119.wikia.com'
		$parsedUrl = WikiaInteractiveMapsMapController::getOriginFromUrl( $devUrl );
		$this->assertEquals( $validParsedUrl, $parsedUrl );
	}

}
