<?php

/**
 * Class EmailIntegrationTest
 *
 * @group Integration
 */
class EmailIntegrationTest extends WikiaBaseTest {
	function setUp() {
		$this->setupFile = __DIR__ . '/../Email.setup.php';
		include_once( __DIR__ . '/../../../../includes/HttpFunctions.php');
		parent::setUp();
	}

	/**
	 * We've hard-coded some image URLs into the HTML emails, so let's make sure they are where we expect them to be
	 *
	 * @param string $name Image identifier
	 * @param string $url URL for accessing image
	 * @dataProvider emailImagesDataProvider
	 */
	public function testEmailImages( $name, $url ) {
		$response = HTTP::get( $url );
		$this->assertTrue($response !== false, "{$name} should return HTTP 200");
	}

	public function emailImagesDataProvider() {
		return [
			['wikia image', 'http://vignette3.wikia.nocookie.net/wikianewsletter/images/8/89/Wikia.gif/revision/latest?cb=20150330185243'],
			['fans image', 'http://vignette1.wikia.nocookie.net/wikianewsletter/images/1/17/Fans-by-Fans.gif/revision/latest?cb=20150330215152'],
			['comics image', 'http://vignette1.wikia.nocookie.net/wikianewsletter/images/e/e3/Comics.gif/revision/latest?cb=20150330185129'],
			['games image', 'http://vignette1.wikia.nocookie.net/wikianewsletter/images/e/e8/Games.gif/revision/latest?cb=20150330185144'],
			['movies image', 'http://vignette1.wikia.nocookie.net/wikianewsletter/images/b/bf/Movies.gif/revision/latest?cb=20150330185202'],
			['lifestyle image', 'http://vignette4.wikia.nocookie.net/wikianewsletter/images/6/60/Lifestyle.gif/revision/latest?cb=20150330185152'],
			['music image', 'http://vignette4.wikia.nocookie.net/wikianewsletter/images/f/fb/Music.gif/revision/latest?cb=20150330185211'],
			['books image', 'http://vignette4.wikia.nocookie.net/wikianewsletter/images/c/c2/Books.gif/revision/latest?cb=20150330185117'],
			['tv image', 'http://vignette1.wikia.nocookie.net/wikianewsletter/images/c/c5/TV.gif/revision/latest?cb=20150330185219'],
			['twitter image', 'http://vignette3.wikia.nocookie.net/wikianewsletter/images/8/88/Twitter.gif/revision/latest?cb=20150330185235'],
			['youtube image', 'http://vignette4.wikia.nocookie.net/wikianewsletter/images/1/12/You-Tube.gif/revision/latest?cb=20150330185252'],
			['facebook image', 'http://vignette2.wikia.nocookie.net/wikianewsletter/images/a/ad/Facebook.gif/revision/latest?cb=20150330185226'],
		];
	}
}
