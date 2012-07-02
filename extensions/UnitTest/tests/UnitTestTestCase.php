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
 * @file TestHelper.php
 */
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'TestHelper.php';

/**
 * @see ExtensionsTestCase
 */
require_once dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'ExtensionsTestCase.php';

/**
 * UnitTestTestCase
 *
 * Abstract PHPUnit testing class
 *
 * Extend this class for the extension UnitTest.
 */
abstract class UnitTestTestCase extends ExtensionsTestCase
{
}
