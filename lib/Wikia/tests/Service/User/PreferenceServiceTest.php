<?php

namespace Wikia\Service\User;
use Wikia\Domain\User\Preference;

class PreferenceServiceTest extends \PHPUnit_Framework_TestCase {

	protected $userId = 1;
	protected $testPreference;
	protected $gatewayMock;

	protected function setUp() {
		$this->testPreference = new Preference( "pref-name", "pref-value" );
		$this->gatewayMock = $this->getMockBuilder( '\Wikia\Service\User\PreferenceGatewayInterface' )
			->setMethods( ['save', 'getWikiaUserId', 'get'] )
			->disableOriginalConstructor()
			->disableAutoload()
			->getMock();
	}

	public function testSetPreferenceSuccess() {
		$this->gatewayMock->expects( $this->once() )
			->method( 'save' )
			->with( $this->userId, [$this->testPreference] )
			->willReturn( true );
		$this->gatewayMock->expects( $this->once() )
			->method( 'getWikiaUserId' )
			->willReturn( $this->userId );

		$service = new PreferenceService( $this->gatewayMock );
		$ret = $service->setPreferences( $this->userId, [ $this->testPreference ] );

		$this->assertTrue( $ret, "the preference was not set" );
	}

	public function testSetWithEmptyPreferences() {
		$this->gatewayMock->expects( $this->exactly( 0 ) )
			->method( 'save' )
			->with( $this->userId, [] )
			->willReturn( null );

		$service = new PreferenceService( $this->gatewayMock );
		$ret = $service->setPreferences( $this->userId, [ ] );

		$this->assertFalse( $ret, "expected false when providing an empty preference set" );
	}


	/**
	 * @expectedException	\Wikia\Service\GatewayInternalErrorException
	 */
	public function testSetWithDatabaseError() {
		$this->gatewayMock->expects( $this->once() )
			->method( 'save' )
			->with( $this->userId, [$this->testPreference] )
			->will( $this->throwException( new \Wikia\Service\GatewayInternalErrorException() ) );
		$this->gatewayMock->expects( $this->once() )
			->method( 'getWikiaUserId' )
			->willReturn( $this->userId );

		$service = new PreferenceService( $this->gatewayMock );
		$ret = $service->setPreferences( $this->userId, [ $this->testPreference ] );

		$this->fail( "exception was not thrown" );
	}

	/**
	 * @expectedException	\Wikia\Service\GatewayUnauthorizedException
	 */
	public function testSetWithUnauthorizedError() {
		$this->gatewayMock->expects( $this->exactly( 0 ) )
			->method( 'save' )
			->with( $this->userId, [$this->testPreference] )
			->will( $this->throwException( new \Wikia\Service\GatewayInternalErrorException() ) );
		$this->gatewayMock->expects( $this->once() )
			->method( 'getWikiaUserId' )
			->willReturn( $this->userId + 1 );

		$service = new PreferenceService( $this->gatewayMock );
		$ret = $service->setPreferences( $this->userId, [ $this->testPreference ] );

		$this->fail( "exception was not thrown" );
	}


	public function testGetPreferencesSuccess() {
	}


}
