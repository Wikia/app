<?php

namespace Wikia\Service\User\Permissions;

use Doctrine\Common\Cache\VoidCache;
use Wikia\DependencyInjection\Injector;
use Wikia\Persistence\User\Preferences\PreferencePersistence;
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
	 * @var User
	 */
	protected $staffUser;

	/**
	 * @var User
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
		$this->assertTrue(count($groups) == 1);
	}

	function testShouldReturnAutomaticGroups() {
		$groups = $this->permissionsService->getAutomaticUserGroups( $this->staffUser, true );
		$this->assertContains("user", $groups);
		$this->assertContains("autoconfirmed", $groups);
		$this->assertContains("*", $groups);
		$this->assertTrue(count($groups) == 3);
	}

	function testShouldReturnEffectiveGroups() {
		$groups = $this->permissionsService->getEffectiveUserGroups( $this->testCityId, $this->staffUser, true );
		$this->assertContains("user", $groups);
		$this->assertContains("staff", $groups);
		$this->assertContains("autoconfirmed", $groups);
		$this->assertContains("*", $groups);
		$this->assertTrue(count($groups) == 4);
	}

	function testShouldReturnEffectiveGroupsForAnon() {
		$groups = $this->permissionsService->getEffectiveUserGroups( $this->testCityId, $this->anonUser, true );
		$this->assertContains("*", $groups);
		$this->assertTrue(count($groups) == 1);
	}

	function testShouldReturnImplicitGroups() {
		$groups = $this->permissionsService->getImplicitGroups();
		$this->assertContains("*", $groups);
		$this->assertContains("user", $groups);
		$this->assertContains("autoconfirmed", $groups);
		$this->assertContains("poweruser", $groups);
		$this->assertTrue(count($groups) == 4);
	}
}
