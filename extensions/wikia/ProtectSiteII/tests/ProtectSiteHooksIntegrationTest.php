<?php

/**
 * @group Integration
 */
class ProtectSiteHooksIntegrationTest extends WikiaDatabaseTest {

	const PROTECTED_WIKI_ID = 2;
	const ANONS_ONLY_PROTECTED_WIKI_ID = 3;
	const UNPROTECTED_WIKI_ID = 4;

	/** @var Title $title */
	private $title;

	protected function setUp() {
		parent::setUp();
		$this->mockGlobalVariable( 'wgCityId', static::PROTECTED_WIKI_ID );
		$this->title = new Title();
	}

	/**
	 * @dataProvider allUserActionProvider
	 * @param string $userName
	 * @param string $action
	 */
	public function testShouldAllowEveryoneWhenNotProtected( string $userName, string $action ) {
		$this->mockGlobalVariable( 'wgCityId', static::UNPROTECTED_WIKI_ID );

		$user = User::newFromName( $userName, false );
		$result = true;

		$return = ProtectSiteHooks::onGetUserPermissionsErrorsExpensive( $this->title, $user, $action, $result );

		$this->assertTrue( $result, "Action should be allowed for user: $userName" );
		$this->assertTrue( $return, 'Hooks execution should be resumed' );
	}

	public function allUserActionProvider() {
		foreach ( [ 'NormalUser', 'StaffUser', '8.8.8.8' ] as $userName ) {
			foreach ( ProtectSiteModel::getValidActions() as $action ) {
				yield "user: $userName, action: $action" => [ $userName, $action ];
			}
		}
	}

	/**
	 * @dataProvider userProvider
	 * @param string $userName
	 */
	public function testShouldAllowEveryoneWhenActionUnknown( string $userName ) {
		$user = User::newFromName( $userName, false );
		$result = true;

		$return = ProtectSiteHooks::onGetUserPermissionsErrorsExpensive( $this->title, $user, 'unknown', $result );

		$this->assertTrue( $result, "Action should be allowed for user: $userName" );
		$this->assertTrue( $return, 'Hooks execution should be resumed' );
	}

	public function userProvider() {
		yield [ 'NormalUser' ];
		yield [ 'StaffUser' ];
		yield [ '8.8.8.8' ];
	}

	/**
	 * @dataProvider nonStaffUserActionProvider
	 *
	 * @param string $userName
	 * @param string $action
	 */
	public function testShouldPreventNotStaffUsersWhenAllActionsPrevented( string $userName, string $action ) {
		$user = User::newFromName( $userName, false );
		$result = true;

		$return = ProtectSiteHooks::onGetUserPermissionsErrorsExpensive( $this->title, $user, $action, $result );

		$this->assertFalse( $result, "Action '$action' should not be allowed for user: $userName" );
		$this->assertFalse( $return, 'Hooks execution should be stopped' );
	}

	public function nonStaffUserActionProvider() {
		foreach ( [ 'NormalUser', '8.8.8.8' ] as $userName ) {
			foreach ( ProtectSiteModel::getValidActions() as $action ) {
				yield "user: $userName, action: $action" => [ $userName, $action ];
			}
		}
	}

	/**
	 * @dataProvider actionProvider
	 * @param string $action
	 */
	public function testShouldAllowStaffUserWhenAllActionsPrevented( string $action ) {
		$user = User::newFromName( 'StaffUser', false );
		$result = true;

		$return = ProtectSiteHooks::onGetUserPermissionsErrorsExpensive( $this->title, $user, $action, $result );

		$this->assertTrue( $result, "Action '$action' should be allowed for staff user" );
		$this->assertTrue( $return, 'Hooks execution should be resumed' );
	}

	public function actionProvider() {
		foreach ( ProtectSiteModel::getValidActions() as $action ) {
			yield "action: $action" => [ $action ];
		}
	}

	/**
	 * @dataProvider loggedInUserActionProvider
	 * @param string $userName
	 * @param string $action
	 */
	public function testShouldAllowLoggedInUsersWhenBlockingOnlyAnons( string $userName, string $action ) {
		$this->mockGlobalVariable( 'wgCityId', static::ANONS_ONLY_PROTECTED_WIKI_ID );

		$user = User::newFromName( $userName, false );
		$result = true;

		$return = ProtectSiteHooks::onGetUserPermissionsErrorsExpensive( $this->title, $user, $action, $result );

		$this->assertTrue( $result, "Action should be allowed for user: $userName" );
		$this->assertTrue( $return, 'Hooks execution should be resumed' );
	}

	public function loggedInUserActionProvider() {
		foreach ( [ 'NormalUser', 'StaffUser' ] as $userName ) {
			foreach ( ProtectSiteModel::getValidActions() as $action ) {
				yield "user: $userName, action: $action" => [ $userName, $action ];
			}
		}
	}

	/**
	 * @dataProvider actionProvider
	 * @param string $action
	 */
	public function testShouldPreventAnonsWhenBlockingOnlyAnons( string $action ) {
		$this->mockGlobalVariable( 'wgCityId', static::ANONS_ONLY_PROTECTED_WIKI_ID );

		$user = new User();
		$result = true;

		$return = ProtectSiteHooks::onGetUserPermissionsErrorsExpensive( $this->title, $user, $action, $result );

		$this->assertFalse( $result, "Action '$action' should be prevented for anons" );
		$this->assertFalse( $return, 'Hooks execution should be stopped' );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/protect_site_shared.yaml' );
	}
}
