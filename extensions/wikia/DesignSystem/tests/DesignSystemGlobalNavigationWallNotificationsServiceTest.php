<?php

class DesignSystemGlobalNavigationWallNotificationsServiceTest extends WikiaBaseTest {
	/** @var User|PHPUnit_Framework_MockObject_MockObject $userMock */
	private $userMock;

	/** @var RequestContext $context */
	private $context;

	/** @var WikiaResponse $response */
	private $response;

	/** @var DesignSystemGlobalNavigationWallNotificationsService $service */
	private $service;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../services/DesignSystemGlobalNavigationWallNotificationsService.class.php';

		$this->userMock = $this->createMock( User::class );

		$this->context = new RequestContext();
		$this->context->setUser( $this->userMock );

		$this->response = new WikiaResponse( WikiaResponse::FORMAT_HTML );

		$this->service = new DesignSystemGlobalNavigationWallNotificationsService();
		$this->service->setContext( $this->context );
		$this->service->setResponse( $this->response );

		$this->mockGlobalVariable( 'wgEnableWallExt', true );
	}

	/**
	 * Test that the Wall Notifications module is added if the user is logged in
	 * and has read permissions.
	 */
	public function testModuleIsAddedIfUserIsLoggedInAndHasReadRights() {
		$this->userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( true );

		$this->userMock->expects( $this->once() )
			->method( 'isAllowed' )
			->with( 'read' )
			->willReturn( true );

		$this->service->Index();

		$response = $this->response->getData();
		$modules = $this->context->getOutput()->getModules();

		$this->assertTrue( $response['loggedIn'] );
		$this->assertFalse( $response['prehide'] );
		$this->assertContains( 'ext.designSystem.wallNotifications', $modules );
	}

	/**
	 * Test that the Wall Notifications module is not added if the user is not logged in.
	 *
	 * @dataProvider provideUserRights
	 * @param bool $canUserRead
	 */
	public function testModuleIsNotAddedIfUserIsNotLoggedIn( bool $canUserRead ) {
		$this->userMock->expects( $this->any() )
			->method( 'isLoggedIn' )
			->willReturn( false );

		$this->userMock->expects( $this->any() )
			->method( 'isAllowed' )
			->with( 'read' )
			->willReturn( $canUserRead );

		$this->service->Index();

		$response = $this->response->getData();
		$modules = $this->context->getOutput()->getModules();

		$this->assertFalse( $response['loggedIn'] );
		$this->assertArrayNotHasKey( 'prehide', $response );
		$this->assertNotContains( 'ext.designSystem.wallNotifications', $modules );
	}

	public function provideUserRights() {
		return [
			'user with read rights' => [ true ],
		    'user without read rights' => [ false ],
		];
	}

	/**
	 * Test that the Wall Notifications module is not added if the user does not have read rights.
	 *
	 * @dataProvider provideUserLoginStatuses
	 * @param bool $isLoggedIn
	 */
	public function testModuleIsNotAddedIfUserIsLoggedInButDoesNotHaveReadRights( bool $isLoggedIn ) {
		$this->userMock->expects( $this->any() )
			->method( 'isLoggedIn' )
			->willReturn( $isLoggedIn );

		$this->userMock->expects( $this->any() )
			->method( 'isAllowed' )
			->with( 'read' )
			->willReturn( false );

		$this->service->Index();

		$response = $this->response->getData();
		$modules = $this->context->getOutput()->getModules();

		$this->assertEquals( $isLoggedIn, $response['loggedIn'] );
		$this->assertArrayNotHasKey( 'prehide', $response );
		$this->assertNotContains( 'ext.designSystem.wallNotifications', $modules );
	}

	public function provideUserLoginStatuses() {
		return [
			'logged-in user' => [ true ],
		    'anonymous user' => [ false ],
		];
	}

	/**
	 * Test that the Wall Notifications module is hidden if the user is logged in
	 * and has read permissions, but both Wall and Forum are disabled.
	 */
	public function testPrehideIsOnIfUserIsLoggedInAndHasReadRightsButBothWallAndForumAreDisabled() {
		$this->mockGlobalVariable( 'wgEnableWallExt', false );
		$this->mockGlobalVariable( 'wgEnableForumExt', false );

		$this->userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( true );

		$this->userMock->expects( $this->once() )
			->method( 'isAllowed' )
			->with( 'read' )
			->willReturn( true );

		$this->service->Index();

		$response = $this->response->getData();
		$modules = $this->context->getOutput()->getModules();

		$this->assertTrue( $response['loggedIn'] );
		$this->assertTrue( $response['prehide'] );
		$this->assertContains( 'ext.designSystem.wallNotifications', $modules );
	}
}
