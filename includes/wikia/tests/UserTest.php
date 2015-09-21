<?php

use Wikia\DependencyInjection\Injector;
use Wikia\DependencyInjection\InjectorBuilder;
use Wikia\Service\User\Preferences\PreferenceService;
use Wikia\Service\User\Attributes\AttributeService;
use Wikia\Domain\User\Preferences\UserPreferences;
use Wikia\Service\User\Preferences\Migration\PreferenceScopeService;
use Wikia\Service\User\Preferences\Migration\PreferenceCorrectionService;


class UserTest extends WikiaBaseTest {

	const TEST_USER_ID = 5;

	protected $injector;
	protected $userPreferenceServiceMock;
	protected $userAttributeServiceMock;

	protected $testUser;

	public function setUp() {
		parent::setUp();
		$this->setupAndInstallUserPreferenceServiceMock();

		$this->testUser = User::newFromId( self::TEST_USER_ID );
	}

	private function setupAndInstallUserPreferenceServiceMock() {
		global $wgGlobalUserPreferenceWhiteList, $wgLocalUserPreferenceWhiteList;
		$this->userPreferenceServiceMock = $this->getMock( 'Wikia\Service\User\Preferences\PreferenceService',
			['getGlobalPreference', 'getPreferences', 'setPreferences', 'setGlobalPreference', 'deleteGlobalPreference',
			'getLocalPreference', 'setLocalPreference', 'deleteLocalPreference', 'save', 'getGlobalDefault'] );
		$this->userAttributeServiceMock = $this->getMock( 'Wikia\Service\User\Attributes\AttributeService' );


		$container = ( new InjectorBuilder() )
			->bind( PreferenceService::class )->to( $this->userPreferenceServiceMock )
			->bind( AttributeService::class )->to( $this->userAttributeServiceMock )
			->bind( PreferenceScopeService::GLOBAL_SCOPE_PREFS )->to( $wgGlobalUserPreferenceWhiteList )
			->bind( PreferenceScopeService::LOCAL_SCOPE_PREFS )->to( $wgLocalUserPreferenceWhiteList )
			->bind( PreferenceCorrectionService::PREFERENCE_CORRECTION_ENABLED )->to( false )
			->build();
		Injector::setInjector( $container );
	}


	/** @dataProvider localOptionNameProvider */
	public function testCreateLocalOptionName($input, $expected) {
		$result = call_user_func_array('User::localToGlobalPropertyName', $input);
		$this->assertEquals($expected, $result, sprintf("failed with input: [%s]", implode(", ", $input)));
	}

	function localOptionNameProvider() {
		global $wgCityId;
		return array(
			array(
				array("foo"), "foo-{$wgCityId}",
			),
			array(
				array("foo", 1), "foo-1",
			),
			array(
				array("foo", 1, "_"), "foo_1",
			)
		);
	}

	public function testGetGlobalPreferenceWithMockedUserPreferenceService() {
		$preference = 'somepref';
		$value = 'somevalue';

		$preferences = (new UserPreferences())
			->setGlobalPreference( $preference, $value );

		$this->userPreferenceServiceMock->expects( $this->once() )
			->method( 'getGlobalPreference' )
			->with( $this->testUser->getId(), $preference, null, false )
			->willReturn( $value );


		$this->userPreferenceServiceMock->expects( $this->once() )
			->method( 'getPreferences' )
			->with( $this->testUser->getId() )
			->willReturn( $preferences );

		$this->mockGlobalVariable('wgPreferenceServiceRead', true);
		$this->assertEquals($value, $this->testUser->getGlobalPreference($preference));
	}
}
