<?php

namespace Wikia\Service\User\Preferences;

use Doctrine\Common\Cache\CacheProvider;
use Wikia\DependencyInjection\Injector;
use Wikia\Persistence\User\Preferences\PreferencePersistence;
use PHPUnit_Framework_TestCase;

class UserPreferencesIntegrationTest extends PHPUnit_Framework_TestCase {
	/**
	 * @var string
	 */
	protected $testUserName;

	/**
	 * @var int
	 */
	protected $testUserId;

	/**
	 * @var PreferenceService
	 */
	protected $preferenceServiceCached;

	/**
	 * @var PreferenceService
	 */
	protected $preferenceServiceUnCached;

	/**
	 * @var string
	 */
	const TEST_PREFERENCE_NAME = "hidepatrolled";

	/**
	 * @param bool $ignoreCache should we return not cached PreferenceService instance
	 * @return PreferenceService
	 */
	private function getUserPreferences($ignoreCache = false) {
		if ( $ignoreCache ) {
			return $this->preferenceServiceUnCached;
		} else {
			return $this->preferenceServiceCached;
		}
	}

	function setUp() {
		global $wgWikiaBotUsers;
		$this->testUserName = $wgWikiaBotUsers["bot"];
		$this->testUserId = \User::idFromName( $this->testUserName );
		$this->preferenceServiceCached = Injector::getInjector()->get( PreferenceService::class );
		$defaultPreferences = Injector::getInjector()->get( PreferenceServiceImpl::DEFAULT_PREFERENCES );
		$cache = $this->getMockBuilder( CacheProvider::class )
			->setMethods( ['doFetch', 'doContains', 'doSave', 'doFlush', 'doDelete', 'doGetStats'] )
			->disableOriginalConstructor()
			->getMock();
		$cache->expects( $this->any() )
			->method( 'doFetch' )
			->with( $this->anything() )
			->willReturn( false );

		$persistence = Injector::getInjector()->get( PreferencePersistence::class );
		$this->preferenceServiceUnCached = new PreferenceServiceImpl( $cache, $persistence, $defaultPreferences, [], [] );
	}

	function testGetSingleUserPreference() {
		$testPref = $this->getUserPreferences()->getGlobalPreference( $this->testUserId, "marketingallowed" );
		$this->assertNotEmpty( $testPref, "Preference 'marketingallowed' is missing for user id: '$this->testUserId'" );
		$this->assertGreaterThanOrEqual( 0, $testPref, "Invalid preference value - expected integer >= 0" );
	}

	function testSetSingleUserPreferenceCached() {
		$prefService = $this->getUserPreferences();
		// first set the preference to a value different then default
		$prefService->setGlobalPreference( $this->testUserId, self::TEST_PREFERENCE_NAME, 1 );
		// now let's verify it's value
		$testPref = $prefService->getGlobalPreference( $this->testUserId, self::TEST_PREFERENCE_NAME );
		$this->assertEquals( $testPref, 1, "Could not set user preference [cached] '" . self::TEST_PREFERENCE_NAME . "' for user id: '$this->testUserId'" );
		// reset value to the default
		$prefService->setGlobalPreference( $this->testUserId, self::TEST_PREFERENCE_NAME, 0 );
		// again verify it's value
		$testPref = $prefService->getGlobalPreference( $this->testUserId, self::TEST_PREFERENCE_NAME );
		$this->assertEquals( $testPref, 0, "Error resetting user preference [cached] '" . self::TEST_PREFERENCE_NAME . "' for user id: '$this->testUserId'" );
	}

	function testSetSingleUserPreferenceNotCached() {
		$prefService = $this->getUserPreferences(true);
		// first set the preference to a value different then default
		$prefService->setGlobalPreference( $this->testUserId, self::TEST_PREFERENCE_NAME, 1 );
		// now let's verify it's value
		$testPref = $prefService->getGlobalPreference( $this->testUserId, self::TEST_PREFERENCE_NAME  );
		$this->assertEquals( $testPref, 1, "Could not set user preference [not cached] '" . self::TEST_PREFERENCE_NAME . "' for user id: '$this->testUserId'" );
		// reset value to the default
		$prefService->setGlobalPreference( $this->testUserId, self::TEST_PREFERENCE_NAME, 0 );
		// again verify it's value
		$testPref = $prefService->getGlobalPreference( $this->testUserId, self::TEST_PREFERENCE_NAME );
		$this->assertEquals( $testPref, 0, "Error resetting user preference [not cached] '" . self::TEST_PREFERENCE_NAME . "' for user id: '$this->testUserId'" );
	}
}
