<?php

namespace Wikia\Service\User\Preferences;

use Mcustiel\Phiremock\Client\Phiremock;
use Mcustiel\Phiremock\Client\Utils\A;
use Mcustiel\Phiremock\Client\Utils\Is;
use Mcustiel\Phiremock\Client\Utils\Respond;
use PHPUnit\Framework\TestCase;
use Wikia\Factory\ServiceFactory;

/**
 * @group Integration
 */
class UserPreferencesIntegrationTest extends TestCase {
	use \HttpIntegrationTest;

	/**
	 * @var int
	 */
	protected $testUserId;

	/**
	 * @var PreferenceService
	 */
	protected $preferenceService;

	const TEST_PREFERENCE_NAME = "hidepatrolled";

	protected function setUp() {
		$this->testUserId = 4;

		$serviceFactory = new ServiceFactory();

		$serviceFactory->providerFactory()->setUrlProvider( $this->getMockUrlProvider() );

		$this->preferenceService = $serviceFactory->preferencesFactory()->preferenceService();
	}

	public function testGetSingleUserPreference() {
		$exp = Phiremock::on( A::getRequest()->andUrl( Is::equalTo( "/{$this->testUserId}" ) ) )
			->then( Respond::withStatusCode( 200 )
				->andHeader( 'Content-Type', 'application/json' )
				->andBody( file_get_contents( __DIR__ . '/fixtures/sample_preferences.json' ) ) );

		$this->getMockServer()->createExpectation( $exp );

		$testPref = $this->preferenceService->getGlobalPreference( $this->testUserId, "showAds" );
		$this->assertNotEmpty( $testPref, "Preference 'showAds' is missing for user id: '$this->testUserId'" );
		$this->assertGreaterThanOrEqual( 0, $testPref, "Invalid preference value - expected integer >= 0" );
	}

	function testGetNotExistingUserPreference() {
		$exp = Phiremock::on( A::getRequest()->andUrl( Is::equalTo( "/{$this->testUserId}/global/somestrangepreference" )	) )
			->then( Respond::withStatusCode( 404 )
				->andHeader( 'Content-Type', 'application/problem+json' )
				->andBody( json_encode( [] ) ) );

		$this->getMockServer()->createExpectation( $exp );

		$testPref = $this->preferenceService->getGlobalPreference( $this->testUserId, "somestrangepreference" );
		$this->assertEmpty( $testPref, "Preference 'somestrangepreference' is present but shouldn't for user id: '$this->testUserId'" );
	}

	public function testSetSingleUserPreference() {
		// first set the preference to a value different then default
		$this->preferenceService->setGlobalPreference( $this->testUserId, self::TEST_PREFERENCE_NAME, 1 );
		// now let's verify it's value
		$testPref = $this->preferenceService->getGlobalPreference( $this->testUserId, self::TEST_PREFERENCE_NAME );
		$this->assertEquals( $testPref, 1, "Could not set user preference [cached] '" . self::TEST_PREFERENCE_NAME . "' for user id: '$this->testUserId'" );
		// reset value to the default
		$this->preferenceService->setGlobalPreference( $this->testUserId, self::TEST_PREFERENCE_NAME, 0 );
		// again verify it's value
		$testPref = $this->preferenceService->getGlobalPreference( $this->testUserId, self::TEST_PREFERENCE_NAME );
		$this->assertEquals( $testPref, 0, "Error resetting user preference [cached] '" . self::TEST_PREFERENCE_NAME . "' for user id: '$this->testUserId'" );
	}

	protected function tearDown() {
		parent::tearDown();
		$this->getMockServer()->clearExpectations();
	}
}
