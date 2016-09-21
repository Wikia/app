<?php

namespace Wikia\Service\User\Preferences;

use Doctrine\Common\Cache\VoidCache;
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
	const TEST_USER_NAME = "Array";

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
		$this->testUserName = self::TEST_USER_NAME;
		$this->testUserId = \User::idFromName( $this->testUserName );
		$this->preferenceServiceCached = Injector::getInjector()->get( PreferenceService::class );
		$defaultPreferences = Injector::getInjector()->get( PreferenceServiceImpl::DEFAULT_PREFERENCES );
		$cache = new VoidCache();
		$persistence = Injector::getInjector()->get( PreferencePersistence::class );
		$this->preferenceServiceUnCached = new PreferenceServiceImpl( $cache, $persistence, $defaultPreferences, [], [] );
	}

	function testGetSingleUserPreferenceCached() {
		$testPref = $this->getUserPreferences()->getGlobalPreference( $this->testUserId, "marketingallowed" );
		$this->assertNotEmpty( $testPref, "Preference 'marketingallowed' is missing for user id: '$this->testUserId'" );
		$this->assertGreaterThanOrEqual( 0, $testPref, "Invalid preference value - expected integer >= 0" );
	}

	function testGetSingleUserPreferenceNotCached() {
		$testPref = $this->getUserPreferences( true )->getGlobalPreference( $this->testUserId, "marketingallowed" );
		$this->assertNotEmpty( $testPref, "Preference 'marketingallowed' is missing for user id: '$this->testUserId'" );
		$this->assertGreaterThanOrEqual( 0, $testPref, "Invalid preference value - expected integer >= 0" );
	}

	function testGetNotExistingUserPreference() {
		$testPref = $this->getUserPreferences()->getGlobalPreference( $this->testUserId, "somestrangepreference" );
		$this->assertEmpty( $testPref, "Preference 'somestrangepreference' is present but shouldn't for user id: '$this->testUserId'" );
	}

	function testGetAllUserPreferencesMixed() {
		$cachedPrefs = $this->getUserPreferences()->getPreferences( $this->testUserId );
		$uncachedPrefs = $this->getUserPreferences( true )->getPreferences( $this->testUserId );
		$this->assertEquals($cachedPrefs, $uncachedPrefs, "Cached and uncached preferences differ for user ud: '$this->testUserId'");
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
		$prefService = $this->getUserPreferences( true );
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
