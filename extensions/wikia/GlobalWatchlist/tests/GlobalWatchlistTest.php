<?php

require_once "includes/GlobalFunctions.php";
require_once dirname( __FILE__ ) . "/../GlobalWatchlist.php";
require_once dirname( __FILE__ ) . "/../GlobalWatchlist.bot.php";
require_once dirname( __FILE__ ) . "/../GlobalWatchlist.i18n.php";


class GlobalWatchlistBotTest extends WikiaBaseTest {
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

	public function testBlogsSection() {
		$user = $this->mockUser("test", "test@example.com", false);
		$bot = new GlobalWatchlistBot(true, array($user), array());
		$digests = array();
		$mail = $bot->composeMail($user, $digests, false);
		print_r($mail);
    
	}

}
