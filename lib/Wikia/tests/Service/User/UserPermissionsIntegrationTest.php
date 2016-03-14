<?php

namespace Wikia\Service\User\Permissions;

use Wikia\Service\User\Permissions\PermissionsServiceAccessor;

class UserPermissionsIntegrationTest extends \WikiaBaseTest {
	use PermissionsServiceAccessor;

	/**
	 * @var int
	 */
	protected $staffUserId;

	/**
	 * @var int
	 */
	protected $testCityId;

	/**
	 * @var \User
	 */
	protected $staffUser;

	/**
	 * @var \User
	 */
	protected $anonUser;

	/**
	 * @var string
	 */
	const TEST_WIKI_NAME = "firefly";

	/**
	 * @var string
	 */
	const TEST_STAFF_USER_NAME = "PermissionTest";

	protected function setUp() {
		$this->staffUserId = \User::idFromName( self::TEST_STAFF_USER_NAME );
		$this->testCityId = \WikiFactory::DBtoID( self::TEST_WIKI_NAME );
		$this->staffUser = \User::newFromId( $this->staffUserId );
		$this->anonUser = \User::newFromId( 0 );

		parent::setUp();
	}

	function testShouldReturnExplicitGroups() {
		\WikiaDataAccess::cachePurge( PermissionsServiceImpl::getMemcKey( $this->staffUserId ) );

		$groups = $this->permissionsService()->getExplicitGroups( $this->staffUser );
		$this->assertContains("staff", $groups);
		$this->assertContains("bureaucrat", $groups);
		$this->assertNotContains("user", $groups);
		$this->assertNotContains("*", $groups);
	}

	function testShouldReturnAutomaticGroups() {
		$groups = $this->permissionsService()->getAutomaticGroups( $this->staffUser, true );
		$this->assertContains("user", $groups);
		$this->assertContains("*", $groups);
		$this->assertNotContains("staff", $groups);
		$this->assertNotContains("bureaucrat", $groups);
	}

	function testShouldReturnEffectiveGroups() {
		$groups = $this->permissionsService()->getEffectiveGroups( $this->staffUser, true );
		$this->assertContains("user", $groups);
		$this->assertContains("staff", $groups);
		$this->assertContains("bureaucrat", $groups);
		$this->assertContains("*", $groups);
		$this->assertNotContains("util", $groups);
	}

	function testShouldReturnEffectiveGroupsForAnon() {
		$groups = $this->permissionsService()->getEffectiveGroups( $this->anonUser, true );
		$this->assertContains("*", $groups);
		$this->assertEquals(1, count($groups));
	}

	function testShouldReturnImplicitGroups() {
		$groups = $this->permissionsService()->getConfiguration()->getImplicitGroups();
		$this->assertContains("*", $groups);
		$this->assertContains("user", $groups);
		$this->assertNotContains("staff", $groups);
		$this->assertNotContains("bureaucrat", $groups);
	}

	function testShouldReturnGroupPermissions() {
		global $wgGroupPermissions;

		# Data for regular $wgGroupPermissions test
		$wgGroupPermissions['unittesters'] = array(
			'test' => true,
			'runtest' => true,
			'writetest' => false,
			'nukeworld' => false,
		);
		$wgGroupPermissions['testwriters'] = array(
			'test' => true,
			'writetest' => true,
			'modifytest' => true,
		);

		$permissions = $this->permissionsService()->getConfiguration()->getGroupPermissions( array( 'unittesters' ) );
		$this->assertContains( 'runtest', $permissions );
		$this->assertNotContains( 'writetest', $permissions );
		$this->assertNotContains( 'modifytest', $permissions );
		$this->assertNotContains( 'nukeworld', $permissions );

		$permissions = $this->permissionsService()->getConfiguration()->getGroupPermissions(
			array( 'unittesters', 'testwriters' ) );
		$this->assertContains( 'runtest', $permissions );
		$this->assertContains( 'writetest', $permissions );
		$this->assertContains( 'modifytest', $permissions );
		$this->assertNotContains( 'nukeworld', $permissions );
	}

	public function testShouldReturnGroupPermissionsIncludingRevoked() {
		global $wgGroupPermissions;

		# Data for regular $wgGroupPermissions test
		$wgGroupPermissions['unittesters'] = array(
			'test' => true,
			'runtest' => true,
			'writetest' => false,
			'nukeworld' => false,
		);
		$wgGroupPermissions['testwriters'] = array(
			'test' => true,
			'writetest' => true,
			'modifytest' => true,
		);

		$permissions = $this->permissionsService()->getConfiguration()->getGroupPermissions(
			array( 'unittesters', 'formertesters' ) );
		$this->assertNotContains( 'writetest', $permissions );
		$this->assertNotContains( 'modifytest', $permissions );
		$this->assertNotContains( 'nukeworld', $permissions );
	}

	function testShouldReturnGroupsWithPermission() {
		global $wgGroupPermissions;

		# Data for regular $wgGroupPermissions test
		$wgGroupPermissions['unittesters'] = array(
			'test' => true,
			'runtest' => true,
			'writetest' => false,
			'nukeworld' => false,
		);
		$wgGroupPermissions['testwriters'] = array(
			'test' => true,
			'writetest' => true,
			'modifytest' => true,
		);

		$groups = $this->permissionsService()->getConfiguration()->getGroupsWithPermission( 'test' );
		$this->assertContains( 'unittesters', $groups );
		$this->assertContains( 'testwriters', $groups );
		$this->assertEquals(2, count($groups));

		$groups = $this->permissionsService()->getConfiguration()->getGroupsWithPermission( 'runtest' );
		$this->assertContains( 'unittesters', $groups );
		$this->assertEquals(1, count($groups));

		$groups = $this->permissionsService()->getConfiguration()->getGroupsWithPermission( 'nosuchright' );
		$this->assertEquals(0, count($groups));
	}

	public function testShouldReturnUserPermissions() {
		$permissions = $this->permissionsService()->getPermissions( $this->staffUser );
		$this->assertContains( 'setadminskin', $permissions );
		$this->assertContains( 'delete', $permissions );
		$this->assertContains( 'block', $permissions );
	}

	public function testShouldReturnPermissionsNotDuplicated() {
		$permissions = $this->permissionsService()->getConfiguration()->getPermissions();
		$this->assertContains( 'move', $permissions );
		$this->assertContains( 'oversight', $permissions );

		$permissionCount = [];
		foreach ( $permissions as $permission ) {
			if ( array_key_exists( $permission, $permissionCount ) ) {
				$permissionCount[ $permission ] = $permissionCount[ $permission ] + 1;
			} else {
				$permissionCount[ $permission ] = 1;
			}
		}
		foreach ( $permissionCount as $permissionName => $permissionCountValue ) {
			$this->assertEquals( 1, $permissionCountValue, "Duplicated permission ".$permissionName );
		}
	}

	public function testShouldReturnGroupsChangeableByGroups() {
		$groups = $this->permissionsService()->getConfiguration()->getGroupsChangeableByGroup( 'util' );
		$this->assertNotContains( 'util', $groups['add'] );
		$this->assertContains( 'util', $groups['remove'] );
		$this->assertNotContains( 'staff', $groups['add'] );
		$this->assertContains( 'staff', $groups['remove'] );
		$this->assertNotContains( 'util', $groups['add-self'] );
		$this->assertNotContains( 'util', $groups['remove-self'] );
		$this->assertNotContains( 'user', $groups['add'] );
		$this->assertNotContains( 'user', $groups['remove'] );
		$this->assertNotContains( 'user', $groups['add-self'] );
		$this->assertNotContains( 'user', $groups['remove-self'] );
		$this->assertContains( 'translator', $groups['add'] );
		$this->assertContains( 'translator', $groups['remove'] );
		$this->assertNotContains( 'translator', $groups['add-self'] );
		$this->assertNotContains( 'translator', $groups['remove-self'] );

		$groups = $this->permissionsService()->getConfiguration()->getGroupsChangeableByGroup( 'content-reviewer' );
		$this->assertNotContains( 'staff', $groups['add'] );
		$this->assertNotContains( 'staff', $groups['remove'] );
		$this->assertContains( 'content-reviewer', $groups['add'] );
		$this->assertContains( 'content-reviewer', $groups['remove'] );
		$this->assertNotContains( 'content-reviewer', $groups['add-self'] );
		$this->assertNotContains( 'content-reviewer', $groups['remove-self'] );

		$groups = $this->permissionsService()->getConfiguration()->getGroupsChangeableByGroup( 'staff' );
		$this->assertContains( 'staff', $groups['add'] );
		$this->assertContains( 'staff', $groups['remove'] );
		$this->assertContains( 'staff', $groups['add-self'] );
		$this->assertContains( 'staff', $groups['remove-self'] );
	}

	public function testShouldAddAndRemoveGlobalGroup() {
		$this->mockGlobalVariable('wgWikiaIsCentralWiki', true);

		$groups = $this->permissionsService()->getExplicitGlobalGroups( $this->staffUser );
		if ( !in_array( 'reviewer', $groups ) ) {
			$this->permissionsService()->addToGroup( $this->staffUser, $this->staffUser, 'reviewer' );
		}
		$groups = $this->permissionsService()->getExplicitGlobalGroups( $this->staffUser );
		$this->assertContains( 'reviewer', $groups );

		$this->permissionsService()->removeFromGroup( $this->staffUser, $this->staffUser, 'reviewer' );
		$groups = $this->permissionsService()->getExplicitGlobalGroups( $this->staffUser );
		$this->assertNotContains( 'reviewer', $groups );

		$this->permissionsService()->addToGroup( $this->staffUser, $this->staffUser, 'reviewer' );
		$groups = $this->permissionsService()->getExplicitGlobalGroups( $this->staffUser );
		$this->assertContains( 'reviewer', $groups );

		$groups = $this->permissionsService()->getExplicitGlobalGroups( $this->staffUser );
		$this->assertNotContains( 'content-review', $groups );
		$this->assertFalse( $this->permissionsService()->addToGroup(
			$this->staffUser, $this->staffUser, 'content-review' ) );
		$groups = $this->permissionsService()->getExplicitGlobalGroups( $this->staffUser );
		$this->assertNotContains( 'content-review', $groups );

		$this->assertFalse( $this->permissionsService()->removeFromGroup(
			$this->staffUser, $this->staffUser, 'some-made-up-group' ) );
	}

	public function testShouldAddAndRemoveLocalGroup() {
		$groups = $this->permissionsService()->getExplicitLocalGroups( $this->staffUser );
		if ( !in_array( 'threadmoderator', $groups ) ) {
			$this->permissionsService()->addToGroup( $this->staffUser, $this->staffUser, 'threadmoderator' );
		}
		$groups = $this->permissionsService()->getExplicitLocalGroups( $this->staffUser );
		$this->assertContains( 'threadmoderator', $groups );

		$this->permissionsService()->removeFromGroup( $this->staffUser, $this->staffUser, 'threadmoderator' );
		$groups = $this->permissionsService()->getExplicitLocalGroups( $this->staffUser );
		$this->assertNotContains( 'threadmoderator', $groups );

		$this->permissionsService()->addToGroup( $this->staffUser, $this->staffUser, 'threadmoderator' );
		$groups = $this->permissionsService()->getExplicitLocalGroups( $this->staffUser );
		$this->assertContains( 'threadmoderator', $groups );
	}

	public function testShouldAllowPermission() {
		$this->assertTrue( $this->permissionsService()->hasPermission(
			$this->staffUser, 'move' ) );
		$this->assertTrue( $this->permissionsService()->hasPermission(
			$this->staffUser, 'siteadmin' ) );

		$this->assertFalse( $this->permissionsService()->hasPermission(
			$this->anonUser, 'siteadmin' ) );
		$this->assertFalse( $this->permissionsService()->hasPermission(
			$this->anonUser, 'move' ) );
	}

	public function testShouldAllowAllPermissions() {
		$this->assertTrue( $this->permissionsService()->hasAllPermissions(
			$this->staffUser, array( 'move', 'edit' ) ) );
		$this->assertFalse( $this->permissionsService()->hasAllPermissions(
			$this->staffUser, array( 'move', 'something-made-up' ) ) );
	}

	public function testShouldAllowAnyPermission() {
		$this->assertTrue( $this->permissionsService()->hasAnyPermission(
			$this->staffUser, array( 'move', 'edit' ) ) );
		$this->assertTrue( $this->permissionsService()->hasAnyPermission(
			$this->staffUser, array( 'move', 'something-made-up' ) ) );
		$this->assertFalse( $this->permissionsService()->hasAnyPermission(
			$this->staffUser, array( 'something-made-up1', 'something-made-up2' ) ) );
	}
}
