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
 * @since		r100820
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
class DonationInterface_Adapter_GlobalCollect_RealTimeBankTransferEpsTestCase extends DonationInterfaceTestCase {

	/**
	 * testBuildRequestXmlWithIssuerId820
	 *
	 * Raifeissen: 820
	 *
	 * @covers GatewayAdapter::__construct
	 * @covers GatewayAdapter::setCurrentTransaction
	 * @covers GatewayAdapter::buildRequestXML
	 * @covers GatewayAdapter::getData
	 */
	public function testBuildRequestXmlWithIssuerId820() {
		
		$optionsForTestData = array(
			'form_name' => 'TwoStepAmount',
			'payment_method' => 'rtbt',
			'payment_submethod' => 'rtbt_eps',
			'payment_product_id' => 856,
			'issuer_id' => 820,
		);

		$options = $this->getGatewayAdapterTestDataFromSpain( $optionsForTestData );

		$this->buildRequestXmlForGlobalCollect( $optionsForTestData, $options );
	}

	/**
	 * testBuildRequestXmlWithIssuerId821
	 *
	 * Volksbanken Gruppe: 821
	 *
	 * @covers GatewayAdapter::__construct
	 * @covers GatewayAdapter::setCurrentTransaction
	 * @covers GatewayAdapter::buildRequestXML
	 * @covers GatewayAdapter::getData
	 */
	public function testBuildRequestXmlWithIssuerId821() {
		
		$optionsForTestData = array(
			'form_name' => 'TwoStepAmount',
			'payment_method' => 'rtbt',
			'payment_submethod' => 'rtbt_eps',
			'payment_product_id' => 856,
			'issuer_id' => 821,
		);

		$options = $this->getGatewayAdapterTestDataFromSpain( $optionsForTestData );

		$this->buildRequestXmlForGlobalCollect( $optionsForTestData, $options );
	}

	/**
	 * testBuildRequestXmlWithIssuerId822
	 *
	 * NÖ HYPO: 822
	 *
	 * @covers GatewayAdapter::__construct
	 * @covers GatewayAdapter::setCurrentTransaction
	 * @covers GatewayAdapter::buildRequestXML
	 * @covers GatewayAdapter::getData
	 */
	public function testBuildRequestXmlWithIssuerId822() {
		
		$optionsForTestData = array(
			'form_name' => 'TwoStepAmount',
			'payment_method' => 'rtbt',
			'payment_submethod' => 'rtbt_eps',
			'payment_product_id' => 856,
			'issuer_id' => 822,
		);

		$options = $this->getGatewayAdapterTestDataFromSpain( $optionsForTestData );

		$this->buildRequestXmlForGlobalCollect( $optionsForTestData, $options );
	}

	/**
	 * testBuildRequestXmlWithIssuerId823
	 *
	 * Voralberger HYPO: 823
	 *
	 * @covers GatewayAdapter::__construct
	 * @covers GatewayAdapter::setCurrentTransaction
	 * @covers GatewayAdapter::buildRequestXML
	 * @covers GatewayAdapter::getData
	 */
	public function testBuildRequestXmlWithIssuerId823() {
		
		$optionsForTestData = array(
			'form_name' => 'TwoStepAmount',
			'payment_method' => 'rtbt',
			'payment_submethod' => 'rtbt_eps',
			'payment_product_id' => 856,
			'issuer_id' => 823,
		);

		$options = $this->getGatewayAdapterTestDataFromSpain( $optionsForTestData );

		$this->buildRequestXmlForGlobalCollect( $optionsForTestData, $options );
	}

	/**
	 * testBuildRequestXmlWithIssuerId824
	 *
	 * Bankhaus Spängler: 824
	 *
	 * @covers GatewayAdapter::__construct
	 * @covers GatewayAdapter::setCurrentTransaction
	 * @covers GatewayAdapter::buildRequestXML
	 * @covers GatewayAdapter::getData
	 */
	public function testBuildRequestXmlWithIssuerId824() {
		
		$optionsForTestData = array(
			'form_name' => 'TwoStepAmount',
			'payment_method' => 'rtbt',
			'payment_submethod' => 'rtbt_eps',
			'payment_product_id' => 856,
			'issuer_id' => 824,
		);

		$options = $this->getGatewayAdapterTestDataFromSpain( $optionsForTestData );

		$this->buildRequestXmlForGlobalCollect( $optionsForTestData, $options );
	}

	/**
	 * testBuildRequestXmlWithIssuerId825
	 *
	 * Hypo Tirol Bank: 825
	 *
	 * @covers GatewayAdapter::__construct
	 * @covers GatewayAdapter::setCurrentTransaction
	 * @covers GatewayAdapter::buildRequestXML
	 * @covers GatewayAdapter::getData
	 */
	public function testBuildRequestXmlWithIssuerId825() {
		
		$optionsForTestData = array(
			'form_name' => 'TwoStepAmount',
			'payment_method' => 'rtbt',
			'payment_submethod' => 'rtbt_eps',
			'payment_product_id' => 856,
			'issuer_id' => 825,
		);

		$options = $this->getGatewayAdapterTestDataFromSpain( $optionsForTestData );

		$this->buildRequestXmlForGlobalCollect( $optionsForTestData, $options );
	}

	/**
	 * testBuildRequestXmlWithIssuerId826
	 *
	 * Erste Bank und Sparkassen: 826
	 *
	 * @covers GatewayAdapter::__construct
	 * @covers GatewayAdapter::setCurrentTransaction
	 * @covers GatewayAdapter::buildRequestXML
	 * @covers GatewayAdapter::getData
	 */
	public function testBuildRequestXmlWithIssuerId826() {
		
		$optionsForTestData = array(
			'form_name' => 'TwoStepAmount',
			'payment_method' => 'rtbt',
			'payment_submethod' => 'rtbt_eps',
			'payment_product_id' => 856,
			'issuer_id' => 826,
		);

		$options = $this->getGatewayAdapterTestDataFromSpain( $optionsForTestData );

		$this->buildRequestXmlForGlobalCollect( $optionsForTestData, $options );
	}

	/**
	 * testBuildRequestXmlWithIssuerId827
	 *
	 * BAWAG: 827
	 *
	 * @covers GatewayAdapter::__construct
	 * @covers GatewayAdapter::setCurrentTransaction
	 * @covers GatewayAdapter::buildRequestXML
	 * @covers GatewayAdapter::getData
	 */
	public function testBuildRequestXmlWithIssuerId827() {
		
		$optionsForTestData = array(
			'form_name' => 'TwoStepAmount',
			'payment_method' => 'rtbt',
			'payment_submethod' => 'rtbt_eps',
			'payment_product_id' => 856,
			'issuer_id' => 827,
		);

		$options = $this->getGatewayAdapterTestDataFromSpain( $optionsForTestData );

		$this->buildRequestXmlForGlobalCollect( $optionsForTestData, $options );
	}

	/**
	 * testBuildRequestXmlWithIssuerId828
	 *
	 * P.S.K.: 828
	 *
	 * @covers GatewayAdapter::__construct
	 * @covers GatewayAdapter::setCurrentTransaction
	 * @covers GatewayAdapter::buildRequestXML
	 * @covers GatewayAdapter::getData
	 */
	public function testBuildRequestXmlWithIssuerId828() {
		
		$optionsForTestData = array(
			'form_name' => 'TwoStepAmount',
			'payment_method' => 'rtbt',
			'payment_submethod' => 'rtbt_eps',
			'payment_product_id' => 856,
			'issuer_id' => 828,
		);

		$options = $this->getGatewayAdapterTestDataFromSpain( $optionsForTestData );

		$this->buildRequestXmlForGlobalCollect( $optionsForTestData, $options );
	}

	/**
	 * testBuildRequestXmlWithIssuerId829
	 *
	 * Easy: 829
	 *
	 * @covers GatewayAdapter::__construct
	 * @covers GatewayAdapter::setCurrentTransaction
	 * @covers GatewayAdapter::buildRequestXML
	 * @covers GatewayAdapter::getData
	 */
	public function testBuildRequestXmlWithIssuerId829() {
		
		$optionsForTestData = array(
			'form_name' => 'TwoStepAmount',
			'payment_method' => 'rtbt',
			'payment_submethod' => 'rtbt_eps',
			'payment_product_id' => 856,
			'issuer_id' => 829,
		);

		$options = $this->getGatewayAdapterTestDataFromSpain( $optionsForTestData );

		$this->buildRequestXmlForGlobalCollect( $optionsForTestData, $options );
	}

	/**
	 * testBuildRequestXmlWithIssuerId831
	 *
	 * Sparda-Bank: 831
	 *
	 * @covers GatewayAdapter::__construct
	 * @covers GatewayAdapter::setCurrentTransaction
	 * @covers GatewayAdapter::buildRequestXML
	 * @covers GatewayAdapter::getData
	 */
	public function testBuildRequestXmlWithIssuerId831() {
		
		$optionsForTestData = array(
			'form_name' => 'TwoStepAmount',
			'payment_method' => 'rtbt',
			'payment_submethod' => 'rtbt_eps',
			'payment_product_id' => 856,
			'issuer_id' => 831,
		);

		$options = $this->getGatewayAdapterTestDataFromSpain( $optionsForTestData );

		$this->buildRequestXmlForGlobalCollect( $optionsForTestData, $options );
	}
}

