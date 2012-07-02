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
 * @author Jeremy Postlethwaite <jpostlethwaite@wikimedia.org>
 */

/**
 * @see UnitTestTestCase
 */
require_once dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'UnitTestTestCase.php';

/**
 * UnitTestTemplateTestCase
 *
 * The purpose of this test suite is to verify that all of the necessary files
 * exist in the template.
 */
class UnitTest_TemplateTestCase extends UnitTestTestCase
{
	/**
	 * testToolsHasFileAllTests
	 */
	public function testToolsHasFileAllTests() {
		
		// AllTests.php
		$file = TESTS_UNITTEST_EXTENSION_ROOT . '/tools/tests-template/AllTests.php'; 
		$this->assertFileExists( $file );
		
		// TestConfiguration.php.dist
		$file = TESTS_UNITTEST_EXTENSION_ROOT . '/tools/tests-template/TestConfiguration.php.dist'; 
		$this->assertFileExists( $file );
		
		// TestHelper.php
		$file = TESTS_UNITTEST_EXTENSION_ROOT . '/tools/tests-template/TestHelper.php'; 
		$this->assertFileExists( $file );
		
		// phpunit.xml
		$file = TESTS_UNITTEST_EXTENSION_ROOT . '/tools/tests-template/phpunit.xml'; 
		$this->assertFileExists( $file );
		
		// selenium.ini.dst
		$file = TESTS_UNITTEST_EXTENSION_ROOT . '/tools/tests-template/selenium.ini.dst'; 
		$this->assertFileExists( $file );
		
		// unittest.conf.dist
		$file = TESTS_UNITTEST_EXTENSION_ROOT . '/tools/tests-template/unittest.conf.dist'; 
		$this->assertFileExists( $file );
		
		// unittest.sh
		$file = TESTS_UNITTEST_EXTENSION_ROOT . '/tools/tests-template/unittest.sh'; 
		$this->assertFileExists( $file );
	}
}
