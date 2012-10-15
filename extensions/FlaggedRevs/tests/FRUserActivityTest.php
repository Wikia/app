<?php

class FRUserActivityTest extends PHPUnit_Framework_TestCase {
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		global $wgMemc;
		parent::setUp();
		$this->user = User::newFromName( "someReviewer" );
		$wgMemc = wfGetCache( CACHE_DB );
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		parent::tearDown();
	}

	/**
	 * Constructs the test case.
	 */
	public function __construct() {}

	public function testPageIsUnderReview() {
		$page = 110;

		FRUserActivity::clearAllReviewingPage( $page ); // clear
		$this->assertEquals( false,
			FRUserActivity::pageIsUnderReview( $page ), "Not reviewing page" );

		FRUserActivity::setUserReviewingPage( $this->user, $page );

		$this->assertEquals( true,
			FRUserActivity::pageIsUnderReview( $page ), "Now reviewing page" );
	}

	public function testDiffIsUnderReview() {
		$oldid = 10910;
		$newid = 11910;

		FRUserActivity::clearAllReviewingDiff( $oldid, $newid ); // clear
		$this->assertEquals( false,
			FRUserActivity::diffIsUnderReview( $oldid, $newid ), "Not reviewing diff" );

		FRUserActivity::setUserReviewingDiff( $this->user, $oldid, $newid );

		$this->assertEquals( true,
			FRUserActivity::diffIsUnderReview( $oldid, $newid ), "Now reviewing diff" );
	}

	public function testGetUserReviewingPage() {
		$page = 110;

		FRUserActivity::clearAllReviewingPage( $page ); // clear
		$this->assertEquals( array( null, null ),
			FRUserActivity::getUserReviewingPage( $page ),
			"Not reviewing page" );

		$now1 = time();
		FRUserActivity::setUserReviewingPage( $this->user, $page );
		$now2 = time();

		list($name, $ts) = FRUserActivity::getUserReviewingPage( $page );
		$this->assertEquals( $this->user->getName(), $name,
			"Now reviewing page (name matches)" );
		$this->assertGreaterThanOrEqual( $now1, wfTimestamp( TS_UNIX, $ts ),
			"Now reviewing page (timestamp matches)" );
		$this->assertLessThanOrEqual( $now2, wfTimestamp( TS_UNIX, $ts ),
			"Now reviewing page (timestamp matches)" );
	}

	public function testGetUserReviewingDiff() {
		$oldid = 10910;
		$newid = 11910;

		FRUserActivity::clearAllReviewingDiff( $oldid, $newid ); // clear
		$this->assertEquals( array( null, null ),
			FRUserActivity::getUserReviewingDiff( $oldid, $newid ),
			"Not reviewing diff" );

		$now1 = time();
		FRUserActivity::setUserReviewingDiff( $this->user, $oldid, $newid );
		$now2 = time();

		list($name, $ts) = FRUserActivity::getUserReviewingDiff( $oldid, $newid );
		$this->assertEquals( $this->user->getName(), $name,
			"Now reviewing diff (name matches)" );
		$this->assertGreaterThanOrEqual( $now1, wfTimestamp( TS_UNIX, $ts ),
			"Now reviewing diff (timestamp matches)" );
		$this->assertLessThanOrEqual( $now2, wfTimestamp( TS_UNIX, $ts ),
			"Now reviewing diff (timestamp matches)" );
	}

	public function testUserReviewingPage() {
		$page = 910;

		FRUserActivity::clearAllReviewingPage( $page ); // clear
		$this->assertEquals( true,
			FRUserActivity::setUserReviewingPage( $this->user, $page ),
			"Set reviewing page succeeds" );
		
		$this->assertEquals( true,
			FRUserActivity::clearUserReviewingPage( $this->user, $page ),
			"Unset reviewing page" );
		$this->assertEquals( false,
			FRUserActivity::clearUserReviewingPage( $this->user, $page ),
			"Extra unset reviewing page" );

		// set two instances...
		$this->assertEquals( true,
			FRUserActivity::setUserReviewingPage( $this->user, $page ),
			"Set reviewing page (1)" );
		$this->assertEquals( true,
			FRUserActivity::setUserReviewingPage( $this->user, $page ),
			"Set reviewing page (2)" );
		// clear both...
		$this->assertEquals( true,
			FRUserActivity::clearUserReviewingPage( $this->user, $page ),
			"Unset reviewing page (1)" );
		$this->assertEquals( true,
			FRUserActivity::clearUserReviewingPage( $this->user, $page ),
			"Unset reviewing page (2)" );
		// extra clears...
		$this->assertEquals( false,
			FRUserActivity::clearUserReviewingPage( $this->user, $page ),
			"Extra unset reviewing page" );
	}

	public function testUserReviewingDiff() {
		$oldid = 12910;
		$newid = 15910;

		FRUserActivity::clearAllReviewingDiff( $oldid, $newid ); // clear
		$this->assertEquals( true,
			FRUserActivity::setUserReviewingDiff( $this->user, $oldid, $newid ),
			"Set reviewing page succeeds" );

		$this->assertEquals( true,
			FRUserActivity::clearUserReviewingDiff( $this->user, $oldid, $newid ),
			"Unset reviewing page" );
		$this->assertEquals( false,
			FRUserActivity::clearUserReviewingDiff( $this->user, $oldid, $newid ),
			"Extra unset reviewing page" );

		// set two instances...
		$this->assertEquals( true,
			FRUserActivity::setUserReviewingDiff( $this->user, $oldid, $newid ),
			"Set reviewing page (1)" );
		$this->assertEquals( true,
			FRUserActivity::setUserReviewingDiff( $this->user, $oldid, $newid ),
			"Set reviewing page (2)" );
		// clear both...
		$this->assertEquals( true,
			FRUserActivity::clearUserReviewingDiff( $this->user, $oldid, $newid ),
			"Unset reviewing page (1)" );
		$this->assertEquals( true,
			FRUserActivity::clearUserReviewingDiff( $this->user, $oldid, $newid ),
			"Unset reviewing page (2)" );
		// extra clears...
		$this->assertEquals( false,
			FRUserActivity::clearUserReviewingDiff( $this->user, $oldid, $newid ),
			"Extra unset reviewing page" );
	}
}
