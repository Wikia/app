<?php

use Wikia\DependencyInjection\Injector;
use Wikia\DependencyInjection\InjectorBuilder;
use Wikia\Service\User\Preferences\PreferenceService;
use Wikia\Service\User\Attributes\UserAttributes;
use Wikia\Service\User\Attributes\AttributeService;
use Wikia\Domain\User\Preferences\UserPreferences;
use Wikia\Service\User\Preferences\Migration\PreferenceScopeService;

class UserTest extends WikiaBaseTest {

	const TEST_USER_ID = 5;
	const SOME_CITY_ID = 12345;
	const SOME_PREF = 'somepref';
	const SOME_VALUE = 'somevalue';

	protected $injector;
	protected $userPreferenceServiceMock;
	protected $userAttributeServiceMock;
	protected $userAttributesMock;

	/** @var User */
	protected $testUser;

	protected static $currentInjector;

	public static function setUpBeforeClass() {
		self::$currentInjector = Injector::getInjector();
	}

	public function setUp() {
		parent::setUp();
		$this->setupAndInjectUserPreferenceServiceMock();

		$this->testUser = User::newFromId( self::TEST_USER_ID );
	}

	public static function tearDownAfterClass() {
		Injector::setInjector( self::$currentInjector );
	}

	private function setupAndInjectUserPreferenceServiceMock() {
		global $wgGlobalUserPreferenceWhiteList, $wgLocalUserPreferenceWhiteList;

		$this->userPreferenceServiceMock = $this->getMock( PreferenceService::class,
			['getGlobalPreference', 'getPreferences', 'setPreferences', 'setGlobalPreference', 'deleteGlobalPreference',
			'getLocalPreference', 'setLocalPreference', 'deleteLocalPreference', 'save', 'getGlobalDefault', 'deleteFromCache',
			'deleteAllPreferences', 'findWikisWithLocalPreferenceValue', 'findUsersWithGlobalPreferenceValue'] );

		$this->userAttributeServiceMock = $this->getMock( AttributeService::class );
		$this->userAttributesMock = $this->getMockBuilder( UserAttributes::class )
			->disableOriginalConstructor()
			->getMock();

		$container = ( new InjectorBuilder() )
			->bind( PreferenceService::class )->to( $this->userPreferenceServiceMock )
			->bind( AttributeService::class )->to( $this->userAttributeServiceMock )
			->bind( PreferenceScopeService::GLOBAL_SCOPE_PREFS )->to( $wgGlobalUserPreferenceWhiteList )
			->bind( PreferenceScopeService::LOCAL_SCOPE_PREFS )->to( $wgLocalUserPreferenceWhiteList )
			->bind( UserAttributes::class )->to( $this->userAttributesMock )
			->build();
		Injector::setInjector( $container );
	}


	/** @dataProvider localOptionNameProvider */
	public function testCreateLocalOptionName( $input, $expected ) {
		$result = call_user_func_array( 'User::localToGlobalPropertyName', $input );
		$this->assertEquals( $expected, $result, sprintf( "failed with input: [%s]", implode( ", ", $input ) ) );
	}

	function localOptionNameProvider() {
		global $wgCityId;
		return [
			[
				[ "foo" ], "foo-{$wgCityId}",
			],
			[
				[ "foo", 1 ], "foo-1",
			],
			[
				[ "foo", 1, "_" ], "foo_1",
			]
		];
	}

	public function testGetGlobalPreferenceWithMockedUserPreferenceService() {
		$this->mockGlobalVariable( 'wgPreferenceServiceRead', true );

		$preference = self::SOME_PREF;
		$value = self::SOME_VALUE;

		$preferences = ( new UserPreferences() )
			->setGlobalPreference( $preference, $value );

		$this->userPreferenceServiceMock->expects( $this->once() )
			->method( 'getGlobalPreference' )
			->with( $this->testUser->getId(), $preference, null, false )
			->willReturn( $value );


		$this->userPreferenceServiceMock->expects( $this->once() )
			->method( 'getPreferences' )
			->with( $this->testUser->getId() )
			->willReturn( $preferences );

		$this->assertEquals( $value, $this->testUser->getGlobalPreference( $preference ) );
	}

	public function testSetGlobalPreferenceWithMockedUserPreferenceService() {
		// this has side effects in the database as long as we are in migration mode
		$this->mockGlobalVariable( 'wgPreferenceServiceWrite', true );

		$preference = self::SOME_PREF;
		$value = self::SOME_VALUE;

		$this->userPreferenceServiceMock->expects( $this->once() )
			->method( 'setGlobalPreference' )
			->with( $this->testUser->getId(), $preference, $value );

		$this->testUser->setGlobalPreference( $preference, $value );
	}

	public function testGetLocalPreferenceWithMockedUserPreferenceService() {
		$this->mockGlobalVariable( 'wgPreferenceServiceRead', true );

		$cityId = self::SOME_CITY_ID;
		$preference = self::SOME_PREF;
		$value = self::SOME_VALUE;

		$this->userPreferenceServiceMock->expects( $this->once() )
			->method( 'getLocalPreference' )
			->with( $this->testUser->getId(), $cityId, $preference, null, false )
			->willReturn( $value );

		$this->assertEquals( $value, $this->testUser->getLocalPreference( $preference, $cityId ) );
	}

	// this has side effects in the database as long as we are in migration mode
	public function testSetLocalPreferenceWithMockedUserPreferenceService() {
		$this->mockGlobalVariable( 'wgPreferenceServiceWrite', true );

		$cityId = self::SOME_CITY_ID;
		$preference = self::SOME_PREF;
		$value = self::SOME_VALUE;

		$this->userPreferenceServiceMock->expects( $this->once() )
			->method( 'setLocalPreference' )
			->with( $this->testUser->getId(), $cityId, $preference, $value );

		$this->testUser->setLocalPreference( $preference, $value, $cityId );
	}

	public function testSavePreferencesWithMockedUserPreferenceService() {
		$this->userPreferenceServiceMock->expects( $this->once() )
			->method( 'save' )
			->with( $this->testUser->getId() );

		$this->testUser->saveSettings();
	}

	public function testGetOptionShouldReturnPreferenceDataFromService() {
		$this->mockGlobalVariable( 'wgCityId', 1 );
		$preferences = ( new UserPreferences() )
			->setGlobalPreference( "language", "pl" )
			->setLocalPreference( "someLocalWikia1Pref", 1, "someLocalWikia1Value" )
			->setLocalPreference( "someLocalWikia2Pref", 2, "someLocalWikia2Value" );

		$this->userPreferenceServiceMock->expects( $this->once() )
			->method( 'getPreferences' )
			->with( $this->testUser->getId() )
			->willReturn( $preferences );

		$options = $this->testUser->getOptions();

		$this->assertEquals( "pl", $options[ "language" ] );
		$this->assertEquals( "someLocalWikia1Value", $options[ "someLocalWikia1Pref" ] );
		$this->assertArrayNotHasKey( "someLocalWikia2Pref", $options );
	}
}
