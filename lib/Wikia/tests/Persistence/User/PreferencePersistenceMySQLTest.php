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
			->setMethods( ['select' ] )
			->disableOriginalConstructor()
			->disableAutoload()
			->getMock();

		$this->mysqliMockMaster = $this->getMockBuilder( '\DatabaseMysqli' )
			->setMethods( ['update', 'delete' ] )
			->disableOriginalConstructor()
			->disableAutoload()
			->getMock();
	}

	public function testGetSuccess() {
		$this->mysqliMockSlave->expects($this->once())
			->method('select')
			->with('user_properties', '*', array( 'up_user' => $this->userId ), $this->anything())
			->willReturn([
			 [ 'up_user' => $this->userId, 'up_property' => $this->testPreference->getName(), 'up_value' => $this->testPreference->getValue() ],
			 [ 'up_user' => $this->userId, 'up_property' => 'autopatrol', 'up_value' => '0' ],
			 [ 'up_user' => $this->userId, 'up_property' => 'date', 'up_value' => '1' ],
			]);

		$persistence = new PreferencePersistenceMySQL($this->mysqliMockMaster, $this->mysqliMockSlave);
		$preferences = $persistence->get( $this->userId );

		$this->assertTrue( is_array($preferences), "expecting an array" );
		$this->assertTrue( !empty($preferences), "expecting a non-empty array" );
		$this->assertEquals( $preferences[0]->getName(), $this->testPreference->getName(), "expecting the test preference name" );
		$this->assertEquals( $preferences[0]->getValue(), $this->testPreference->getValue(), "expecting the test preference value" );
	}

	public function testGetEmpty() {
		$this->mysqliMockSlave->expects($this->once())
			->method('select')
			->with('user_properties', '*', array( 'up_user' => $this->userId ), $this->anything())
			->willReturn([]);

		$persistence = new PreferencePersistenceMySQL($this->mysqliMockMaster, $this->mysqliMockSlave);
		$preferences = $persistence->get( $this->userId );

		$this->assertTrue( is_array($preferences), "expecting an array" );
		$this->assertTrue( empty($preferences), "expecting an empty array" );
	}
}
