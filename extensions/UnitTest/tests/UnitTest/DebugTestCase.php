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
 * DebugTestCase
 *
 * Test the debug class
 */
class UnitTest_DebugTestCase extends UnitTestTestCase
{
	
	/**
	 * testDumpAnArrayForHtml
	 * 
	 * @covers Debug::dump
	 */
	public function testDumpAnArrayForHtml() {
		
		global $wgCommandLineMode;
		
		$wgCommandLineMode = false;
		
		// Turn on output buffering
		ob_start();

		Debug::dump( $_SERVER, eval(DUMP) . "\$_SERVER" );
		
		$buffer = ob_get_contents();
		
		// Erase the buffer
		ob_end_clean();
		
		$expected = '<div style="clear: both"><hr />';
		
		$this->assertStringStartsWith( $expected, $buffer );
	}
	
	/**
	 * testDumpAnArrayForCli
	 * 
	 * @covers Debug::dump
	 */
	public function testDumpAnArrayForCli() {
		
		global $wgCommandLineMode;
		
		$wgCommandLineMode = true;
		// Turn on output buffering
		ob_start();

		Debug::dump( $_SERVER, eval(DUMP) . "\$_SERVER" );
		
		$buffer = ob_get_contents();
		
		// Erase the buffer
		ob_end_clean();
		
		$expected = '--------------------------------------------------------------------------------';
		
		$this->assertStringStartsWith( $expected, $buffer );
	}
	
	/**
	 * testDumpAStringForHtml
	 * 
	 * @covers Debug::dump
	 */
	public function testDumpAStringForHtml() {
		
		global $wgCommandLineMode;
		
		$wgCommandLineMode = false;
		
		// Turn on output buffering
		ob_start();

		Debug::dump( __CLASS__, eval(DUMP) . "__CLASS__" );
		
		$buffer = ob_get_contents();
		
		// Erase the buffer
		ob_end_clean();
		
		$expected = '<div style="clear: both"><hr />';
		
		$this->assertStringStartsWith( $expected, $buffer );
	}
	
	/**
	 * testDumpAStringForCli
	 * 
	 * @covers Debug::dump
	 */
	public function testDumpAStringForCli() {
		
		global $wgCommandLineMode;
		
		$wgCommandLineMode = true;
		// Turn on output buffering
		ob_start();

		Debug::dump( __CLASS__, eval(DUMP) . "__CLASS__" );
		
		$buffer = ob_get_contents();
		
		// Erase the buffer
		ob_end_clean();
		
		$expected = '--------------------------------------------------------------------------------';
		
		$this->assertStringStartsWith( $expected, $buffer );
	}
	
	/**
	 * testDumpAStringForHtml
	 * 
	 * @covers Debug::dump
	 * @covers Debug::puke
	 */
	public function testPukeAStringForHtml() {
		
		global $wgCommandLineMode;
		
		$wgCommandLineMode = false;
		
		// Turn on output buffering
		ob_start();

		Debug::puke( __CLASS__, eval(DUMP) . "__CLASS__", false );
		
		$buffer = ob_get_contents();
		
		// Erase the buffer
		ob_end_clean();
		
		$expected = '<div style="clear: both"><hr />';
		
		$this->assertStringStartsWith( $expected, $buffer );

		$this->assertContains( 'DebugTestCase->testPukeAStringForHtml()', $buffer );
	}
	
	/**
	 * testPukeAStringForCli
	 * 
	 * @covers Debug::dump
	 * @covers Debug::puke
	 */
	public function testPukeAStringForCli() {
		
		global $wgCommandLineMode;
		
		$wgCommandLineMode = true;
		// Turn on output buffering
		ob_start();

		Debug::puke( __CLASS__, eval(DUMP) . "__CLASS__", false );
		
		$buffer = ob_get_contents();
		
		// Erase the buffer
		ob_end_clean();

		
		$expected = '--------------------------------------------------------------------------------';
		
		$this->assertStringStartsWith( $expected, $buffer );

		$this->assertContains( 'DebugTestCase->testPukeAStringForCli()', $buffer );
	}
}
