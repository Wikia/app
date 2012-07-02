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
 * @author		Jeremy Postlethwaite <jpostlethwaite@wikimedia.org>
 */

/**
 * Test helper
 */
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'TestHelper.php';

/**
 * UnitTest_AllTests
 */
require_once dirname( __FILE__ ) . '/UnitTest/AllTests.php';

/**
 * AllTests
 */
class AllTests
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
	 * Run test suites
	 *
	 * @return PHPUnit_Framework_TestSuite
	 */
	public static function suite()
	{
				
		$suite = new PHPUnit_Framework_TestSuite( 'AllTests Suite' );

		// This is the class name of a test suite
		$suite->addTestSuite( 'UnitTest_AllTests' );

		return $suite;
	}
}

