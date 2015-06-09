<?php
class GlobalWatchlistBotTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = dirname(__FILE__) . "/../GlobalWatchlist.php";
		parent::setUp();
	}

	private function mockUser( $userName, $email) {
		$userMock = $this->mockClassWithMethods( 'User',
			[
				'isAnon' => true,
				'getName' => $userName,
				'getEmail' => $email,
				'getOption' => "en"
			]
		);

		return $userMock;
	}

	/**
	 * @group UsingDB
	 */
	public function testBlogsSection() {
		$bot = new GlobalWatchlistBot(true, [], []);
		$mail = $bot->composeMail($this->mockUser("test", "test@example.com"), [], false);
		$plaintext = $mail[0];
		$this->assertNotContains("No blog page found", $plaintext);
		$this->assertNotContains("list of blog pages", $plaintext);
	}

	/**
	 * Tests that the checkIfValidUser throws the expected exception when an invalid user
	 * object is passed in.
	 * @expectedException Exception
	 * @expectedExceptionMessage Invalid user object.
	 */
	public function testCheckIfValidUser() {
		$notAUserObject = new stdClass();

		$watchlistBot = new GlobalWatchlistBot();
		$reflection = new ReflectionClass( $watchlistBot );
		$checkIfValidUser = $reflection->getMethod( 'checkIfValidUser' );
		$checkIfValidUser->setAccessible( true );

		$checkIfValidUser->invoke( $watchlistBot, $notAUserObject );
	}

	/**
	 * Tests that the checkIfEmailUnsubscribed throws the expected exception when the user
	 * is unsubscribed from all email.
	 * @expectedException Exception
	 * @expectedExceptionMessage Email is unsubscribed.
	 */
	public function testCheckIfEmailUnSubscribed() {
		$userMock = $this->getMockBuilder( 'User' )
			->setMethods( [ 'getBoolOption' ] )
			->getMock();

		$userMock->expects( $this->once() )
			->method( 'getBoolOption' )
			->with( $this->equalTo( 'unsubscribed' ) )
			->will( $this->returnValue( true ) );

		$watchlistBot = new GlobalWatchlistBot();
		$reflection = new ReflectionClass( $watchlistBot );
		$checkIfEmailUnsubscribed = $reflection->getMethod( 'checkIfEmailUnsubscribed' );
		$checkIfEmailUnsubscribed->setAccessible( true );

		$checkIfEmailUnsubscribed->invoke( $watchlistBot, $userMock );
	}

	/**
	 * Tests that the checkIfEmailConfirmed throws the expected exception when the user
	 * does not have a confirmed email.
	 * @expectedException Exception
	 * @expectedExceptionMessage Email is not confirmed.
	 */
	public function testCheckIfEmailConfirmed() {
		$userMock = $this->getMockBuilder( 'User' )
			->setMethods( [ 'isEmailConfirmed' ] )
			->getMock();

		$userMock->expects( $this->once() )
			->method( 'isEmailConfirmed' )
			->will( $this->returnValue( false ) );

		$watchlistBot = new GlobalWatchlistBot();
		$reflection = new ReflectionClass( $watchlistBot );
		$checkIfEmailConfirmed = $reflection->getMethod( 'checkIfEmailConfirmed' );
		$checkIfEmailConfirmed->setAccessible( true );

		$checkIfEmailConfirmed->invoke( $watchlistBot, $userMock );
	}

	/**
	 * Tests that the checkIfSubscribedToWeeklyDigest throws the expected exception when the user
	 * is unsubscribed from the weekly digest.
	 * @expectedException Exception
	 * @expectedExceptionMessage Not subscribed to weekly digest
	 */
	public function testCheckIfSubscribedToWeeklyDigest() {
		$userMock = $this->getMockBuilder( 'User' )
			->setMethods( [ 'getBoolOption' ] )
			->getMock();

		$userMock->expects( $this->once() )
			->method( 'getBoolOption' )
			->with( $this->equalTo( 'watchlistdigest' ) )
			->will( $this->returnValue( false ) );

		$watchlistBot = new GlobalWatchlistBot();
		$reflection = new ReflectionClass( $watchlistBot );
		$checkIfSubscribedToWeeklyDigest = $reflection->getMethod( 'checkIfSubscribedToWeeklyDigest' );
		$checkIfSubscribedToWeeklyDigest->setAccessible( true );

		$checkIfSubscribedToWeeklyDigest->invoke( $watchlistBot, $userMock );
	}
}
