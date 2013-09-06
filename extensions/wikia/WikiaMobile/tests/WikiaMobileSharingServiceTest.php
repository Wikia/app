<?php
//Warning: If you break the tests contained in this file, please contact the Mobile Team. Thanks.

/**
 * Test for Class WikiaMobileSharingServiceTest
 */
class WikiaMobileSharingServiceTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = dirname(__FILE__) . '/../WikiaMobileSharingService.class.php';
		parent::setUp();
	}

	const MESSAGE = '|MESSAGE|';
	const URL = '|URL|';
	const LANGUAGE = '|LANG|';

	function testNetworks(){
		global $wgLang;

		$app = F::app();
		$passedChecks = 0;
		$networks = array(
			'facebook' => array( 'FacebookSharing', 'http://www.facebook.com/sharer.php?u=$1&t=$2' ),
			'twitter' => array( 'TwitterSharing', 'http://twitter.com/home?status=$1%20$2' ),
			'plusone' => array( 'PlusoneSharing', 'https://plus.google.com/share?hl=$lang&url=$1' ),
			'email' => array( 'EmailSharing', 'mailto:?body=$2%20$1' )
		);

		//mock Language::getCode and override wgLang
		$origLang = $wgLang;
		$lang = $this->getMock( 'Language' );
        $lang->expects( $this->any() )
             ->method( 'getCode' )
             ->will( $this->returnValue( self::LANGUAGE ) );

		$app->wg->set( 'wgLang', $lang );

		//making sure the mock works as expected
		$this->assertEquals( self::LANGUAGE, $app->wg->Lang->getCode() );

		/**
		 * @var $data SocialSharing[]
		 */
		$data = $app->sendRequest( 'WikiaMobileSharingService' )->getVal( 'networks' );

		$this->assertTrue( is_array( $data ) );
		$this->assertEquals( count( $networks ), count( $data ) );

		foreach( $data as $n ) {
			$this->assertInstanceOf( 'SocialSharing', $n );
			$this->assertTrue( method_exists( $n, 'getId' ) );
			$this->assertTrue( method_exists( $n, 'getUrl' ) );

			$id = $n->getId();

			$this->assertArrayHasKey( $id, $networks );

			$expected = $networks[$id];

			$this->assertInstanceOf( $expected[0], $n );
			$this->assertEquals(
				str_replace( array( '$1', '$2', '$lang' ), array( self::URL, urlencode( self::MESSAGE ), self::LANGUAGE ), $expected[1] ),
				$n->getUrl( self::URL, self::MESSAGE )
			);

			$passedChecks++;
		}

		$this->assertEquals( count( $networks ), $passedChecks );

		//restore for upcoming test
		$wgLang = $origLang;

		//make sure wgLang is restored
		$this->assertNotEquals( $lang, $app->wg->Lang );
	}
}
