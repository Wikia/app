<?php
/**
 * Created by JetBrains PhpStorm.
 * User: krzychu
 * Date: 30.10.13
 * Time: 10:47
 * To change this template use File | Settings | File Templates.
 */

namespace Wikia\api;


use ApiAccessService;

class ApiAccessServiceTest extends \WikiaBaseTest {
	private $org_wgApiAccess;
	private $wgApiEnvironment;
	private $org_wgApiEnvironment;
	private $org_wgUser;

	public function setUp() {
		global $wgApiAccess, $wgApiEnvironment, $IP, $wgUser;
		$this->org_wgApiAccess = $wgApiAccess;
		$this->org_wgApiEnvironment = $wgApiEnvironment;
		$this->org_wgUser = $wgUser;
		$wgUser = $this->mockUser(true);

		$wgApiAccess = [
			'AAA' => 111,
			'BBB' => [ 'CCC' => 333 ]
		];

		$wgApiEnvironment = 'XXX';
		$this->setupFile = $IP . "/includes/wikia/DefaultSettings.php";
		parent::setUp();
	}

	/**
	 * @return \PHPUnit_Framework_MockObject_MockObject
	 */
	public function mockUser($isAllowed) {
		$wgUser = $this->getMock("User");
		$wgUser->expects($this->any())
			->method("isAllowed")
			->will($this->returnValue($isAllowed));
		return $wgUser;
	}

	public function tearDown() {
		global $wgApiAccess, $wgApiEnvironment, $wgUser;
		$wgApiAccess = $this->org_wgApiAccess;
		$wgApiEnvironment = $this->org_wgApiEnvironment;
		$wgUser = $this->org_wgUser;
		parent::tearDown();
	}

	public function testDisallowIfUserHasNoReadPermissions() {
		global $wgUser;
		$wgUser = $this->mockUser(false);
		$subject = new ApiAccessService($this->getMockBuilder("WikiaRequest")->disableOriginalConstructor()->getMock());

		$result = $subject->canUse("FakeController", "fakeAction");

		$this->assertFalse($result);
	}

	/**
	 * @covers  ApiAccessService::getApiAccess
	 */
	public function testGetApiAccess() {
		$mock = $this->getMockBuilder( "\ApiAccessService" )
			->disableOriginalConstructor()
			->setMethods( [ '__construct' ] )
			->getMock();

		$refl = new \ReflectionMethod( $mock, 'getApiAccess' );

		$refl->setAccessible( true );
		$this->assertEquals( 111, $refl->invoke( $mock, 'AAA', null ) );
		$this->assertEquals( 333, $refl->invoke( $mock, 'BBB', 'CCC' ) );
		$this->assertEquals( 0, $refl->invoke( $mock, 'ZZZ', null ) );
	}

	/**
	 * @covers  ApiAccessService::getEnvValue
	 */
	public function testGetProductionValue() {
		$mock = $this->getMockBuilder( "\ApiAccessService" )
			->disableOriginalConstructor()
			->setMethods( [ '__construct' ] )
			->getMock();

		$prop = new \ReflectionProperty( $mock, 'envValues' );
		$prop->setAccessible( true );
		$prop->setValue( $mock, [ 'XXX' => 765 ] );

		$refl = new \ReflectionMethod( $mock, 'getEnvValue' );

		$refl->setAccessible( true );
		$this->assertEquals( 765, $refl->invoke( $mock, 'XXX' ) );

	}

	/**
	 * @covers ApiAccessService::canUse
	 * @dataProvider dp_canUse
	 */
	public function testCanUse( $access, $test, $env, $result ) {
		$mock = $this->getMockBuilder( "\ApiAccessService" )
			->disableOriginalConstructor()
			->setMethods( [ '__construct', 'getApiAccess', 'isTestLocation', 'getEnvValue' ] )
			->getMock();

		$mock->expects( $this->once() )
			->method( 'getApiAccess' )
			->will( $this->returnValue( $access ) );
		$mock->expects( $this->once() )
			->method( 'isTestLocation' )
			->will( $this->returnValue( $test ) );
		$mock->expects( $this->once() )
			->method( 'getEnvValue' )
			->will( $this->returnValue( $env ) );

		$this->assertEquals( $result, $mock->canUse( '', '' ) );
	}

	/**
	 * @covers ApiAccessService::checkUse
	 * @expectedException NotFoundApiException
	 */
	public function testCheckUse( ) {
		$mock = $this->getMockBuilder( "\ApiAccessService" )
			->disableOriginalConstructor()
			->setMethods( [ '__construct', 'canUse'] )
			->getMock();

		$mock->expects( $this->once() )
			->method( 'canUse' )
			->will( $this->returnValue( false ) );

		$mock->checkUse();
	}

	public function dp_canUse() {
		return [
			[
				\ApiAccessService::URL_TEST | 1, true, 1, true
			],
			[
				\ApiAccessService::URL_TEST | 1, false, 1, false
			],
			[
				4, false, 8, false
			],
			[
				4, false, 8 | 4, true
			]

		];
	}


}
