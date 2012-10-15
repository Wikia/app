<?php

/**
 * @fixme wfGetIP() in minfraud.body.php wonks this up
 */
require_once "PHPUnit/Framework.php";

class minfraudTest extends PHPUnit_Framework_TestCase {

	protected function setUp() {
		$dir = dirname( __FILE__ ) . '/';
		require_once( $dir . '../../extras.php' );
		require_once( $dir . '../minfraud.body.php' );
		global $wgDonationInterfaceExtrasLog;
		$wgDonationInterfaceExtrasLog = dirname( __FILE__ ) . "/test_log";
		$license_key = 'XBCKSF4gnHA7';
		global $wgPayflowProGatewayTest;
		$wgPayflowProGatewayTest = true;
		$adapter = new PayflowProAdapter();
		$this->fixture = new Gateway_Extras_MinFraud( &$adapter, $license_key );
	}

	protected function tearDown() {
		global $wgDonationInterfaceExtrasLog;
		unlink( $wgDonationInterfaceExtrasLog );
	}

	public function testCcfdInstance() {
		$ccfd_instance_test = $this->fixture->get_ccfd() instanceof CreditCardFraudDetection;
		$this->assertTrue( $ccfd_instance_test );
	}

	/**
	 * @dataProvider queryDataProvider
	 */
	public function testBuildQuery( $data ) {
		$query = $this->fixture->build_query( $data );
		$this->assertArrayHasKey( "i", $query );
		$this->assertArrayHasKey( "user_agent", $query );
		$this->assertArrayHasKey( "city", $query );
		$this->assertArrayHasKey( "region", $query );
		$this->assertArrayHasKey( "postal", $query );
		$this->assertArrayHasKey( "country", $query );
		$this->assertArrayHasKey( "domain", $query );
		$this->assertArrayHasKey( "emailMD5", $query );
		$this->assertArrayHasKey( "bin", $query );
		$this->assertArrayHasKey( "txnID", $query );
		$this->assertArrayNotHasKey( "foo", $query ); // make sure we're not adding extraneous info
		$this->assertNotContains( "@", $query['domain'] ); // make sure we're only getting domains from email addresses
		$this->assertEquals( 6, strlen( $query['bin'] ) ); // make sure our bin is 6 digits long
	}

	public function queryDataProvider() {
		$data = array(
			array(
				array(
					"city" => 'san francisco',
					"state" => 'ca',
					"zip" => '94104',
					"country" => 'US',
					"email" => 'test@example.com',
					"card_num" => "378282246310005",
					"contribution_tracking_id" => "banana",
					"foo" => "bar"
				)
			)
		);
		return $data;
	}

	/**
	 * @dataProvider queryDataProvider
	 */
	/* 	public function testQueryMinfraud( $data ) {
	  $query = $this->fixture->build_query( $data );
	  $this->fixture->query_minfraud( $query );
	  $this->assertType( 'array', $this->fixture->minfraud_response );
	  } */

	/**
	 * @dataProvider hashValidateFalseData
	 */
	public function testValidateMinfraudHashFalse( $data ) {
		$this->assertFalse( $this->fixture->validate_minfraud_query( $data ) );
	}

	public function setExtrasGlobal( $varname, $value ) {
		//Just set the one for the adapter. 
		$adapter_prefix = $this->fixture->gateway_adapter->getGlobalPrefix();
		$globalname = $adapter_prefix . $varname;
		global $$globalname;
		$$globalname = $value;
	}

	public function hashValidateFalseData() {
		return array(
			array(
				array( ),
				array( 'license_key' => 'a' ),
				array(
					'license_key' => 'a',
					'i' => 'a',
				),
				array(
					'license_key' => 'a',
					'i' => 'a',
					'city' => 'a'
				),
				array(
					'license_key' => 'a',
					'i' => 'a',
					'city' => 'a',
					'region' => 'a'
				),
				array(
					'license_key' => 'a',
					'i' => 'a',
					'city' => 'a',
					'region' => 'a',
					'postal' => 'a',
				),
				array(
					'license_key' => 'a',
					'country' => 'a',
				)
			)
		);
	}

	/**
	 * @dataProvider hashValidateTrueData
	 */
	public function testValidateMinfraudHashTrue( $data ) {
		$this->assertTrue( $this->fixture->validate_minfraud_query( $data ) );
	}

	public function hashValidateTrueData() {
		return array(
			array(
				array(
					'license_key' => 'a',
					'i' => 'a',
					'city' => 'a',
					'region' => 'a',
					'postal' => 'a',
					'country' => 'a'
				)
			)
		);
	}

	/**
	 * @dataProvider determineActionsData
	 */
	public function testDetermineActions( $risk_score, $action_ranges, $expected ) {
		$this->fixture->action_ranges = $action_ranges;
		$this->assertEquals( $expected, $this->fixture->determine_action( $risk_score ) );
	}

	public function determineActionsData() {
		return array(
			array( '0.1', array( 'process' => array( 0, 100 ) ), 'process' ),
			array( '75.04', array( 'process' => array( 0, 50 ), 'reject' => array( '50.01', '100' ) ), 'reject' ),
		);
	}

	public function testLogging() {
		global $wgDonationInterfaceExtrasLog;
		$this->fixture->log( '', '', "\"foo\"" );
		$new_fh = fopen( $wgDonationInterfaceExtrasLog, 'r' );
		$this->assertEquals( '"' . date( 'c' ) . '"' . "\t\"\"\t\"\"\t\"foo\"\n", fread( $new_fh, filesize( $wgDonationInterfaceExtrasLog ) ) );
		fclose( $new_fh );
	}

	public function testGenerateHash() {
		$this->setExtrasGlobal( 'Salt', 'salt' );
		$this->assertEquals( '5a9ee1e4a15adbf03b3ef9f7baa6caffa9f6bcd72c736498f045c073e57753e7b244bc97fe82b075eabd80778a4d56eb14406e9a1ac4b13737b2c3fd8c3717e8', $this->fixture->generate_hash( 'foo' ) );
	}

	public function testCompareHash() {
		$this->setExtrasGlobal( 'Salt', 'salt' );
		$this->assertTrue( $this->fixture->compare_hash( '5a9ee1e4a15adbf03b3ef9f7baa6caffa9f6bcd72c736498f045c073e57753e7b244bc97fe82b075eabd80778a4d56eb14406e9a1ac4b13737b2c3fd8c3717e8', 'foo' ) );
		$this->assertFalse( $this->fixture->compare_hash( '5a9ee1e4a15adbf03b3ef9f7baa6caffa9f6bcd72c736498f045c073e57753e7b244bc97fe82b075eabd80778a4d56eb14406e9a1ac4b13737b2c3fd8c3717e8', 'bar' ) );
	}

	public function testBypassMinfraud() {
		$this->setExtrasGlobal( 'Salt', 'salt' );
		$data = array(
			'action' => '4bd7857c851039d1e07a434800fe752c6bd99aec61c325aef460441be1b95c3ab5236e43c8d06f41d77715dbd3cf94e679b86422ec3204f00ad433501e5005e9',
			'data_hash' => '029ef6f5c2a165215b5a92ff1a194e4a6de8c668d6193582da42713f119c1b07d8358b5cd94a3bd51c9aa50709c8533295215ce3cce8c2b61e69078d789bc3f3',
			'foo',
			'num_attempt' => 2
		);
		// @fixme this needs updating
		// $this->assertTrue( $this->fixture->can_bypass_minfraud( $this->fixture, $data ));
		// $this->assertEquals( 'challenge', $this->fixture->action );
		// $this->assertEquals( '029ef6f5c2a165215b5a92ff1a194e4a6de8c668d6193582da42713f119c1b07d8358b5cd94a3bd51c9aa50709c8533295215ce3cce8c2b61e69078d789bc3f3', $data[ 'data_hash' ]);

		$data[] = 'bar';
		$this->assertFalse( $this->fixture->can_bypass_minfraud( $this->fixture, $data ) );
	}

}
