<?php

class ShareButtonsTest extends WikiaBaseTest {
	
	public function setUp() {
		$this->setupFile = dirname(__FILE__) . '/../ShareButtons.setup.php';

		parent::setUp();

		$this->mockGlobalVariable('wgTitle', Title::newMainPage());
	}

	public function testFactoryWithDefaults() {
		$facebook = ShareButton::factory( 'Facebook' );
		$this->assertInstanceOf('ShareButtonFacebook', $facebook);
		
		$titleRefl = new ReflectionProperty( 'ShareButton', 'title' );
		$titleRefl->setAccessible( true );
		
		$this->assertEquals(
				Title::newMainPage(),
				$titleRefl->getValue( $facebook )
		);
	}
	
	public function testFactoryWithTitle() {
		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		
		$twitter = ShareButton::factory( 'Twitter', $mockTitle );
		$this->assertInstanceOf('ShareButtonTwitter', $twitter);
		
		$titleRefl = new ReflectionProperty( 'ShareButton', 'title' );
		$titleRefl->setAccessible( true );
		$titleResult = $titleRefl->getValue( $twitter );
		
		$this->assertEquals(
				$mockTitle,
				$titleResult
		);
		$this->assertNotEquals(
				Title::newMainPage(),
				$titleResult
		);
	}

	public function testFacebookShareBox() {
		$facebook = ShareButton::factory( 'Facebook' );

		$box = $facebook->getShareBox();
		$url = $this->app->wg->Title->getFullUrl();

		$this->assertContains('class="fb-like"', $box);
		$this->assertContains('data-layout="box_count"', $box);
		$this->assertContains('data-href="' . htmlspecialchars($url) . '"', $box);
	}

	public function testTwitterShareBox() {
		$twitter = ShareButton::factory( 'Twitter' );

		$box = $twitter->getShareBox();
		$url = $this->app->wg->Title->getFullUrl();

		$this->assertContains('class="twitter-share-button"', $box);
		$this->assertContains('data-count="vertical"', $box);
		$this->assertContains('data-url="' . htmlspecialchars($url) . '"', $box);
	}

	public function testGooglePlusShareBox() {
		$googleplus = ShareButton::factory( 'GooglePlus' );

		$box = $googleplus->getShareBox();
		$url = $this->app->wg->Title->getFullUrl();

		$this->assertContains('class="g-plusone"', $box);
		$this->assertContains('data-size="tall"', $box);
		$this->assertContains('data-href="' . htmlspecialchars($url) . '"', $box);
	}
	
	public function testUrlSpecialCharsAreEncoded() {
		$mockTitle = $this->getMockBuilder( 'Title' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		
		$titleUrlString = "/wiki/Par\x8ent_Page?/This_is_a_t\x8est!";
		
		$mockTitle
		    ->expects    ( $this->any() )
		    ->method     ( 'getLocalUrl' )
		    ->will       ( $this->returnValue( $titleUrlString ) )
		;
		$mockTitle
		    ->expects    ( $this->any() )
		    ->method     ( 'getFullUrl' )
		    ->will       ( $this->returnValue( 'http://foo.wikia.com' . $titleUrlString ) )
		;
		
		$this->mockGlobalVariable('wgServer', 'http://foo.wikia.com' );
	    $this->mockGlobalVariable('wgTitle', $mockTitle);
	    $twitter = ShareButton::factory( 'Twitter' );
	    
        $getUrl = new ReflectionMethod( 'ShareButton', 'getUrl' );
        $getUrl->setAccessible( true );
        $getUrlString = $getUrl->invoke( $twitter );
        
	    $this->assertContains(
	    		"/wiki/Par%8Ent_Page%3F/This_is_a_t%8Est%21",
	    		$getUrlString,
	    		'An instance of ShareButton should URL-encode path names.'
		);
	    
	}

}
