<?php

use Wikia\Factory\ServiceFactory;
use Wikia\Service\User\Permissions\PermissionsService;
use Wikia\Service\User\Preferences\PreferenceService;
use Wikia\Service\User\Attributes\UserAttributes;
use Wikia\Domain\User\Preferences\UserPreferences;
use Wikia\Service\Helios\HeliosClient;

class UserTest extends WikiaBaseTest {

	const TEST_USER_ID = 5;
	const SOME_CITY_ID = 12345;
	const SOME_PREF = 'somepref';
	const SOME_VALUE = 'somevalue';

	protected $userPreferenceServiceMock;
	protected $userAttributesMock;
	protected $userPermissionsMock;
	protected $heliosClientMock;

	/** @var User */
	protected $testUser;

	public function setUp() {
		parent::setUp();
		$this->setupAndInjectServiceMocks();

		$this->testUser = User::newFromId( self::TEST_USER_ID );
	}

	public static function tearDownAfterClass() {
		ServiceFactory::clearState();
	}

	private function setupAndInjectServiceMocks() {
		$this->userPreferenceServiceMock = $this->createMock( PreferenceService::class );
		$this->userAttributesMock = $this->createMock( UserAttributes::class );
		$this->userPermissionsMock = $this->createMock( PermissionsService::class );
		$this->heliosClientMock = $this->createMock( HeliosClient::class );

		$serviceFactory = ServiceFactory::instance();

		$serviceFactory->heliosFactory()->setHeliosClient( $this->heliosClientMock );
		$serviceFactory->attributesFactory()->setUserAttributes( $this->userAttributesMock );
		$serviceFactory->preferencesFactory()->setPreferenceService( $this->userPreferenceServiceMock );
		$serviceFactory->permissionsFactory()->setPermissionsService( $this->userPermissionsMock );
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

		$this->userAttributesMock->expects( $this->once() )
			->method( 'getAttributes' )
			->with( $this->testUser->getId() )
			->willReturn( [] );

		$options = $this->testUser->getOptions();

		$this->assertEquals( "pl", $options[ "language" ] );
		$this->assertEquals( "someLocalWikia1Value", $options[ "someLocalWikia1Pref" ] );
		$this->assertArrayNotHasKey( "someLocalWikia2Pref", $options );
	}

	public function testGetUsernameShouldReturnAnonNameForUserIdZero() {
		$this->assertEquals( 'anonName', User::getUsername( 0, 'anonName' ) );
	}

	public function testGetUsernameShouldReturnNameFromWhoIsIfLookupIsEnabled() {
		$this->mockStaticMethod( 'User', 'whoIs', 'NameFromUserTable' );
		$this->assertEquals( 'NameFromUserTable', User::getUsername( 123, 'notFromUserTableName' ) );
	}

	public function testGetUsernameShouldReturnFalseIfUserIsNotFound() {
		$this->mockStaticMethod( 'User', 'whoIs', false );
		$this->assertEquals( false, User::getUsername( 123, 'someName' ) );
	}

	public function testNewFromTokenAuthorizationGranted() {
		$webRequestMock = $this->getMock( 'WebRequest', [ 'getCookie', 'getHeader' ] );
		$webRequestMock->expects( $this->once() )
			->method( 'getCookie' )
			->willReturn( 'qi8H8R7OM4xMUNMPuRAZxlY' );

		$userInfo = new StdClass;
		$userInfo->user_id = 1;

		$this->heliosClientMock->expects( $this->once() )
			->method( 'info' )
			->with( 'qi8H8R7OM4xMUNMPuRAZxlY' )
			->willReturn( $userInfo );

		$userMock = $this->getMockBuilder( 'User' )
			->setMethods( [ 'getGlobalFlag' ] )
			->getMock();
		$userMock->expects( $this->once() )
			->method( 'getGlobalFlag' )
			->with( $this->equalTo( 'disabled' ) )
			->will( $this->returnValue( false ) );

		$this->mockClass( 'User', $userMock );

		$this->assertEquals( User::newFromToken( $webRequestMock ), User::newFromId( 1 ) );
	}

	public function testNewFromTokenAuthorizationDeclined() {
		$webRequestMock = $this->getMock( 'WebRequest', [ 'getCookie', 'getHeader' ] );
		$webRequestMock->expects( $this->once() )
			->method( 'getCookie' )
			->willReturn( 'qi8H8R7OM4xMUNMPuRAZxlY' );

		$userInfo = new StdClass;

		$this->heliosClientMock->expects( $this->once() )
			->method( 'info' )
			->with( 'qi8H8R7OM4xMUNMPuRAZxlY' )
			->willReturn( $userInfo );

		$this->assertEquals( User::newFromToken( $webRequestMock ), new User );
	}
}
