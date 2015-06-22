<?php

namespace Wikia\Persistence\User;
use Wikia\Domain\User\PreferenceValue;
use Wikia\Persistence\User\PreferencePersistenceMySQL;

class PreferencePersistenceMySQLTest extends \PHPUnit_Framework_TestCase {

	protected $userId = 1;
	protected $testPreference;
	protected $mysqliMockSlave;
	protected $mysqliMockMaster;

	protected function setUp() {
		$this->testPreference = new PreferenceValue( "pref-name", "pref-value" );
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
			//$res = $dbr->select(
				//'user_properties',
				//'*',
				//array( 'up_user' => $this->getId() ),
				//__METHOD__
			//);
		$persistence = new PreferencePersistenceMySQL($this->mysqliMockMaster, $this->mysqliMockSlave);
		$result = $persistence->get( $this->userId );

		$this->assertTrue( is_array($result), "expecting an array" );
		$this->assertTrue( !empty($result), "expecting an array" );
		$this->assertEquals( $result[0]->getName(), $this->testPreference->getName(), "expecting the test preference name" );
		$this->assertEquals( $result[0]->getValue(), $this->testPreference->getValue(), "expecting the test preference value" );
	}
}
