<?php

namespace Wikia\Service\User\Preferences;
use Wikia\Domain\User\Preference;
use Wikia\Persistence\User\Preferences\PreferencePersistence;
use Wikia\Service\PersistenceException;

class PreferenceKeyValueTest extends \PHPUnit_Framework_TestCase {

	protected $userId = 1;
	protected $testPreference;
	protected $persistenceMock;

	protected function setUp() {
		$this->testPreference = new Preference( "pref-name", "pref-value" );
		$this->persistenceMock = $this->getMockBuilder( PreferencePersistence::class )
			->setMethods( ['save', 'get'] )
			->disableOriginalConstructor()
			->disableAutoload()
			->getMock();
	}

	public function testSetPreferenceSuccess() {
		$this->persistenceMock->expects( $this->once() )
			->method( 'save' )
			->with( $this->userId, [$this->testPreference] )
			->willReturn( true );

		$service = new PreferenceKeyValueService( $this->persistenceMock );
		$ret = $service->setPreferences( $this->userId, [ $this->testPreference ] );

		$this->assertTrue( $ret, "the preference was not set" );
	}

	public function testSetWithEmptyPreferences() {
		$this->persistenceMock->expects( $this->exactly( 0 ) )
			->method( 'save' )
			->with( $this->userId, [] )
			->willReturn( null );

		$service = new PreferenceKeyValueService( $this->persistenceMock );
		$ret = $service->setPreferences( $this->userId, [ ] );

		$this->assertFalse( $ret, "expected false when providing an empty preference set" );
	}


	/**
	 * @expectedException	\Wikia\Service\PersistenceException
	 */
	public function testSetWithError() {
		$this->persistenceMock->expects( $this->once() )
			->method( 'save' )
			->with( $this->userId, [$this->testPreference] )
			->will( $this->throwException( new PersistenceException() ) );

		$service = new PreferenceKeyValueService( $this->persistenceMock );
		$ret = $service->setPreferences( $this->userId, [ $this->testPreference ] );

		$this->fail( "exception was not thrown" );
	}

	/**
	 * @expectedException	\Wikia\Service\PersistenceException
	 */
	public function testGetWithError() {
		$this->persistenceMock->expects( $this->once() )
			->method( 'get' )
			->with( $this->userId )
			->will( $this->throwException( new PersistenceException() ) );
		$service = new PreferenceKeyValueService( $this->persistenceMock );
		$service->getPreferences( $this->userId );
	}

	public function testGetPreferencesSuccess() {
		$this->persistenceMock->expects( $this->once() )
			->method( 'get' )
			->with( $this->userId )
			->willReturn(
				[ $this->testPreference ]
			);

		$service = new PreferenceKeyValueService( $this->persistenceMock );
		$preferences = $service->getPreferences( $this->userId );

		$this->assertTrue( is_array( $preferences ), "expecting an array" );
		$this->assertEquals( $this->testPreference, $preferences[0], "expecting an array" );
	}

	public function testGetPreferencesEmpty() {
		$this->persistenceMock->expects( $this->once() )
			->method( 'get' )
			->with( $this->userId )
			->willReturn( false );

		$service = new PreferenceKeyValueService( $this->persistenceMock );
		$preferences = $service->getPreferences( $this->userId );

		$this->assertTrue( is_array( $preferences ), "expecting an array" );
		$this->assertTrue( empty( $preferences ), "expecting an empty array" );
	}

	public function testEmptyGet() {
		$this->persistenceMock->expects( $this->exactly( 1 ) )
			->method( 'get' )
			->with( $this->userId )
			->willReturn( [] );

		$service = new PreferenceKeyValueService( $this->persistenceMock );
		$preferences = $service->getPreferences( $this->userId );

		$this->assertTrue( is_array( $preferences ), "expecting an array" );
		$this->assertTrue( empty( $preferences ), "expecting an empty array" );
	}

	/**
	 * @expectedException \UnexpectedValueException
	 */
	public function testGetPreferencesBadData() {
		$this->persistenceMock->expects( $this->once() )
			->method( 'get' )
			->with( $this->userId )
			->willReturn(
				[ $this->testPreference, "this should cause an exception" ]
			);

		$service = new PreferenceKeyValueService( $this->persistenceMock );
		$preferences = $service->getPreferences( $this->userId );

		$this->fail( "we should not make it here" );
	}

}
