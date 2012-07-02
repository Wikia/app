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
 * @since		r100822
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
 * @group RealTimeBankTransfer
 */
class DonationInterface_Adapter_GlobalCollect_RealTimeBankTransferIdealTestCase extends DonationInterfaceTestCase {

	/**
	 * testBuildRequestXmlWithIssuerId21
	 *
	 * Rabobank: 21
	 *
	 * @covers GatewayAdapter::__construct
	 * @covers GatewayAdapter::setCurrentTransaction
	 * @covers GatewayAdapter::buildRequestXML
	 * @covers GatewayAdapter::getData
	 */
	public function testBuildRequestXmlWithIssuerId21() {
		
		$optionsForTestData = array(
			'form_name' => 'TwoStepAmount',
			'payment_method' => 'rtbt',
			'payment_submethod' => 'rtbt_ideal',
			'payment_product_id' => 809,
			'issuer_id' => 21,
		);

		$options = $this->getGatewayAdapterTestDataFromSpain( $optionsForTestData );

		$this->buildRequestXmlForGlobalCollect( $optionsForTestData, $options );
	}

	/**
	 * testBuildRequestXmlWithIssuerId31
	 *
	 * ABN AMRO: 31
	 *
	 * @covers GatewayAdapter::__construct
	 * @covers GatewayAdapter::setCurrentTransaction
	 * @covers GatewayAdapter::buildRequestXML
	 * @covers GatewayAdapter::getData
	 */
	public function testBuildRequestXmlWithIssuerId31() {
		
		$optionsForTestData = array(
			'form_name' => 'TwoStepAmount',
			'payment_method' => 'rtbt',
			'payment_submethod' => 'rtbt_ideal',
			'payment_product_id' => 809,
			'issuer_id' => 31,
		);

		$options = $this->getGatewayAdapterTestDataFromSpain( $optionsForTestData );

		$this->buildRequestXmlForGlobalCollect( $optionsForTestData, $options );
	}

	/**
	 * testBuildRequestXmlWithIssuerId91
	 *
	 * Friesland Bank: 91
	 *
	 * @covers GatewayAdapter::__construct
	 * @covers GatewayAdapter::setCurrentTransaction
	 * @covers GatewayAdapter::buildRequestXML
	 * @covers GatewayAdapter::getData
	 */
	public function testBuildRequestXmlWithIssuerId91() {
		
		$optionsForTestData = array(
			'form_name' => 'TwoStepAmount',
			'payment_method' => 'rtbt',
			'payment_submethod' => 'rtbt_ideal',
			'payment_product_id' => 809,
			'issuer_id' => 91,
		);

		$options = $this->getGatewayAdapterTestDataFromSpain( $optionsForTestData );

		$this->buildRequestXmlForGlobalCollect( $optionsForTestData, $options );
	}

	/**
	 * testBuildRequestXmlWithIssuerId161
	 *
	 * Van Lanschot Bankiers: 161
	 *
	 * @covers GatewayAdapter::__construct
	 * @covers GatewayAdapter::setCurrentTransaction
	 * @covers GatewayAdapter::buildRequestXML
	 * @covers GatewayAdapter::getData
	 */
	public function testBuildRequestXmlWithIssuerId161() {
		
		$optionsForTestData = array(
			'form_name' => 'TwoStepAmount',
			'payment_method' => 'rtbt',
			'payment_submethod' => 'rtbt_ideal',
			'payment_product_id' => 809,
			'issuer_id' => 161,
		);

		$options = $this->getGatewayAdapterTestDataFromSpain( $optionsForTestData );

		$this->buildRequestXmlForGlobalCollect( $optionsForTestData, $options );
	}

	/**
	 * testBuildRequestXmlWithIssuerId511
	 *
	 * Triodos Bank: 511
	 *
	 * @covers GatewayAdapter::__construct
	 * @covers GatewayAdapter::setCurrentTransaction
	 * @covers GatewayAdapter::buildRequestXML
	 * @covers GatewayAdapter::getData
	 */
	public function testBuildRequestXmlWithIssuerId511() {
		
		$optionsForTestData = array(
			'form_name' => 'TwoStepAmount',
			'payment_method' => 'rtbt',
			'payment_submethod' => 'rtbt_ideal',
			'payment_product_id' => 809,
			'issuer_id' => 511,
		);

		$options = $this->getGatewayAdapterTestDataFromSpain( $optionsForTestData );

		$this->buildRequestXmlForGlobalCollect( $optionsForTestData, $options );
	}

	/**
	 * testBuildRequestXmlWithIssuerId721
	 *
	 * ING: 721
	 *
	 * @covers GatewayAdapter::__construct
	 * @covers GatewayAdapter::setCurrentTransaction
	 * @covers GatewayAdapter::buildRequestXML
	 * @covers GatewayAdapter::getData
	 */
	public function testBuildRequestXmlWithIssuerId721() {
		
		$optionsForTestData = array(
			'form_name' => 'TwoStepAmount',
			'payment_method' => 'rtbt',
			'payment_submethod' => 'rtbt_ideal',
			'payment_product_id' => 809,
			'issuer_id' => 721,
		);

		$options = $this->getGatewayAdapterTestDataFromSpain( $optionsForTestData );

		$this->buildRequestXmlForGlobalCollect( $optionsForTestData, $options );
	}

	/**
	 * testBuildRequestXmlWithIssuerId751
	 *
	 * SNS Bank: 751
	 *
	 * @covers GatewayAdapter::__construct
	 * @covers GatewayAdapter::setCurrentTransaction
	 * @covers GatewayAdapter::buildRequestXML
	 * @covers GatewayAdapter::getData
	 */
	public function testBuildRequestXmlWithIssuerId751() {
		
		$optionsForTestData = array(
			'form_name' => 'TwoStepAmount',
			'payment_method' => 'rtbt',
			'payment_submethod' => 'rtbt_ideal',
			'payment_product_id' => 809,
			'issuer_id' => 751,
		);

		$options = $this->getGatewayAdapterTestDataFromSpain( $optionsForTestData );

		$this->buildRequestXmlForGlobalCollect( $optionsForTestData, $options );
	}

	/**
	 * testBuildRequestXmlWithIssuerId761
	 *
	 * ASN Bank: 761
	 *
	 * @covers GatewayAdapter::__construct
	 * @covers GatewayAdapter::setCurrentTransaction
	 * @covers GatewayAdapter::buildRequestXML
	 * @covers GatewayAdapter::getData
	 */
	public function testBuildRequestXmlWithIssuerId761() {
		
		$optionsForTestData = array(
			'form_name' => 'TwoStepAmount',
			'payment_method' => 'rtbt',
			'payment_submethod' => 'rtbt_ideal',
			'payment_product_id' => 809,
			'issuer_id' => 761,
		);

		$options = $this->getGatewayAdapterTestDataFromSpain( $optionsForTestData );

		$this->buildRequestXmlForGlobalCollect( $optionsForTestData, $options );
	}

	/**
	 * testBuildRequestXmlWithIssuerId771
	 *
	 * RegioBank: 771
	 *
	 * @covers GatewayAdapter::__construct
	 * @covers GatewayAdapter::setCurrentTransaction
	 * @covers GatewayAdapter::buildRequestXML
	 * @covers GatewayAdapter::getData
	 */
	public function testBuildRequestXmlWithIssuerId771() {
		
		$optionsForTestData = array(
			'form_name' => 'TwoStepAmount',
			'payment_method' => 'rtbt',
			'payment_submethod' => 'rtbt_ideal',
			'payment_product_id' => 809,
			'issuer_id' => 771,
		);

		$options = $this->getGatewayAdapterTestDataFromSpain( $optionsForTestData );

		$this->buildRequestXmlForGlobalCollect( $optionsForTestData, $options );
	}
}

