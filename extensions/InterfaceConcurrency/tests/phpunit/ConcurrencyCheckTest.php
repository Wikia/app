<?php

class ConcurrencyCheckTest extends MediaWikiTestCase {
	/**
	 * @var Array of test users
	 */
	public static $users;

	// Prepare test environment

	public function setUp() {
		parent::setUp();

		self::$users = array(
			'user1' => new ApiTestUser(
				'Concurrencychecktestuser1',
				'ConcurrencyCheck Test User 1',
				'concurrency_check_test_user_1@example.com',
				array()
			),
			'user2' => new ApiTestUser(
				'Concurrencychecktestuser2',
				'ConcurrencyCheck Test User 2',
				'concurrency_check_test_user_2@example.com',
				array()
			),
		);

		// turn on memcached for this test.
		// if no memcached is present, this still works fine.
		global $wgMainCacheType, $wgInterfaceConcurrencyConfig;
		$this->oldcache = $wgMainCacheType;
		$wgMainCacheType = CACHE_MEMCACHED;
		// negative numbers are needed for testing
		$wgInterfaceConcurrencyConfig['ExpirationMin'] = -60;
	}

	public function tearDown() {
		// turn off caching again.
		global $wgMainCacheType;
		$wgMainCacheType = $this->oldcache;

		parent::tearDown();
	}

	// Actual tests from here down

	public function testCheckoutCheckin() {
		$first = new ConcurrencyCheck( 'CCUnitTest',  self::$users['user1']->user );
		$second = new ConcurrencyCheck( 'CCUnitTest',  self::$users['user2']->user );
		$firstId = self::$users['user1']->user->getId();
		$secondId = self::$users['user2']->user->getId();
		
		$testKey = 1337;

		// clean up after any previously failed tests
		$first->checkin( $testKey );
		$second->checkin( $testKey );

		// tests
		$this->assertTrue( $first->checkout( $testKey ), "Initial checkout" );
		$res = $first->checkoutResult();
		$this->assertEquals( $firstId, $res['userId'], "User matches on success");
		$this->assertTrue( array_key_exists( 'expiration', $res ), "Expiration is present");
		$this->assertTrue( $res['expiration'] > 0, "Expiration is a positive integer");

		$this->assertTrue( $first->checkout( $testKey ), "Cache hit" );

		global $wgMemc;
		$cacheKey = wfMemcKey( 'concurrencycheck', 'CCUnitTest', $testKey );
		$wgMemc->delete($cacheKey);
		$first->lastCheckout = array();
		$this->assertTrue( $first->checkout( $testKey ), "Cache miss" );
		$res = $first->checkoutResult();
		$this->assertEquals( $firstId, $res['userId'], "User matches on success (nocache)");
		$this->assertTrue( array_key_exists( 'expiration', $res ), "Expiration is present (nocache)");
		$this->assertTrue( $res['expiration'] > 0, "Expiration is a positive integer (nocache)");
		
		$this->assertFalse(
			$second->checkout( $testKey ),
			"Checkout of locked resource fails as different user"
		);
		$res = $second->checkoutResult();
		$this->assertEquals( $firstId, $res['userId'], "Actual owner matches on failure");
		$this->assertTrue( $res['expiration'] > 0, "Expiration is a positive integer");
		
		$this->assertTrue(
			$first->checkout( $testKey ),
			"Checkout of locked resource succeeds as original user"
		);
		$this->assertFalse(
			$second->checkin( $testKey ),
			"Checkin of locked resource fails as different user"
		);
		$this->assertTrue(
			$first->checkin( $testKey ),
			"Checkin of locked resource succeeds as original user"
		);
		$second->setExpirationTime( -5 );
		$this->assertTrue(
			$second->checkout( $testKey ),
			"Checked-in resource is now available to second user"
		);
		$second->setExpirationTime();
		$this->assertTrue(
			$first->checkout( $testKey ),
			"Checkout of expired resource succeeds as first user"
		);
		$this->assertTrue( $second->checkout( $testKey, true ), "Checkout override" );
		$this->assertFalse(
			$first->checkout( $testKey ),
			"Checkout of overriden resource fails as different user"
		);

		// cleanup
		$this->assertTrue(
			$second->checkin( $testKey ),
			"Checkin of record with changed ownership"
		);

	}

	public function testExpire() {
		$cc = new ConcurrencyCheck( 'CCUnitTest',  self::$users['user1']->user );
		$cc->setExpirationTime( -1 );
		$cc->checkout( 1338 );  // these numbers are test record ids.
		$cc->checkout( 1339 );
		$cc->setExpirationTime();
		$cc->checkout( 13310 );

		// tests
		$this->assertEquals( 2, $cc->expire(), "Resource expiration" );
		$this->assertTrue( $cc->checkin( 13310 ), "Checkin succeeds after expiration" );
	}

	public function testStatus() {
		$cc = new ConcurrencyCheck( 'CCUnitTest',  self::$users['user1']->user );
		$cc->checkout( 1337 );
		$cc->checkout( 1338 );
		$cc->setExpirationTime( -5 );
		$cc->checkout( 1339 );
		$cc->setExpirationTime();

		// tests
		$output = $cc->status( array( 1337, 1338, 1339, 13310 ) );
		$this->assertEquals( true, is_array( $output ), "Status returns values" );
		$this->assertEquals( 4, count( $output ), "Output has the correct number of records" );
		$this->assertEquals(
			'valid',
			$output[1337]['status'],
			"Current checkouts are listed as valid"
		);
		$this->assertEquals(
			'invalid',
			$output[1339]['status'],
			"Expired checkouts are invalid"
		);
		$this->assertEquals(
			'invalid',
			$output[13310]['status'],
			"Missing checkouts are invalid"
		);
	}
	
	public function testListCheckouts() {
		$cc = new ConcurrencyCheck( 'CCUnitTest',  self::$users['user1']->user );
		$cc->checkout( 1337 );
		$cc->checkout( 1338 );

		$output = $cc->listCheckouts();
		$this->assertTrue( $output[1337] && $output[1338], "Current checkouts are present" );
		$this->assertEquals(
			self::$users['user1']->user->getId(),
			$output[1337]['cc_user'],
			"User matches"
		);
		$this->assertTrue(
			array_key_exists( 'cc_expiration', $output[1337] ),
			"Expiration exists"
		);
		$this->assertTrue( $output[1337]['mine'], "Ownership flag set" );
	}
}
