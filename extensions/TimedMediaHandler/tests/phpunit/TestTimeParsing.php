<?php 
/**
 * TestTimeParsing test .
 * 
 * @ingroup timedmedia
 * @since 0.2
 * @author Michael Dale
 */


class TestTimeParsing extends PHPUnit_Framework_TestCase {
	/**
     * Test time string to np2
    */
    function testSeconds2NptFormat() {
    	// Some time conversions:
    	$this->assertEquals( TimedMediaHandler::seconds2npt( 100 ), '0:1:40' );
    	$this->assertEquals( TimedMediaHandler::seconds2npt( 0 ), '0:0:0' );
    	$this->assertEquals( TimedMediaHandler::seconds2npt( 3601 ), '1:0:1' );
    	
    	// Test failures:
    	$this->assertEquals( TimedMediaHandler::seconds2npt( 'foo' ), false );
    	$this->assertEquals( TimedMediaHandler::seconds2npt( -1 ), false );
    }
    
	/**
     * Test time parsing to seconds
    */
    function testParseTimeString() {
    	// Some time conversions:
    	$this->assertEquals( TimedMediaHandler::parseTimeString( 100 ), 100 );
    	$this->assertEquals( TimedMediaHandler::parseTimeString( '1:0:0' ), 3600 );
    	$this->assertEquals( TimedMediaHandler::parseTimeString( -1 ), 0 );
    	// Test longer than duration check ( should return time -1 ) 
    	$this->assertEquals( TimedMediaHandler::parseTimeString( 10, 9 ), 8 );
    	
    	// Test failures:
    	$this->assertEquals( TimedMediaHandler::parseTimeString( '1:1:1:1' ), false );
    	$this->assertEquals( TimedMediaHandler::parseTimeString( 'abc' ), false );
    	
    }
}