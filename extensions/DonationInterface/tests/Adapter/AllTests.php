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
 * @see DonationInterface_Adapter_ServerTestCase
 */
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'GatewayAdapterTestCase.php';
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'GlobalCollect/AllTests.php';

/**
 * AllTests
 */
class DonationInterface_Adapter_AllTests
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

		$suite->addTestSuite( 'DonationInterface_Adapter_GatewayAdapterTestCase' );                                                             
		$suite->addTestSuite( 'DonationInterface_Adapter_GlobalCollect_AllTests' );                                                             

		return $suite;
	}
}
