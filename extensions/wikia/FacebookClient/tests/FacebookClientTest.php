<?
class FacebookClientTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile =  __DIR__ . '/../FacebookClient.setup.php';
		parent::setUp();
	}

	public function testGetReturnToUrl() {
		$cb = '123';
		$actualQueryString = '&fbconnected=1&cb=' . $cb;

		// test title w/o query string
		$testUrl = FacebookClient::getInstance()->getReturnToUrl( 'Foo', '', $cb );
		$titleObj = Title::newFromText( 'Foo' );
		$actualUrl = $titleObj->getFullUrl( $actualQueryString );
		$this->assertEquals( $testUrl, $actualUrl );

		// test title w/ query string
		$testQueryString = 'foo=bar';
		$testUrl = FacebookClient::getInstance()->getReturnToUrl( 'Foo', $testQueryString, $cb );
		$titleObj = Title::newFromText( 'Foo' );
		$actualUrl = $titleObj->getFullUrl( $testQueryString . $actualQueryString );
		$this->assertEquals( $testUrl, $actualUrl );

		// test forbidden return-to page w/o query string
		$testUrl = FacebookClient::getInstance()->getReturnToUrl( 'Special:Signup', '', $cb );
		$titleObj = Title::newMainPage();
		$actualUrl = $titleObj->getFullUrl( $actualQueryString );
		$this->assertEquals( $testUrl, $actualUrl );

		// test forbidden return-to page w/ query string
		$testQueryString = 'foo=bar';
		$testUrl = FacebookClient::getInstance()->getReturnToUrl( 'Special:UserLogout', $testQueryString, $cb );
		$titleObj = Title::newMainPage();
		// Note, $testQueryString is ignored b/c we're redirecting to the main page
		$actualUrl = $titleObj->getFullUrl( $actualQueryString );
		$this->assertEquals( $testUrl, $actualUrl );

		// test special characters in title and querystring
		$testQueryString = 'foò=bär';
		$testUrl = FacebookClient::getInstance()->getReturnToUrl( 'Foo', $testQueryString, $cb );
		$titleObj = Title::newFromText( 'Foo' );
		$actualUrl = $titleObj->getFullUrl( $testQueryString . $actualQueryString );
		$this->assertEquals( $testUrl, $actualUrl );
	}
}