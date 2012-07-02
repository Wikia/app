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
 * @group BankTransfer
 */
class DonationInterface_Adapter_GlobalCollect_BankTransferTestCase extends DonationInterfaceTestCase {

	/**
	 * testBuildRequestXml
	 *
	 * @covers GatewayAdapter::__construct
	 * @covers GatewayAdapter::setCurrentTransaction
	 * @covers GatewayAdapter::buildRequestXML
	 * @covers GatewayAdapter::getData
	 */
	public function testBuildRequestXml() {
		
		$optionsForTestData = array(
			'form_name' => 'TwoStepAmount',
			'payment_method' => 'bt',
			'payment_submethod' => 'bt',
			'payment_product_id' => 11,
		);

		$options = $this->getGatewayAdapterTestDataFromSpain( $optionsForTestData );

		$this->buildRequestXmlForGlobalCollect( $optionsForTestData, $options );
	}
}

