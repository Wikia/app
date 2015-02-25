<?php
class GlobalWatchlistBotTest extends WikiaBaseTest {
  public function setUp() { 
    $this->setupFile = dirname(__FILE__) . "/../GlobalWatchlist.php";
    parent::setUp();
  } 
	private function mockUser( $userName, $email) {
		$userMock = $this->mockClassWithMethods( 'User',
		  array(
		    'isAnon' => true,
	 	    'getName' => $userName,
	 	    'getEmail' => $email,
	 	    'getOption' => "en"
	 	  )
	  );
	
  	return $userMock;
	}

	/**
	 * @group UsingDB
	 */
	public function testBlogsSection() {
		$bot = new GlobalWatchlistBot(true, array(), array());
		$mail = $bot->composeMail($this->mockUser("test", "test@example.com"), array(), false);
		$plaintext = $mail[0];
		$this->assertNotContains("No blog page found", $plaintext);
		$this->assertNotContains("list of blog pages", $plaintext);
	}
}
