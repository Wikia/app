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
 *
 * @since		r98249
 * @author		Jeremy Postlethwaite <jpostlethwaite@wikimedia.org>
 */

/**
 * @see DonationInterface_Adapter_GlobalCollect_GlobalCollectTestCase
 */
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'GlobalCollectTestCase.php';

/**
 * @see DonationInterface_Adapter_GlobalCollect_GlobalCollectTestCase
 */
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'BankTransferTestCase.php';

/**
 * @see DonationInterface_Adapter_GlobalCollect_RealTimeBankTransferEnetsTestCase
 */
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'RealTimeBankTransferEnetsTestCase.php';

/**
 * @see DonationInterface_Adapter_GlobalCollect_RealTimeBankTransferEpsTestCase
 */
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'RealTimeBankTransferEpsTestCase.php';

/**
 * @see DonationInterface_Adapter_GlobalCollect_RealTimeBankTransferIdealTestCase
 */
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'RealTimeBankTransferIdealTestCase.php';

/**
 * @see DonationInterface_Adapter_GlobalCollect_RealTimeBankTransferNordeaSwedenTestCase
 */
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'RealTimeBankTransferNordeaSwedenTestCase.php';

/**
 * @see DonationInterface_Adapter_GlobalCollect_RealTimeBankTransferSofortuberweisungTestCase
 */
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'RealTimeBankTransferSofortuberweisungTestCase.php';

/**
 * AllTests
 */
class DonationInterface_Adapter_GlobalCollect_AllTests
{

	/**
	 * Run the main test and load any parameters if needed.
	 *
	 */
	public static function main()
	{
		$parameters = array();

		PHPUnit_TextUI_TestRunner::run( self::suite(), $parameters );
	}

	/**
	 * Regular suite
	 *
	 * All tests except those that require output buffering.
	 *
	 * @return PHPUnit_Framework_TestSuite
	 */
	public static function suite()
	{
		$suite = new PHPUnit_Framework_TestSuite( 'Donation Interface - Adapter Suite' );

		// General adapter tests
		$suite->addTestSuite( 'DonationInterface_Adapter_GlobalCollect_GlobalCollectTestCase' );                                                             

		// Bank transfer tests
		$suite->addTestSuite( 'DonationInterface_Adapter_GlobalCollect_BankTransferTestCase' );                                                             

		// Real time bank transfer tests
		
		// eNets
		$suite->addTestSuite( 'DonationInterface_Adapter_GlobalCollect_RealTimeBankTransferEnetsTestCase' );
		
		// eps Online-Überweisung
		$suite->addTestSuite( 'DonationInterface_Adapter_GlobalCollect_RealTimeBankTransferEpsTestCase' );
		
		// Ideal
		$suite->addTestSuite( 'DonationInterface_Adapter_GlobalCollect_RealTimeBankTransferIdealTestCase' );
		
		// Nordea (Sweden)
		$suite->addTestSuite( 'DonationInterface_Adapter_GlobalCollect_RealTimeBankTransferNordeaSwedenTestCase' );
		
		// eNETS
		$suite->addTestSuite( 'DonationInterface_Adapter_GlobalCollect_RealTimeBankTransferSofortuberweisungTestCase' );                                                             

		return $suite;
	}
}
