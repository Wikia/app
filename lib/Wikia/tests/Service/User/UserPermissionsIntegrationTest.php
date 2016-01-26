<?php

namespace Wikia\Service\User\Permissions;

use Wikia\DependencyInjection\Injector;
use PHPUnit_Framework_TestCase;

class UserPermissionsIntegrationTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var int
	 */
	protected $testUserId;

	/**
	 * @var int
	 */
	protected $testCityId;

	/**
	 * @var PermissionsService
	 */
	protected $permissionsService;

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
	const TEST_WIKI_NAME = "muppet";

	/**
	 * @var string
	 */
	const TEST_USER_NAME = "JCel";

	function setUp() {
		$this->testUserName = self::TEST_USER_NAME;
		$this->testUserId = \User::idFromName( $this->testUserName );
		$this->testCityId = \WikiFactory::DBtoID( self::TEST_WIKI_NAME );
		$this->staffUser = \User::newFromId( $this->testUserId );
		$this->anonUser = \User::newFromId( 0 );
		$this->permissionsService = Injector::getInjector()->get( PermissionsService::class );
	}

	function testShouldReturnStaffExplicitGroup() {
		\WikiaDataAccess::cachePurge( PermissionsServiceImpl::getMemcKey( $this->testUserId ) );

		$groups = $this->permissionsService->getExplicitUserGroups( $this->testCityId, $this->testUserId );
		$this->assertContains("staff", $groups);
		$this->assertEquals(1, count($groups));
	}

	function testShouldReturnAutomaticGroups() {
		$groups = $this->permissionsService->getAutomaticUserGroups( $this->staffUser, true );
		$this->assertContains("user", $groups);
		$this->assertContains("autoconfirmed", $groups);
		$this->assertContains("*", $groups);
		$this->assertEquals(3, count($groups));
	}

	function testShouldReturnEffectiveGroups() {
		$groups = $this->permissionsService->getEffectiveUserGroups( $this->testCityId, $this->staffUser, true );
		$this->assertContains("user", $groups);
		$this->assertContains("staff", $groups);
		$this->assertContains("autoconfirmed", $groups);
		$this->assertContains("*", $groups);
		$this->assertEquals(4, count($groups));
	}

	function testShouldReturnEffectiveGroupsForAnon() {
		$groups = $this->permissionsService->getEffectiveUserGroups( $this->testCityId, $this->anonUser, true );
		$this->assertContains("*", $groups);
		$this->assertEquals(1, count($groups));
	}

	function testShouldReturnImplicitGroups() {
		$groups = $this->permissionsService->getImplicitGroups();
		$this->assertContains("*", $groups);
		$this->assertContains("user", $groups);
		$this->assertContains("autoconfirmed", $groups);
		$this->assertContains("poweruser", $groups);
		$this->assertEquals(4, count($groups));
	}

	function testShouldReturnGroupPermissions() {
		global $wgGroupPermissions, $wgRevokePermissions;

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
		# Data for regular $wgRevokePermissions test
		$wgRevokePermissions['formertesters'] = array(
			'runtest' => true,
		);

		$permissions = $this->permissionsService->getGroupPermissions( array( 'unittesters' ) );
		$this->assertContains( 'runtest', $permissions );
		$this->assertNotContains( 'writetest', $permissions );
		$this->assertNotContains( 'modifytest', $permissions );
		$this->assertNotContains( 'nukeworld', $permissions );

		$permissions = $this->permissionsService->getGroupPermissions( array( 'unittesters', 'testwriters' ) );
		$this->assertContains( 'runtest', $permissions );
		$this->assertContains( 'writetest', $permissions );
		$this->assertContains( 'modifytest', $permissions );
		$this->assertNotContains( 'nukeworld', $permissions );
	}

	public function testShouldReturnGroupPermissionsIncludingRevoked() {
		global $wgGroupPermissions, $wgRevokePermissions;

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
		# Data for regular $wgRevokePermissions test
		$wgRevokePermissions['formertesters'] = array(
			'runtest' => true,
		);

		$permissions = $this->permissionsService->getGroupPermissions( array( 'unittesters', 'formertesters' ) );
		$this->assertNotContains( 'runtest', $permissions );
		$this->assertNotContains( 'writetest', $permissions );
		$this->assertNotContains( 'modifytest', $permissions );
		$this->assertNotContains( 'nukeworld', $permissions );
	}

	function testShouldReturnGroupsWithPermission() {
		global $wgGroupPermissions, $wgRevokePermissions;

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
		# Data for regular $wgRevokePermissions test
		$wgRevokePermissions['formertesters'] = array(
			'runtest' => true,
		);

		$groups = $this->permissionsService->getGroupsWithPermission( 'test' );
		$this->assertContains( 'unittesters', $groups );
		$this->assertContains( 'testwriters', $groups );
		$this->assertEquals(2, count($groups));

		$groups = $this->permissionsService->getGroupsWithPermission( 'runtest' );
		$this->assertContains( 'unittesters', $groups );
		$this->assertEquals(1, count($groups));

		$groups = $this->permissionsService->getGroupsWithPermission( 'nosuchright' );
		$this->assertEquals(0, count($groups));
	}

	public function testShouldReturnUserPermissions() {
		$permissions = $this->permissionsService->getUserPermissions( $this->testCityId, $this->staffUser );
		$this->assertContains( 'setadminskin', $permissions );
		$this->assertContains( 'delete', $permissions );
		$this->assertContains( 'block', $permissions );
	}

	public function testShouldReturnPermissionsNotDuplicated() {
		$permissions = $this->permissionsService->getPermissions();
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
		foreach ( $permissionCount as $permissionName => $permissionCount ) {
			$this->assertEquals( 1, $permissionCount, "Duplicated permission ".$permissionName );
		}
	}
}
