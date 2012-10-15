<?php
/**
 * Wikimedia Foundation
 *
 * LICENSE
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * @since		r98249
 * @author Katie Horn <khorn@wikimedia.org>
 */

/**
 * @see DonationInterfaceTestCase
 */
require_once dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'DonationInterfaceTestCase.php';

/**
 * TODO: Test everything. 
 * Make sure all the basic functions in the gateway_adapter are tested here. 
 * Also, the extras and their hooks firing properly and... that the fail score 
 * they give back is acted upon in the way we think it does. 
 * Hint: For that mess, use GatewayAdapter's $debugarray
 * 
 * Also, note that it barely makes sense to test the functions that need to be 
 * defined in each gateway as per the abstract class. If we did that here, we'd 
 * basically be just testing the test code. So, don't do it. 
 * Those should definitely be tested in the various gateway-specific test 
 * classes. 
 * 
 * @group Fundraising
 * @group Splunge
 * @group Gateways
 * @group DonationInterface
 */
class DonationInterface_Adapter_GatewayAdapterTestCase extends DonationInterfaceTestCase {

	/**
	 *
	 * @covers GatewayAdapter::__construct
	 * @covers GatewayAdapter::defineVarMap
	 * @covers GatewayAdapter::defineReturnValueMap
	 * @covers GatewayAdapter::defineTransactions
	 */
	public function testConstructor() {

		global $wgGlobalCollectGatewayTest;

		$wgGlobalCollectGatewayTest = true;

		$_SERVER = array();

		$_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
		$_SERVER['HTTP_HOST'] = TESTS_HOSTNAME;
		$_SERVER['SERVER_NAME'] = TESTS_HOSTNAME;
		$_SERVER['REQUEST_URI'] = '/index.php/Special:GlobalCollectGateway?form_name=TwoStepAmount';

		$payment_product_id = 11;
		
		$optionsForTestData = array(
			'form_name' => 'TwoStepAmount',
			'payment_method' => 'bt',
			'payment_submethod' => 'bt',
		);

		$options = $this->getGatewayAdapterTestDataFromSpain( $optionsForTestData );
		
		$testAdapter = TESTS_ADAPTER_DEFAULT;
		
		$gateway = new $testAdapter( $options );

        $this->assertInstanceOf( TESTS_ADAPTER_DEFAULT, $gateway );
	}

	/**
	 *
	 * @covers GatewayAdapter::__construct
	 * @covers DonationData::__construct
	 */
	public function testConstructorHasDonationData() {

		global $wgGlobalCollectGatewayTest;

		$wgGlobalCollectGatewayTest = true;

		$_SERVER = array();

		$_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
		$_SERVER['HTTP_HOST'] = TESTS_HOSTNAME;
		$_SERVER['SERVER_NAME'] = TESTS_HOSTNAME;
		$_SERVER['REQUEST_URI'] = '/index.php/Special:GlobalCollectGateway?form_name=TwoStepAmount';

		$payment_product_id = 11;
		
		$optionsForTestData = array(
			'form_name' => 'TwoStepAmount',
			'payment_method' => 'bt',
			'payment_submethod' => 'bt',
		);

		$options = $this->getGatewayAdapterTestDataFromSpain( $optionsForTestData );
		
		$testAdapter = TESTS_ADAPTER_DEFAULT;
		
		$gateway = new $testAdapter( $options );

		//please define this function only inside the TESTS_ADAPTER_DEFAULT, 
		//which should be a test adapter object that descende from one of the 
		//production adapters. 
        $this->assertInstanceOf( 'DonationData', $gateway->getDonationData() );
	}
}

