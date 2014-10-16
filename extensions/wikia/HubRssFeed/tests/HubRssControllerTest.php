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
		$dir = dirname( __FILE__ ) . '/../';
		$this->setupFile = $dir . 'HubRssFeed.setup.php';

		parent::setUp();
	}

	/**
	 * @covers  HubRssFeedSpecialController::__construct
	 */
	public function testConstruct() {
		$mock = $this->getMockBuilder( 'HubRssFeedSpecialController' )
			->setMethods( ['notfound'] )
			->getMock();

		$refl = new \ReflectionObject($mock);
		$prop = $refl->getProperty( 'currentTitle' );
		$prop->setAccessible( true );

		$val = $prop->getValue( $mock );
		$this->assertInstanceOf( 'Title', $val );

	}

	/**
	 * @covers  HubRssFeedSpecialController::notfound
	 */
	public function testNotFound() {
		$this->mockGlobalVariable('wgHubRssFeeds', ['Hub1', 'Hub2']);

		$mockTitle = $this->getMockBuilder( 'Title' )
			->disableOriginalConstructor()
			->setMethods( ['getFullUrl'] )
			->getMock();

		$mockTitle->expects( $this->any() )
			->method( 'getFullUrl' )
			->will( $this->returnValue( 'abc' ) );

		$mock = $this->getMockBuilder( 'HubRssFeedSpecialController' )
			->disableOriginalConstructor()
			->setMethods( ['__construct', 'setVal'] )
			->getMock();

		$mock->expects( $this->once() )
			->method( 'setVal' )
			->with( 'links', [
				'abc/Hub1',
				'abc/Hub2'
			] );

		$mock->currentTitle = $mockTitle;

		$mock->wg = new StdClass();

		$mock->notfound();

	}


	/**
	 * @covers  HubRssFeedSpecialController::index
	 */
	public function testIndexNotFound() {
		$mock = $this->getMockBuilder( 'HubRssFeedSpecialController' )
			->disableOriginalConstructor()
			->setMethods( ['forward', 'setVal'] )
			->getMock();

		$mockRequest = $this->getMockBuilder( 'WikiaRequest' )
			->setMethods( ['getParams'] )
			->disableOriginalConstructor()
			->getMock();

		$mockRequest->expects( $this->any() )
			->method( 'getVal' )
			->will( $this->returnValue( ['par' => 'XyZ'] ) );

		$mockTitle = $this->getMockBuilder( 'Title' )
			->disableOriginalConstructor()
			->setMethods( ['getFullUrl'] )
			->getMock();

		$mock->expects( $this->once() )
			->method( 'forward' )
			->with( 'HubRssFeedSpecial', 'notfound' );

		$mock->currentTitle = $mockTitle;
		$mock->request = $mockRequest;
		$mock->index();
	}

}
