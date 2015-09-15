<?php

namespace Wikia\Service\User\Preferences;

use Wikia\DependencyInjection\Injector;
use PHPUnit_Framework_TestCase;

class UserPreferencesIntegrationTest extends PHPUnit_Framework_TestCase {
	/**
	 * @var string
	 */
	private $testUser;

	/**
	 * @var int
	 */
	private $testUserId;

	/**
	 * @var string
	 */
	const TEST_PREFERENCE_NAME = "hidepatrolled";

	/**
	 * @return UserPreferences
	 */
	private function getUserPreferences() {
		return Injector::getInjector()->get(UserPreferences::class);
	}

	function setUp() {
		global $wgWikiaBotUsers;
		$this->testUser = $wgWikiaBotUsers["bot"];
		$this->testUserId = \User::idFromName( $this->testUser );
	}

	function testGetSingleUserPreference() {
		$testPref = $this->getUserPreferences()->get($this->testUserId, 'editor');
		$this->assertInternalType('int', $testPref, "Preference 'editor' is missing");
		$this->assertGreaterThanOrEqual(0, $testPref, "Invalid preference value - expected integer >= 0");
	}

	function testSetSingleUserPreference() {
		// first set the preference to a value different then default
		$this->getUserPreferences()->set( $this->testUserId, self::TEST_PREFERENCE_NAME, 1);
		// now let's verify it's value
		$testPref = $this->getUserPreferences()->get($this->testUserId, self::TEST_PREFERENCE_NAME);
		$this->assertEquals($testPref, 1, "Could not set user preference '" . self::TEST_PREFERENCE_NAME . "' for user id: '$this->testUserId'");
		// reset value to the default
		$this->getUserPreferences()->set($this->testUserId, self::TEST_PREFERENCE_NAME, 0);
		// again verify it's value
		$testPref = $this->getUserPreferences()->get($this->testUserId, self::TEST_PREFERENCE_NAME);
		$this->assertEquals($testPref, 0, "Error resetting user preference '" . self::TEST_PREFERENCE_NAME . "' for user id: '$this->testUserId'");
	}
}
