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
 * TemplateTestCase
 */
require_once 'TemplateTestCase.php';

/**
 * DebugTestCase
 */
require_once 'DebugTestCase.php';

/**
 * VerifySeleniumTestCase
 */
require_once 'VerifySeleniumTestCase.php';

/**
 * UnitTest_AllTests
 */
class UnitTest_AllTests
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
		$suite = new PHPUnit_Framework_TestSuite( 'UnitTest_AllTests ');

		//$suite->addTestSuite( 'UnitTest_DebugTestCase' );
		$suite->addTestSuite( 'UnitTest_TemplateTestCase' );
		$suite->addTestSuite( 'UnitTest_VerifySeleniumTestCase' );

		return $suite;
	}
}

