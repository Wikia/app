<?php

namespace Wikia\Persistence\User;
use Wikia\Domain\User\Preference;
use Wikia\Persistence\User\PreferencePersistenceMySQL;

class PreferencePersistenceMySQLTest extends \PHPUnit_Framework_TestCase {

	protected $userId = 1;
	protected $testPreference;
	protected $mysqliMockSlave;
	protected $mysqliMockMaster;

	protected function setUp() {
		$this->testPreference = new Preference( "pref-name", "pref-value" );
		$this->mysqliMockSlave = $this->getMockBuilder( '\DatabaseMysqli' )
			->setMethods( [ 'select' ] )
			->disableOriginalConstructor()
			->disableAutoload()
			->getMock();

		$this->mysqliMockMaster = $this->getMockBuilder( '\DatabaseMysqli' )
			->setMethods( [ 'upsert' ] )
			->disableOriginalConstructor()
			->disableAutoload()
			->getMock();
	}

	public function testGetSuccess() {
		$this->mysqliMockSlave->expects( $this->once() )
			->method( 'select' )
			->with( 'user_properties', '*', array( 'up_user' => $this->userId ), $this->anything() )
			->willReturn( [
			 [ 'up_user' => $this->userId, 'up_property' => $this->testPreference->getName(), 'up_value' => $this->testPreference->getValue() ],
			 [ 'up_user' => $this->userId, 'up_property' => 'autopatrol', 'up_value' => '0' ],
			 [ 'up_user' => $this->userId, 'up_property' => 'date', 'up_value' => '1' ],
			] );

		$persistence = new PreferencePersistenceMySQL( $this->mysqliMockMaster, $this->mysqliMockSlave );
		$preferences = $persistence->get( $this->userId );

		$this->assertTrue( is_array( $preferences ), "expecting an array" );
		$this->assertTrue( !empty( $preferences ), "expecting a non-empty array" );
		$this->assertEquals( $preferences[0]->getName(), $this->testPreference->getName(), "expecting the test preference name" );
		$this->assertEquals( $preferences[0]->getValue(), $this->testPreference->getValue(), "expecting the test preference value" );
	}

	public function testGetEmpty() {
		$this->mysqliMockSlave->expects( $this->once() )
			->method( 'select' )
			->with( 'user_properties', '*', array( 'up_user' => $this->userId ), $this->anything() )
			->willReturn( [] );

		$persistence = new PreferencePersistenceMySQL( $this->mysqliMockMaster, $this->mysqliMockSlave );
		$preferences = $persistence->get( $this->userId );

		$this->assertTrue( is_array( $preferences ), "expecting an array" );
		$this->assertTrue( empty( $preferences ), "expecting an empty array" );
	}

	public function testSave() {
		$preferences = [$this->testPreference];
		$this->mysqliMockMaster->expects( $this->once() )
			->method( 'upsert' )
			->with(
				PreferencePersistenceMySQL::USER_PREFERENCE_TABLE,
				PreferencePersistenceMySQL::createTuplesFromPreferences( $this->userId, $preferences ),
				[],
			 	PreferencePersistenceMySQL::$UPSERT_SET_BLOCK )
			->willReturn( true );

		$persistence = new PreferencePersistenceMySQL( $this->mysqliMockMaster, $this->mysqliMockSlave );
		$ret = $persistence->save( $this->userId, [$this->testPreference] );

		$this->assertTrue( $ret, "expected true" );
	}

	public function testCreateTuples() {
		$input = [ new Preference( 'name-a', 'value-a' ), new Preference( 'name-b', 'value-b' ) ];

		$output = PreferencePersistenceMySQL::createTuplesFromPreferences( $this->userId, $input );

		$this->assertTrue( is_array( $output ), "failed to create tuple array" );
		$this->assertEquals( 1, $output[0]['up_user'], "user failed to match" );
		$this->assertEquals( 'name-a', $output[0]['up_property'], "name failed to match" );
		$this->assertEquals( 'value-a', $output[0]['up_value'], "value failed to match" );
	}

	public function testCreateTuplesEmpty() {
		$persistence = new PreferencePersistenceMySQL( $this->mysqliMockMaster, $this->mysqliMockSlave );
		$input = [ ];
		$output = PreferencePersistenceMySQL::createTuplesFromPreferences( $this->userId, $input );

		$this->assertTrue( is_array( $output ), "unexpected output" );
		$this->assertEquals( [], $output, "result failed to match" );
	}

}
