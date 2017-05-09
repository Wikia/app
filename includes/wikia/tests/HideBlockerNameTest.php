<?php
use \Wikia\Service\User\Permissions\PermissionsServiceImpl;
use \Wikia\Service\User\Permissions\PermissionsService;
use \Wikia\DependencyInjection\Injector;
use DI\ContainerBuilder;

class HideBlockerNameTest extends WikiaBaseTest  {
	/** @var Injector $injector Original Injector singleton instance */
	private static $injector = null;

	/**
	 * Back up original Injector instance
	 */
	public static function setUpBeforeClass() {
		parent::setUpBeforeClass();
		static::$injector = Injector::getInjector();
	}

	/**
	 * Check if user group should be shown instead of name based on blocker's permissions
	 * @param array $groups User groups of the user who made the block
	 * @param bool $shouldHideBlockerName Whether to hide the name and show user group instead
	 * @param string $expectedTextInBlockNotice Text to show in block notice instead of username if blocker name should be hidden, otherwise empty string
	 * @covers Block::getGroupNameForHiddenBlocker()
	 * @covers Block::shouldHideBlockerName()
	 * @dataProvider hideBlockerNameDataProvider
	 */
	public function testHideBlockerName( array $groups, $shouldHideBlockerName, $expectedTextInBlockNotice ) {
		$userMock = $this->getMock( User::class, [ 'getName' ] );
		$userMock->expects( $this->any() )
			->method( 'getName' )
			->willReturn( 'Test' );

		/** @var PermissionsService|PHPUnit_Framework_MockObject_MockObject $permissionsServiceMock */
		$permissionsServiceMock = $this->getMock( PermissionsServiceImpl::class,
			[ 'hasPermission', 'getExplicitGlobalGroups' ] );
		$permissionsServiceMock->expects( $this->any() )
			->method( 'hasPermission' )
			->willReturn(
				!empty(
					array_intersect(
						$permissionsServiceMock->getConfiguration()->getGroupsWithPermission( 'hideblockername' ),
						$groups
					)
				)
			);
		$permissionsServiceMock->expects( $this->any() )
			->method( 'getExplicitGlobalGroups' )
			->willReturn(
				array_intersect( $permissionsServiceMock->getConfiguration()->getGlobalGroups(), $groups )
			);
		$container = ContainerBuilder::buildDevContainer();
		$container->set( PermissionsService::class, $permissionsServiceMock );
		$injector = new Injector( $container );
		Injector::setInjector( $injector );

		$block = new Block();
		$block->setBlocker( $userMock );
		$this->assertEquals( $shouldHideBlockerName, $block->shouldHideBlockerName() );
		$this->assertEquals( $expectedTextInBlockNotice, $block->getGroupNameForHiddenBlocker() );
	}

	/**
	 * @return array user groups, whether to hide user name, and expected group name message
	 */
	public function hideBlockerNameDataProvider() {
		return [
			'user name hidden for staff' => [ [ 'staff' ], true, wfMessage( 'group-staff' )->plain() ],
			'user name hidden for helpers' => [ [ 'helper' ], true, wfMessage( 'group-helper' )->plain() ],
			'user name hidden for vstf' => [ [ 'vstf' ], true, wfMessage( 'group-vstf' )->plain() ],
			'user name shown for sysops' => [ [ 'sysop' ], false, '' ],
		];
	}

	/**
	 * Restore original Injector instance
	 */
	public static function tearDownAfterClass() {
		Injector::setInjector( static::$injector );
		parent::tearDownAfterClass();
	}
}
