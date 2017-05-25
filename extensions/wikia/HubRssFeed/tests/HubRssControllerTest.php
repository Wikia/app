<?php
/**
 * Created by JetBrains PhpStorm.
 * User: suchy
 * Date: 07.10.13
 * Time: 10:19
 * To change this template use File | Settings | File Templates.
 */


class HubRssControllerTest extends WikiaBaseTest {

	public function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../HubRssFeedSpecialController.class.php';
	}

	/**
	 * @covers  HubRssFeedSpecialController::notfound
	 */
	public function testNotFound() {
		$mockTitle = $this->getMockBuilder( 'Title' )
			->disableOriginalConstructor()
			->setMethods( ['getFullUrl'] )
			->getMock();

		$mockTitle->expects( $this->any() )
			->method( 'getFullUrl' )
			->will( $this->returnValue( 'abc' ) );

		$context = new RequestContext();
		$context->setTitle( $mockTitle );

		$app = new WikiaApp( new WikiaLocalRegistry() );
		$app->wg->HubRssFeeds = [ 'Hub1', 'Hub2' ];

		$request = new WikiaRequest( [] );
		$response = new WikiaResponse( WikiaResponse::FORMAT_JSON, $request );

		$hubRssFeedSpecialController = new HubRssFeedSpecialController();

		$hubRssFeedSpecialController->setApp( $app );
		$hubRssFeedSpecialController->setContext( $context );
		$hubRssFeedSpecialController->setRequest( $request );
		$hubRssFeedSpecialController->setResponse( $response );

		$hubRssFeedSpecialController->notfound();

		$this->assertTrue( $app->wg->SupressPageSubtitle );
		$this->assertEquals( [ 'abc/Hub1', 'abc/Hub2' ], $response->getVal( 'links' ) );
	}


	/**
	 * @covers  HubRssFeedSpecialController::index
	 */
	public function testIndexNotFound() {
		$mockTitle = $this->getMockBuilder( 'Title' )
			->disableOriginalConstructor()
			->setMethods( ['getFullUrl'] )
			->getMock();

		$mockTitle->expects( $this->any() )
			->method( 'getFullUrl' )
			->will( $this->returnValue( 'abc' ) );

		$context = new RequestContext();
		$context->setTitle( $mockTitle );

		$app = new WikiaApp( new WikiaLocalRegistry() );
		$app->wg->HubRssFeeds = [ 'Hub1', 'Hub2' ];

		$request = new WikiaRequest( [ 'par' => 'XyZ' ] );
		$response = new WikiaResponse( WikiaResponse::FORMAT_JSON, $request );

		$hubRssFeedSpecialController = new HubRssFeedSpecialController();

		$hubRssFeedSpecialController->setApp( $app );
		$hubRssFeedSpecialController->setContext( $context );
		$hubRssFeedSpecialController->setRequest( $request );
		$hubRssFeedSpecialController->setResponse( $response );

		$hubRssFeedSpecialController->notfound();

		$this->assertTrue( $app->wg->SupressPageSubtitle );
		$this->assertEquals( [ 'abc/Hub1', 'abc/Hub2' ], $response->getVal( 'links' ) );
	}

}
