<?php

class DesignSystemGlobalNavigationOnSiteNotificationsServiceTest extends WikiaBaseTest {
	/** @var User|PHPUnit_Framework_MockObject_MockObject $userMock */
	private $userMock;

	/** @var RequestContext $context */
	private $context;

	/** @var DesignSystemGlobalNavigationOnSiteNotificationsService $service */
	private $service;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../services/DesignSystemGlobalNavigationOnSiteNotificationsService.class.php';

		$this->userMock = $this->createMock(User::class );

		$this->context = new RequestContext();
		$this->context->setUser( $this->userMock );

		$this->service = new DesignSystemGlobalNavigationOnSiteNotificationsService();
		$this->service->setContext( $this->context );
	}

	/**
	 * Test that the On Site Notifications JS module is added and base template is rendered
	 * if the current user is logged in.
	 */
	public function testModuleIsAddedAndRenderingIsNotSkippedIfUserIsLoggedIn() {
		$this->userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( true );

		$result = $this->service->Index();

		$modules = $this->context->getOutput()->getModules();
		$this->assertTrue( $result );
		$this->assertContains( 'ext.designSystem.onSiteNotifications', $modules );
	}

	/**
	 * Test that the On Site Notifications JS module is not added and base template is not rendered
	 * if the current user is not logged in.
	 */
	public function testModuleIsNotAddedAndRenderingIsSkippedIfUserIsNotLoggedIn() {
		$this->userMock->expects( $this->once() )
			->method( 'isLoggedIn' )
			->willReturn( false );

		$result = $this->service->Index();

		$modules = $this->context->getOutput()->getModules();
		$this->assertFalse( $result );
		$this->assertNotContains( 'ext.designSystem.onSiteNotifications', $modules );
	}
}
