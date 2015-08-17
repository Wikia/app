<?php

namespace Wikia\Persistence\User\Preferences;

use Wikia\Domain\User\Preference;

class PreferencePersistenceMySQLTest extends \PHPUnit_Framework_TestCase {

	protected $userId = 1;
	protected $testPreference;
	protected $testSuperfluousPreference;
	protected $mysqliMockSlave;
	protected $mysqliMockMaster;
	protected $whiteListMock;

	protected function setUp() {
		$this->testPreference = new Preference( "pref-name", "pref-value" );
		$this->testSuperfluousPreference = new Preference( "extra-pref-name", "extra-pref-value" );
		$this->mysqliMockSlave = $this->getMockBuilder( '\DatabaseMysqli' )
			->setMethods( [ 'select', 'mysqlRealEscapeString' ] )
			->disableOriginalConstructor()
			->disableAutoload()
			->getMock();

		$this->mysqliMockSlave
			->method( 'mysqlRealEscapeString' )
			->will($this->returnArgument(0));

		$this->mysqliMockMaster = $this->getMockBuilder( '\DatabaseMysqli' )
			->setMethods( [ 'upsert', 'mysqlRealEscapeString' ] )
			->disableOriginalConstructor()
			->disableAutoload()
			->getMock();

		$this->mysqliMockMaster
			->method( 'mysqlRealEscapeString' )
			->will($this->returnArgument(0));

		$this->whiteListMock = [
			'literals' => [ 'pref-name' ],
			'regexes' => [ '^valid-option-name-(?:\d+)$', '^some-other-valid-(?:[\w\d-]+$' ]
		];
	}

	public function testGetSuccess() {
		$this->mysqliMockSlave->expects( $this->once() )
			->method( 'select' )
			->with( 'user_properties', [ 'up_property', 'up_value' ], [ 'up_user' => $this->userId ], $this->anything() )
			->willReturn( [
				(object) [ 'up_user' => $this->userId, 'up_property' => $this->testPreference->getName(), 'up_value' => $this->testPreference->getValue() ],
				(object) [ 'up_user' => $this->userId, 'up_property' => 'autopatrol', 'up_value' => '0' ],
				(object) [ 'up_user' => $this->userId, 'up_property' => 'date', 'up_value' => '1' ],
			] );

		$persistence = new PreferencePersistenceMySQL( $this->mysqliMockMaster, $this->mysqliMockSlave );
		$preferences = $persistence->get( $this->userId );

		$this->assertTrue( is_array( $preferences ), "expecting an array" );
		$this->assertTrue( !empty( $preferences ), "expecting a non-empty array" );
		$this->assertEquals( $preferences[ 0 ]->getName(), $this->testPreference->getName(), "expecting the test preference name" );
		$this->assertEquals( $preferences[ 0 ]->getValue(), $this->testPreference->getValue(), "expecting the test preference value" );
	}

	public function testGetEmpty() {
		$this->mysqliMockSlave->expects( $this->once() )
			->method( 'select' )
			->with( 'user_properties', [ 'up_property', 'up_value' ], [ 'up_user' => $this->userId ], $this->anything() )
			->willReturn( [ ] );

		$persistence = new PreferencePersistenceMySQL( $this->mysqliMockMaster, $this->mysqliMockSlave );
		$preferences = $persistence->get( $this->userId );

		$this->assertTrue( is_array( $preferences ), "expecting an array" );
		$this->assertTrue( empty( $preferences ), "expecting an empty array" );
	}

	public function testSave() {
		$preferences = [ $this->testPreference ];
		$this->mysqliMockMaster->expects( $this->once() )
			->method( 'upsert' )
			->with(
				PreferencePersistenceMySQL::USER_PREFERENCE_TABLE,
				PreferencePersistenceMySQL::createTuplesFromPreferences( $this->userId, $preferences ),
				[ ],
				PreferencePersistenceMySQL::$UPSERT_SET_BLOCK )
			->willReturn( true );

		$persistence = new PreferencePersistenceMySQL( $this->mysqliMockMaster, $this->mysqliMockSlave );
		$ret = $persistence->save( $this->userId, [ $this->testPreference ] );

		$this->assertTrue( $ret, "expected true" );
	}

	public function testCreateTuples() {
		$input = [ new Preference( 'name-a', 'value-a' ), new Preference( 'name-b', 'value-b' ) ];

		$output = PreferencePersistenceMySQL::createTuplesFromPreferences( $this->userId, $input );

		$this->assertTrue( is_array( $output ), "failed to create tuple array" );
		$this->assertEquals( 1, $output[ 0 ][ 'up_user' ], "user failed to match" );
		$this->assertEquals( 'name-a', $output[ 0 ][ 'up_property' ], "name failed to match" );
		$this->assertEquals( 'value-a', $output[ 0 ][ 'up_value' ], "value failed to match" );
	}

	public function testCreateTuplesEmpty() {
		$persistence = new PreferencePersistenceMySQL( $this->mysqliMockMaster, $this->mysqliMockSlave );
		$input = [ ];
		$output = PreferencePersistenceMySQL::createTuplesFromPreferences( $this->userId, $input );

		$this->assertTrue( is_array( $output ), "unexpected output" );
		$this->assertEquals( [ ], $output, "result failed to match" );
	}

	public function testGetWhiltelisted() {
		$this->mysqliMockSlave->expects( $this->once() )
			->method( 'select' )
			->with( 'user_properties',
				[ 'up_property', 'up_value' ],
				[ 'up_user' => $this->userId, "`up_property` IN ('pref-name') OR `up_property` REGEXP '^valid-option-name-(?:\d+)$|^some-other-valid-(?:[\w\d-]+$'" ],
				$this->anything()
			)->willReturn( [
				(object) [ 'up_user' => $this->userId, 'up_property' => $this->testPreference->getName(), 'up_value' => $this->testPreference->getValue() ],
				(object) [ 'up_user' => $this->userId, 'up_property' => 'autopatrol', 'up_value' => '0' ],
				(object) [ 'up_user' => $this->userId, 'up_property' => 'date', 'up_value' => '1' ],
			] );

		$persistence = new PreferencePersistenceMySQL( $this->mysqliMockMaster, $this->mysqliMockSlave, $this->whiteListMock );
		$preferences = $persistence->get( $this->userId );

		$this->assertTrue( is_array( $preferences ), "expecting an array" );
		$this->assertCount(3, $preferences, "expecting exact array size" );
		$this->assertEquals( $preferences[ 0 ]->getName(), $this->testPreference->getName(), "expecting the test preference name" );
		$this->assertEquals( $preferences[ 0 ]->getValue(), $this->testPreference->getValue(), "expecting the test preference value" );
	}

	public function testSaveWhitelisted() {
		$expected_preferences = [ $this->testPreference ];
		$input_preferences = [ $this->testPreference, $this->testSuperfluousPreference ];
		$this->mysqliMockMaster->expects( $this->once() )
			->method( 'upsert' )
			->with(
				PreferencePersistenceMySQL::USER_PREFERENCE_TABLE,
				PreferencePersistenceMySQL::createTuplesFromPreferences( $this->userId, $expected_preferences ),
				[ ],
				PreferencePersistenceMySQL::$UPSERT_SET_BLOCK )
			->willReturn( true );

		$persistence = new PreferencePersistenceMySQL( $this->mysqliMockMaster, $this->mysqliMockSlave, $this->whiteListMock );
		$ret = $persistence->save( $this->userId, $input_preferences );

		$this->assertTrue( $ret, "expected true" );
	}
}
