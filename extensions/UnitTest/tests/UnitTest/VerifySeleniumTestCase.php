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
 * @see UnitTestSeleniumTestCase
 */
require_once dirname( dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'UnitTestSeleniumTestCase.php';

/**
 * UnitTest_VerifySeleniumTestCase
 *
 * @group UnitTest
 */
class UnitTest_VerifySeleniumTestCase extends UnitTestSeleniumTestCase
{
	
	 /**
	  * Test a functioning title
	  */
	 public function testTitle()
	 {
		 $this->open( $this->getExtensionsBrowsersUrl() );
		 
		 $this->browserScreenshot( __FUNCTION__ );
		 
		 $this->assertNotTitle('Some very long title that is probably not the real title.');
	 }
	
#	 /**
#	  * Test a non functioning title
#	  */
#	 public function testTitleBad()
#	 {
#		 $this->open( $this->getExtensionsBrowsersUrl() );
#		 
#		 $this->browserScreenshot( __FUNCTION__ );
#		 
#		 $this->assertTitle('This is most likely not the real title of this page.');
#	 }
}