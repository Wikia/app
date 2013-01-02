<?php

class ShareButtonsTest extends WikiaBaseTest {
	
	public function setUp() {
		$this->setupFile = dirname(__FILE__) . '/../ShareButtons.setup.php';

		parent::setUp();

		$this->mockGlobalVariable('wgTitle', Title::newMainPage());
		$this->mockApp();
	}

	public function testFactory() {
		$facebook = F::build('ShareButton', array('app' => $this->app, 'id' => 'Facebook'), 'factory');
		$this->assertInstanceOf('ShareButtonFacebook', $facebook);
	}

	public function testFacebookShareBox() {
		$facebook = F::build('ShareButton', array('app' => $this->app, 'id' => 'Facebook'), 'factory');

		$box = $facebook->getShareBox();
		$url = $this->app->wg->Title->getFullUrl();

		$this->assertContains('class="fb-like"', $box);
		$this->assertContains('data-layout="box_count"', $box);
		$this->assertContains('data-href="' . htmlspecialchars($url) . '"', $box);
	}

	public function testTwitterShareBox() {
		$twitter = F::build('ShareButton', array('app' => $this->app, 'id' => 'Twitter'), 'factory');

		$box = $twitter->getShareBox();
		$url = $this->app->wg->Title->getFullUrl();

		$this->assertContains('class="twitter-share-button"', $box);
		$this->assertContains('data-count="vertical"', $box);
		$this->assertContains('data-url="' . htmlspecialchars($url) . '"', $box);
	}

	public function testGooglePlusShareBox() {
		$googleplus = F::build('ShareButton', array('app' => $this->app, 'id' => 'GooglePlus'), 'factory');

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
		
		$titleUrlString = '/wiki/ParŽnt_Page?/This_is_a_tŽst!';
		
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
	    $this->mockApp();
	    $twitter = F::build('ShareButton', array('app' => $this->app, 'id' => 'Twitter'), 'factory');
	    
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
