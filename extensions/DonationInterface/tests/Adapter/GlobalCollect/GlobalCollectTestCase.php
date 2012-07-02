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
 * @author		Jeremy Postlethwaite <jpostlethwaite@wikimedia.org>
 */

/**
 * @see DonationInterfaceTestCase
 */
require_once dirname( dirname( dirname( __FILE__ ) ) ) . DIRECTORY_SEPARATOR . 'DonationInterfaceTestCase.php';

/**
 * 
 * @group Fundraising
 * @group Gateways
 * @group DonationInterface
 * @group GlobalCollect
 */
class DonationInterface_Adapter_GlobalCollect_GlobalCollectTestCase extends DonationInterfaceTestCase {


	/**
	 * testDefineVarMap
	 *
	 * This is tested with a bank transfer from Spain.
	 *
	 * @covers GlobalCollectAdapter::__construct 
	 * @covers GlobalCollectAdapter::defineVarMap 
	 */
	public function testDefineVarMap() {

		global $wgGlobalCollectGatewayTest;

		$wgGlobalCollectGatewayTest = true;

		$options = $this->getGatewayAdapterTestDataFromSpain();
		
		$this->gatewayAdapter = new GlobalCollectAdapter( $options );
		
		$var_map = array(
			'ORDERID' => 'order_id',
			'AMOUNT' => 'amount',
			'CURRENCYCODE' => 'currency_code',
			'LANGUAGECODE' => 'language',
			'COUNTRYCODE' => 'country',
			'MERCHANTREFERENCE' => 'order_id',
			'RETURNURL' => 'returnto', 
			'IPADDRESS' => 'user_ip',
			'ISSUERID' => 'issuer_id',
			'PAYMENTPRODUCTID' => 'payment_product',
			'CVV' => 'cvv',
			'EXPIRYDATE' => 'expiration',
			'CREDITCARDNUMBER' => 'card_num',
			'FIRSTNAME' => 'fname',
			'SURNAME' => 'lname',
			'STREET' => 'street',
			'CITY' => 'city',
			'STATE' => 'state',
			'ZIP' => 'zip',
			'EMAIL' => 'email',
		);
		
		$this->assertEquals( $var_map,  $this->gatewayAdapter->getVarMap() );

	}
}

