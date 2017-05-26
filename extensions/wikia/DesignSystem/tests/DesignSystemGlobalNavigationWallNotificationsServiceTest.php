<?php

use PHPUnit\Framework\TestCase;
use Wikia\Util\GlobalStateWrapper;

class DesignSystemGlobalNavigationWallNotificationsServiceTest extends TestCase {
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
	 * Test that the Wall Notifications module is not added if the user is not logged in,
	 * or does not have read rights
	 *
	 * @dataProvider provideUserRightsAndLoginStatuses
	 * @param bool $canUserRead
	 * @param bool $isLoggedIn
	 */
	public function testModuleIsNotAddedIfUserIsNotLoggedInOrDoesNotHaveReadRights(
		bool $canUserRead, bool $isLoggedIn
	) {
		$this->userMock->expects( $this->any() )
			->method( 'isLoggedIn' )
			->willReturn( $isLoggedIn );

		$this->userMock->expects( $this->any() )
			->method( 'isAllowed' )
			->with( 'read' )
			->willReturn( $canUserRead );

		$this->service->Index();

		$response = $this->response->getData();
		$modules = $this->context->getOutput()->getModules();

		$this->assertEquals( $isLoggedIn, $response['loggedIn'] );
		$this->assertArrayNotHasKey( 'prehide', $response );
		$this->assertNotContains( 'ext.designSystem.wallNotifications', $modules );
	}

	public function provideUserRightsAndLoginStatuses() {
		return [
			'logged-out user without read rights' => [ false, false ],
			'logged-out user with read rights' => [ true, false ],
		    'logged-in user without read rights' => [ false, true ],
		];
	}

	/**
	 * Test that the Wall Notifications module is hidden if the user is logged in
	 * and has read permissions, but both Wall and Forum are disabled.
	 */
	public function testPrehideIsOnIfUserIsLoggedInAndHasReadRightsButBothWallAndForumAreDisabled() {
		$wrapper = new GlobalStateWrapper( [
			'wgEnableWallExt' => false,
		    'wgEnableForumExt' => false,
		] );

		$wrapper->wrap( function () {
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
		} );
	}
}
