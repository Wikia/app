<?php

namespace Wikia\Service\User;
use Wikia\Domain\User\Preference;

class PreferenceServiceTest extends \PHPUnit_Framework_TestCase {

	protected $userId = 1;
	protected $testPreference;

	protected function setUp() {
		$this->testPreference = new Preference( "pref-name", "pref-value" );
	}

	public function testSetPreferenceSuccess() {
		$gateway = $this->getMockBuilder( '\Wikia\Service\User\PreferenceGatewayInterface' )
			->setMethods( ['save'] )
			->disableOriginalConstructor()
			->disableAutoload()
			->getMock();

		$gateway->expects( $this->once() )
			->method( 'save' )
			->with( $this->userId, [$this->testPreference] );

		$service = new PreferenceService( $gateway );
		$ret = $service->setPreference( $this->userId, $this->testPreference );

		$this->assertTrue( $ret, "the preference was not set" );
	}

}
