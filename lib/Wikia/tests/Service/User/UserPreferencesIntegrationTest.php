<?php

namespace Wikia\Service\User\Preferences;

use Doctrine\Common\Cache\VoidCache;
use Mcustiel\Phiremock\Client\Phiremock;
use Mcustiel\Phiremock\Client\Utils\A;
use Mcustiel\Phiremock\Client\Utils\Is;
use Mcustiel\Phiremock\Client\Utils\Respond;
use PHPUnit\Framework\TestCase;
use Wikia\DependencyInjection\InjectorBuilder;
use Wikia\DependencyInjection\InjectorInitializer;
use Wikia\Persistence\User\Preferences\PreferencePersistence;
use Wikia\Service\Gateway\UrlProvider;

/**
 * @group Integration
 */
class UserPreferencesIntegrationTest extends TestCase {
	use \HttpIntegrationTest;

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
	private function getUserPreferences( bool $ignoreCache = false ): PreferenceService {
		if ( $ignoreCache ) {
			return $this->preferenceServiceUnCached;
		}

		return $this->preferenceServiceCached;
	}

	protected function setUp() {
		$this->testUserName = self::TEST_USER_NAME;
		$this->testUserId = \User::idFromName( $this->testUserName );

		$injector = InjectorInitializer::newInjectorWithOverrides(
			function ( InjectorBuilder $builder ) {
				$builder->bind( UrlProvider::class )->to( $this->getMockUrlProvider() );
			}
		);

		$this->preferenceServiceCached = $injector->get( PreferenceService::class );
		$defaultPreferences = $injector->get( PreferenceServiceImpl::DEFAULT_PREFERENCES );
		$cache = new VoidCache();
		$persistence = $injector->get( PreferencePersistence::class );
		$this->preferenceServiceUnCached = new PreferenceServiceImpl( $cache, $persistence, $defaultPreferences, [], [] );
	}

	function testGetSingleUserPreferenceCached() {
		$exp = Phiremock::on( A::getRequest()->andUrl( Is::equalTo( "/{$this->testUserId}" ) ) )
			->then( Respond::withStatusCode( 200 )
				->andHeader( 'Content-Type', 'application/json' )
				->andBody( file_get_contents( __DIR__ . '/fixtures/sample_preferences.json' ) ) );

		$this->getMockServer()->createExpectation( $exp );

		$testPref = $this->getUserPreferences()->getGlobalPreference( $this->testUserId, "showAds" );
		$this->assertNotEmpty( $testPref, "Preference 'showAds' is missing for user id: '$this->testUserId'" );
		$this->assertGreaterThanOrEqual( 0, $testPref, "Invalid preference value - expected integer >= 0" );
	}

	function testGetSingleUserPreferenceNotCached() {
		$exp = Phiremock::on( A::getRequest()->andUrl( Is::equalTo( "/{$this->testUserId}" ) ) )
			->then( Respond::withStatusCode( 200 )
				->andHeader( 'Content-Type', 'application/json' )
				->andBody( file_get_contents( __DIR__ . '/fixtures/sample_preferences.json' ) ) );

		$this->getMockServer()->createExpectation( $exp );

		$testPref = $this->getUserPreferences( true )->getGlobalPreference( $this->testUserId, "showAds" );
		$this->assertNotEmpty( $testPref, "Preference 'showAds' is missing for user id: '$this->testUserId'" );
		$this->assertGreaterThanOrEqual( 0, $testPref, "Invalid preference value - expected integer >= 0" );
	}

	function testGetNotExistingUserPreference() {
		$exp = Phiremock::on( A::getRequest()->andUrl( Is::equalTo( "/{$this->testUserId}/global/somestrangepreference" )	) )
			->then( Respond::withStatusCode( 404 )
				->andHeader( 'Content-Type', 'application/problem+json' )
				->andBody( json_encode( [] ) ) );

		$this->getMockServer()->createExpectation( $exp );

		$testPref = $this->getUserPreferences()->getGlobalPreference( $this->testUserId, "somestrangepreference" );
		$this->assertEmpty( $testPref, "Preference 'somestrangepreference' is present but shouldn't for user id: '$this->testUserId'" );
	}

	function testGetAllUserPreferencesMixed() {
		$exp = Phiremock::on( A::getRequest()->andUrl( Is::equalTo( "/{$this->testUserId}" )	) )
			->then( Respond::withStatusCode( 200 )
				->andHeader( 'Content-Type', 'application/json' )
				->andBody( file_get_contents( __DIR__ . '/fixtures/sample_preferences.json' ) ) );

		$this->getMockServer()->createExpectation( $exp );

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

	protected function tearDown() {
		$this->getMockServer()->clearExpectations();
	}
}
