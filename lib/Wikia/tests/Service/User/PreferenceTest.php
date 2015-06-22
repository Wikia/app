<?php

namespace Wikia\Service\User;
use Wikia\Domain\User\PreferenceValue;

class PreferenceTest extends \PHPUnit_Framework_TestCase {

	protected $userId = 1;
	protected $testPreference;
	protected $gatewayMock;

	protected function setUp() {
		$this->testPreference = new PreferenceValue( "pref-name", "pref-value" );
		$this->gatewayMock = $this->getMockBuilder( '\Wikia\Service\User\PreferencePersistence' )
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

		$service = new Preference( $this->gatewayMock );
		$ret = $service->setPreferences( $this->userId, [ $this->testPreference ] );

		$this->assertTrue( $ret, "the preference was not set" );
	}

	public function testSetWithEmptyPreferences() {
		$this->gatewayMock->expects( $this->exactly( 0 ) )
			->method( 'save' )
			->with( $this->userId, [] )
			->willReturn( null );

		$service = new Preference( $this->gatewayMock );
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

		$service = new Preference( $this->gatewayMock );
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

		$service = new Preference( $this->gatewayMock );
		$ret = $service->setPreferences( $this->userId, [ $this->testPreference ] );

		$this->fail( "exception was not thrown" );
	}


	public function testGetPreferencesSuccess() {
		$this->gatewayMock->expects( $this->once() )
			->method( 'get' )
			->with( $this->userId )
			->willReturn( [
			[ $this->testPreference->getName() => $this->testPreference->getValue() ]
			] );
		$this->gatewayMock->expects( $this->once() )
			->method( 'getWikiaUserId' )
			->willReturn( $this->userId );

		$service = new Preference( $this->gatewayMock );
		$preferences = $service->getPreferences( $this->userId );

		$this->assertTrue( is_array($preferences), "expecting an array" );
	}

	public function testGetPreferencesEmpty() {
		$this->gatewayMock->expects( $this->once() )
			->method( 'get' )
			->with( $this->userId )
			->willReturn( false );
		$this->gatewayMock->expects( $this->once() )
			->method( 'getWikiaUserId' )
			->willReturn( $this->userId );

		$service = new Preference( $this->gatewayMock );
		$preferences = $service->getPreferences( $this->userId );

		$this->assertTrue( is_array($preferences), "expecting an array" );
		$this->assertTrue( empty($preferences), "expecting an empty array" );
	}


	/**
	 * @expectedException	\Wikia\Service\GatewayUnauthorizedException
	 */
	public function testGetWithUnauthorizedError() {
		$this->gatewayMock->expects( $this->exactly( 0 ) )
			->method( 'get' )
			->with( $this->userId )
			->will( $this->throwException( new \Wikia\Service\GatewayInternalErrorException() ) );
		$this->gatewayMock->expects( $this->once() )
			->method( 'getWikiaUserId' )
			->willReturn( $this->userId + 1 );

		$service = new Preference( $this->gatewayMock );
		$ret = $service->getPreferences( $this->userId );

		$this->fail( "exception was not thrown" );
	}

	public function testEmptyGet() {
		$this->gatewayMock->expects( $this->exactly( 1 ) )
			->method( 'get' )
			->with( $this->userId )
			->willReturn( [] );
		$this->gatewayMock->expects( $this->once() )
			->method( 'getWikiaUserId' )
			->willReturn( $this->userId );

		$service = new Preference( $this->gatewayMock );
		$preferences = $service->getPreferences( $this->userId );

		$this->assertTrue( is_array($preferences), "expecting an array" );
		$this->assertTrue( empty($preferences), "expecting an empty array" );
	}

}
