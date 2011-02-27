<?php

class WikiaValidatorTest extends PHPUnit_Framework_TestCase {
	protected function setUp() {
		
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param $testValue
	 * @param $expectedResult
	 * dataProvider testStringDataProvider
	 */
	/*
	public function testString($testValue, $expectedResult, $expectedError) {
		$vs = new WikiaValidatorString( array("min" => 3, "max" => 10, "required" => true ) );
		
		$this->assertEquals($expectedResult, $vs->isValid( $testValue ));
		if (!$vs->isValid( $testValue )) {
			$this->assertEquals($expectedError, $vs->getError()->getCode() );
		}
		
		
		
		
		
		
		$this->assertFalse( $vs->isValid( "01234567891" ) );	
		
		$this->assertTrue( $vs->isValid( "0123456789" ) );
		
		$this->assertTrue( $vs->isValid( "oko" ) );
		$this->assertFalse( $vs->isValid( "o" ) ); 
		$this->assertEquals('too_short', $vs->getError()->getCode()  );
		
		$this->assertFalse( $vs->isValid( "" ) );

		$vs = new WikiaValidatorString( array("min" => 3, "max" => 10 ) );
		
		$this->assertTrue( $vs->isValid( "" ) );
		$this->assertFalse( $vs->isValid( "s" ) );
		$this->assertEquals('too_short', $vs->getError()->getCode()  );
		
		$this->assertTrue( $vs->isValid( "oko" ) );
	}
	
	public function testStringDataProvider() {
		return array(
			array('01234567891', false, 'too_long'),
			array(),
			array()
		);
	} */
	
	public function testNumeric() {
		$vs = new WikiaValidatorNumeric( array("min" => -1, "max" => 10 ) );
			
		$this->assertTrue( $vs->isValid( "" ) );
		$this->assertFalse( $vs->isValid( 11 ) );
		$this->assertEquals('too_big', $vs->getError()->getCode() );
		
		$this->assertTrue( $vs->isValid( 9.1 ) );
		
		$this->assertFalse( $vs->isValid( "3w32") );
		$this->assertEquals('not_numeric', $vs->getError()->getCode() );

		$this->assertFalse( $vs->isValid( -1.1 ) );
		$this->assertEquals('too_small', $vs->getError()->getCode() );
		
		$this->assertTrue( $vs->isValid( 1 ) );
		$this->assertTrue( $vs->isValid( -1 ) );
		$this->assertTrue( $vs->isValid( 10 ) );
		$this->assertTrue( $vs->isValid( "1" ) );
	}
	
	public function testInteger() {
		$vs = new WikiaValidatorInteger( array("min" => -1, "max" => 10 ) );
		$this->assertFalse( $vs->isValid( "3w32") );
		$this->assertEquals('not_int', $vs->getError()->getCode() );
					
		$this->assertTrue( $vs->isValid( "" ) );

		$this->assertFalse( $vs->isValid( 11 ) );
		$this->assertEquals('too_big', $vs->getError()->getCode() );
		
		$this->assertFalse( $vs->isValid( 9.1 ) );

		$this->assertEquals('not_int', $vs->getError()->getCode() );
		
		$this->assertTrue( $vs->isValid( 1 ) );
		$this->assertFalse( $vs->isValid( -2 ) );
		$this->assertEquals('too_small', $vs->getError()->getCode() );
		$this->assertTrue( $vs->isValid( 10 ) );
		$this->assertTrue( $vs->isValid( "1" ) ); 
	}
	
	public function testRegex() {
		$vs = new WikiaValidatorRegex( array("pattern" => "/^(\d{1,3})\.(\d{1,3})$/", ) );
		$this->assertFalse( $vs->isValid( "TEST" ) );
		$this->assertTrue( $vs->isValid( "123.456" ) );
		$this->assertTrue( $vs->isValid( "" ) );
		$vs = new WikiaValidatorRegex( array("pattern" => "/^(\d{1,3})\.(\d{1,3})$/", "required" => true  ) );
		$this->assertFalse( $vs->isValid( "" ) );
		$this->assertTrue( $vs->isValid( "123.456" ) );
		$this->assertFalse( $vs->isValid( "TEST" ) );
	}
	
	public function testSelect() {
		$vs = new WikiaValidatorSelect( array("allowed" => array("val1", "val2") ) );
		$this->assertFalse( $vs->isValid( "val3" ) );
		$this->assertTrue( $vs->isValid( "" ) );
		$this->assertTrue( $vs->isValid( "val1" ) );
	}
	
	public function testMail() {
		$vs = new WikiaValidatorMail( );
		$this->assertFalse( $vs->isValid( "TEST" ) );
		$this->assertTrue( $vs->isValid( "test@test.pl" ) );
	}
	
	public function testValidatorsSet() {
		
		//Create a stub for the SomeClass class.
        $trueVal = $this->getMock('WikiaValidatorString');
 
        // Configure the stub.
        $trueVal->expects($this->any())
             ->method('isValid')
             ->will($this->returnValue(true));
             
        $falseVal = $this->getMock('WikiaValidatorString');
 
        // Configure the stub.
        $falseVal->expects($this->any())
             ->method('isValid')
             ->will($this->returnValue(false));             
             
		$vs = new WikiaValidatorsSet();
            
		$vs->setValidator('trueVal', $trueVal);
		$vs->setValidator('falseVal', $falseVal);
            
		$vs->isValid( array() );

		$error = $vs->getError();
            
		$this->assertArrayHasKey('falseVal' ,$error);
	}

	public function testWikiaValidatorsPropagation() {
			
	}
}