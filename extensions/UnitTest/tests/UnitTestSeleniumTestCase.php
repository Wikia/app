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
 * @see TestHelper.php
 */
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'TestHelper.php';

/**
 * @see ExtensionsSeleniumTestCase
 */
require_once dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'ExtensionsSeleniumTestCase.php';

/**
 * UnitTestSeleniumTestCase
 *
 * Abstract Selenium testing class
 *
 * Extend this class for the extension UnitTest.
 */
abstract class UnitTestSeleniumTestCase extends ExtensionsSeleniumTestCase
{
	public static $browsers = array(
		array(
			'name'    => 'Firefox on Mac',
			'browser' => '*firefox /Applications/Firefox.app/Contents/MacOS/firefox-bin',
			'host'    => 'localhost',
			'port'    => 4444,
			'timeout' => 30000,
		)
	);

	/**
	 * setExtensionName
	 * 
	 * Set the extension name
	 *
	 * @see $extensionName
	 */
	protected function setExtensionName()
	{
		$this->extensionName = 'UnitTest';
	}
	
	/**
	 * Set unitTestBasePath
	 *
	 * Implement this prototype with the following line:
	 *
	 * @example $this->unitTestBasePath = realpath( dirname( dirname( __FILE__ ) ) );
	 *
	 */
	protected function setUnitTestBasePath()
	{
		$this->unitTestBasePath = realpath( dirname( __FILE__ ) );
	}

	/**
	 * Test Selenese files
	 */
	public function testSelenese()
	{
		$this->runSeleneseFiles();
	}
}
