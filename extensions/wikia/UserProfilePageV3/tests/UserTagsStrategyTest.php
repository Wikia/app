<?php
use \Wikia\Service\User\Permissions\PermissionsServiceImpl;
use \Wikia\Service\User\Permissions\PermissionsService;
use \Wikia\DependencyInjection\Injector;
use \DI\ContainerBuilder;

/**
 * Expected behavior of user tags:
 *
 * If an user is a member of global user groups, and local user groups, show the most important global and local group
 * If an user has only local groups, show the two most important local groups
 * If a user has only global groups, show the two most important global groups
 * @class UserTagsStrategyTest
 * @covers UserTagsStrategy
 */
class UserTagsStrategyTest extends WikiaBaseTest {
	/** @var Injector $injector Original Injector singleton instance */
	private static $injector = null;

	/**
	 * Back up Injector instance before test
	 */
	public static function setUpBeforeClass() {
		static::$injector = Injector::getInjector();
		parent::setUpBeforeClass();
	}

	public function setUp() {
		$this->setupFile = __DIR__ . '/../UserProfilePage.setup.php';
		parent::setUp();

		$this->mockGlobalVariable( 'wgEnableChat', true );
	}

	/**
	 * Given the current user's user groups, blocked status, chatban status and if they're the founder, validate the generated user tags
	 * @param array $globalGroups Array of strings (global groups for this user)
	 * @param array $localGroups Array of strings (local groups for this user)
	 * @param bool $isBlocked Whether this user is blocked
	 * @param bool $isChatBanned Whether this user is banned from chat
	 * @param bool $isFounder Whether this user is the founder
	 * @param array $expectedTags Array of strings (expected tags and their content)
	 * @covers UserTagsStrategy::getUserTags
	 * @dataProvider getUserTagsDataProvider
	 */
	public function testGetUserTags( array $globalGroups, array $localGroups, $isBlocked, $isChatBanned, $isFounder, array $expectedTags ) {
		$permissionsServiceMock = $this->getMock( PermissionsServiceImpl::class, [ 'getExplicitGlobalGroups' , 'getExplicitLocalGroups' ] );
		$permissionsServiceMock->expects( $this->any() )
			->method( 'getExplicitGlobalGroups' )
			->willReturn( $globalGroups );
		$permissionsServiceMock->expects( $this->any() )
			->method( 'getExplicitLocalGroups' )
			->willReturn( $localGroups );
		$container = ContainerBuilder::buildDevContainer();
		$container->set( PermissionsService::class, $permissionsServiceMock );
		$injector = new Injector( $container );
		Injector::setInjector( $injector );

		$chatUserMock = $this->getMockBuilder( ChatUser::class )
			->disableOriginalConstructor()
			->setMethods( [ 'isBanned' ] )
			->getMock();
		$chatUserMock->expects( $this->any() )
			->method( 'isBanned' )
			->willReturn( $isChatBanned );
		$this->mockClass( ChatUser::class, $chatUserMock );

		$userMock = $this->getMock( User::class, [ 'isBlocked', 'getId' ] );
		$userMock->expects( $this->any() )
			->method( 'isBlocked' )
			->willReturn( $isBlocked );
		$userMock->expects( $this->any() )
			->method( 'getId' )
			->willReturn( 1 );

		$this->mockStaticMethod( WikiFactory::class, 'getWikiById', (object)[ 'city_founding_user' => (int) $isFounder ] );

		$strategy = new UserTagsStrategy( $userMock );
		$this->assertEquals( $expectedTags, $strategy->getUserTags() );
	}

	public function getUserTagsDataProvider() {
		return [
			'normal user' => [ [], [], false, false, false,
				[]
			],
			'blocked user' => [ [], [], true, false, false,
				[ wfMessage( 'user-identity-box-blocked' )->escaped() ]
			],
			'blocked user with other rights' => [ [ 'helper' ], [ 'sysop' ], true, true, true,
				[ wfMessage( 'user-identity-box-blocked' )->escaped() ]
			],
			'blocked staff member' => [ [ 'staff' ], [], true, false, false,
				[ wfMessage( 'user-identity-box-group-staff' )->escaped() ]
			],
			'blocked staff member with other rights' => [ [ 'staff' ], [ 'sysop' ], true, false, false,
				[
					wfMessage( 'user-identity-box-group-staff' )->escaped(),
					wfMessage( 'user-identity-box-group-sysop' )->escaped()
				]
			],
			'staff founder' => [ [ 'staff' ], [ 'bureaucrat', 'sysop' ], false, false, true,
				[
					wfMessage( 'user-identity-box-group-staff' )->escaped(),
					wfMessage( 'user-identity-box-founder' )->escaped()
				]
			],
			'founder with other global rights' => [ [ 'helper', 'vstf' ], [ 'bureaucrat', 'sysop' ], false, false, true,
				[
					wfMessage( 'user-identity-box-group-helper' )->escaped(),
					wfMessage( 'user-identity-box-founder' )->escaped()
				]
			],
			'staff and local admin' => [ [ 'staff' ], [ 'sysop' ], false, false, false,
				[
					wfMessage( 'user-identity-box-group-staff' )->escaped(),
					wfMessage( 'user-identity-box-group-sysop' )->escaped()
				]
			],
			'multiple global rights and local admin' => [ [ 'vstf', 'council' ], [ 'sysop' ], false, false, false,
				[
					wfMessage( 'user-identity-box-group-vstf' )->escaped(),
					wfMessage( 'user-identity-box-group-sysop' )->escaped()
				]
			],
			'local rights only' => [ [], [ 'bureaucrat', 'threadmoderator', 'sysop' ], false, false, false,
				[
					wfMessage( 'user-identity-box-group-bureaucrat' )->escaped(),
					wfMessage( 'user-identity-box-group-sysop' )->escaped()
				]
			],
			'global rights only' => [ [ 'staff', 'vstf' ], [], false, false, false,
				[
					wfMessage( 'user-identity-box-group-staff' )->escaped(),
					wfMessage( 'user-identity-box-group-vstf' )->escaped()
				]
			],
			'founder with no global and multiple local rights' => [ [], [ 'threadmoderator', 'sysop' ], false, false, true,
				[
					wfMessage( 'user-identity-box-group-sysop' )->escaped(),
					wfMessage( 'user-identity-box-founder' )->escaped()
				]
			],
			'banned from chat' => [ [], [], false, true, false,
				[ wfMessage( 'user-identity-box-banned-from-chat' )->escaped() ]
			],
			'banned from chat with global rights and no local rights' => [ [ 'council' ], [], false, true, false,
				[
					wfMessage( 'user-identity-box-group-council' )->escaped(),
					wfMessage( 'user-identity-box-banned-from-chat' )->escaped()
				]
			],
			'banned from chat with local rights and no global rights' => [ [], [ 'threadmoderator' ], false, true, false,
				[
					wfMessage( 'user-identity-box-group-threadmoderator' )->escaped(),
					wfMessage( 'user-identity-box-banned-from-chat' )->escaped()
				]
			],
			'banned from chat with global and local rights' => [ [ 'council' ], [ 'sysop' ], false, true, false,
				[
					wfMessage( 'user-identity-box-group-council' )->escaped(),
					wfMessage( 'user-identity-box-banned-from-chat' )->escaped()
				]
			],
			'desysopped founder' => [ [], [], false, false, true,
				[]
			],
			'desysopped founder with global rights' => [ [ 'staff', 'helper' ], [], false, false, true,
				[
					wfMessage( 'user-identity-box-group-staff' )->escaped(),
					wfMessage( 'user-identity-box-group-helper' )->escaped()
				]
			],
			'desysopped founder with local rights' => [ [], [ 'threadmoderator', 'chatmoderator' ], false, false, true,
				[
					wfMessage( 'user-identity-box-group-threadmoderator' )->escaped(),
					wfMessage( 'user-identity-box-group-chatmoderator' )->escaped()
				]
			],
			'desysopped founder with global and local rights' => [ [ 'vanguard' ], [ 'chatmoderator' ], false, false, true,
				[
					wfMessage( 'user-identity-box-group-vanguard' )->escaped(),
					wfMessage( 'user-identity-box-group-chatmoderator' )->escaped()
				]
			],
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
