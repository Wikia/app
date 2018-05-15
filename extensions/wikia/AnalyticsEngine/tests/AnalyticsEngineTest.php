<?php

use PHPUnit\Framework\TestCase;

class AnalyticsEngineTest extends TestCase {

	/** @var RequestContext $requestContext */
	private $requestContext;

	protected function setUp() {
		parent::setUp();

		$this->requestContext = new RequestContext();
	}

	/**
	 * @dataProvider viewActionsProvider
	 *
	 * @param string $actionName
	 * @throws MWException
	 */
	public function testAddModuleForOasisSkin( string $actionName ) {
		$skin = Skin::newFromKey( 'oasis' );

		$this->requestContext->setSkin( $skin );
		$this->requestContext->setRequest( new FauxRequest( [ 'action' => $actionName ] ) );

		$modules = [];

		AnalyticsEngine::onWikiaSkinTopShortTTLModules( $modules, $skin );

		$this->assertContains( AnalyticsEngine::ANALYTICS_MODULE, $modules );
	}

	public function viewActionsProvider() {
		yield [ null ];
		yield [ 'view' ];
	}

	/**
	 * @dataProvider editActionsProvider
	 *
	 * @param string $actionName
	 * @throws MWException
	 */
	public function testDoesNotAddModuleForOasisSkinEditPage( string $actionName ) {
		$skin = Skin::newFromKey( 'oasis' );

		$this->requestContext->setSkin( $skin );
		$this->requestContext->setRequest( new FauxRequest( [ 'action' => $actionName ] ) );

		$modules = [];

		AnalyticsEngine::onWikiaSkinTopShortTTLModules( $modules, $skin );

		$this->assertNotContains( AnalyticsEngine::ANALYTICS_MODULE, $modules );
	}

	public function editActionsProvider() {
		yield [ 'edit' ];
		yield [ 'submit' ];
	}

	/**
	 * @dataProvider allActionsProvider
	 *
	 * @param string $actionName
	 * @throws MWException
	 */
	public function testDoesNotAddModuleForNonOasisSkin( string $actionName ) {
		$skin = Skin::newFromKey( 'monobook' );

		$this->requestContext->setSkin( $skin );
		$this->requestContext->setRequest( new FauxRequest( [ 'action' => $actionName ] ) );

		$modules = [];

		AnalyticsEngine::onWikiaSkinTopShortTTLModules( $modules, $skin );

		$this->assertNotContains( AnalyticsEngine::ANALYTICS_MODULE, $modules );
	}

	/**
	 * @dataProvider allActionsProvider
	 *
	 * @param string $actionName
	 * @throws MWException
	 */
	public function testDoesNotAddModuleForOasisSkinWhenNoExternalsPresent( string $actionName ) {
		$skin = Skin::newFromKey( 'oasis' );

		$this->requestContext->setSkin( $skin );
		$this->requestContext->setRequest( new FauxRequest( [ 'action' => $actionName, 'noexternals' => 1 ] ) );

		$modules = [];

		AnalyticsEngine::onWikiaSkinTopShortTTLModules( $modules, $skin );

		$this->assertNotContains( AnalyticsEngine::ANALYTICS_MODULE, $modules );
	}

	public function allActionsProvider() {
		yield [ null ];
		yield [ 'edit' ];
		yield [ 'view' ];
		yield [ 'submit' ];
	}
}
