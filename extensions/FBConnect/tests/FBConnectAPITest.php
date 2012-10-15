<?php

require_once( dirname( __FILE__ ) . '/../FBConnectAPI.php');
require_once( dirname( __FILE__ ) . '/../facebook-client/facebook.php');

class FBConnectApiTest extends PHPUnit_Framework_TestCase {

	protected function setUp() {
		$this->app = F::app();
	}

	protected function tearDown(){
		F::setInstance('App', $this->app);
	}

	public function testUser() {
		$anything = rand();
		$facebook = $this->getMock('Facebook', array('getUser'), array(), '', false);
		$facebook->expects($this->once())
		         ->method('getUser')
		        ->will($this->returnValue($anything));

		$fbApi = $this->getMock('FBConnectAPI', array('Facebook'));
		$fbApi->expects($this->once())
		      ->method('Facebook')
		      ->will($this->returnValue($facebook));

		$result = $fbApi->user();
		$this->assertEquals($anything, $result); 
	}

	/**
	 * @dataProvider isConfigSetupDataProvider
	 */
	public function testIsConfigSetup($expected, $fbAppId, $fbAppSecret){
		$this->fbAppId = $fbAppId;
		$this->fbAppSecret = $fbAppSecret;

		$app = $this->getMock('WikiaApp', array('getGlobal'));
		$app->expects($this->any())
		    ->method('getGlobal')
			->will($this->returnCallback(array($this, 'isConfigSetupGlobalsCallback')));
		F::setInstance('App', $app);
		$result = FBConnectAPI::isConfigSetup();
		$this->assertEquals($expected, $result);
	}

	public function isConfigSetupDataProvider() {
		return array(
			array(true, 'whatever', 'whatever'),
			array(false, null, null),
			array(false, null, 'whatever'),
			array(false, 'whatever', null),
			array(false, null, 'YOUR_SECRET'),
			array(false, 'YOUR_APP_KEY', null),
			array(false, 'YOUR_APP_KEY', 'YOUR_SECRET'),
		);
	}

	public function isConfigSetupGlobalsCallback($globalName) {
		switch($globalName) {
			case 'fbAppId': return $this->fbAppId;
			case 'fbAppSecret': return $this->fbAppSecret;
			default: return null;
		}
	}
}
