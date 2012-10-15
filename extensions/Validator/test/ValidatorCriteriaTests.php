<?php

/**
 * Unit tests for Validators criteria.
 * 
 * @ingroup Validator
 * @since 0.4.8
 * 
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ValidatorCriteriaTests extends MediaWikiTestCase {
	
	/**
	 * Tests CriterionHasLength.
	 */
	public function testCriterionHasLength() {
		$tests = array(
			array( true, 0, 5, 'foo' ),
			array( false, 0, 5, 'foobar' ),
			array( false, 3, false, 'a' ),
			array( true, 3, false, 'aw<dfxdfwdxgtdfgdfhfdgsfdxgtffds' ),
			array( true, false, false, 'aw<dfxdfwdxgtdfgdfhfdgsfdxgtffds' ),
			array( true, false, false, '' ),
			array( false, 2, 3, '' ),
			array( true, 3, null, 'foo' ),
			array( false, 3, null, 'foobar' ),
		);
		
		foreach ( $tests as $test ) {
			$c = new CriterionHasLength( $test[1], $test[2] );
			$p = new Parameter( 'test' );
			$p->setUserValue( 'test', $test[3] );
			$this->assertEquals(
				$test[0],
				$c->validate( $p, array() )->isValid(),
				'Lenght of value "'. $test[3] . '" should ' . ( $test[0] ? '' : 'not ' ) . "be between $test[1] and $test[2] ."
			);
		}
	}
	
	/**
	 * Tests CriterionInArray.
	 */
	public function testCriterionInArray() {
		$tests = array(
			array( true, 'foo', false, array( 'foo', 'bar', 'baz' ) ),
			array( true, 'FoO', false, array( 'fOo', 'bar', 'baz' ) ),
			array( false, 'FoO', true, array( 'fOo', 'bar', 'baz' ) ),
			array( false, 'foobar', false, array( 'foo', 'bar', 'baz' ) ),
			array( false, '', false, array( 'foo', 'bar', 'baz' ) ),
			array( false, '', false, array( 'foo', 'bar', 'baz', 0 ) ),
		);
		
		foreach ( $tests as $test ) {
			$c = new CriterionInArray( $test[3], $test[2] );
			$p = new Parameter( 'test' );
			$p->setUserValue( 'test', $test[1] );
			$this->assertEquals(
				$test[0],
				$c->validate( $p, array() )->isValid(),
				'Value "'. $test[1] . '" should ' . ( $test[0] ? '' : 'not ' ) . "be in list '" . $GLOBALS['wgLang']->listToText( $test[3] ) . "'."
			);
		}
	}
	
	/**
	 * Tests CriterionInRange.
	 */
	public function testCriterionInRange() {
		$tests = array(
			array( true, '42', Parameter::TYPE_INTEGER, 0, 99 ),
			array( false, '42', Parameter::TYPE_INTEGER, 0, 9 ),
			array( true, '42', Parameter::TYPE_INTEGER, 0, false ),
			array( true, '42', Parameter::TYPE_INTEGER, false, false ),
			array( false, '42', Parameter::TYPE_INTEGER, false, 9 ),
			array( false, '42', Parameter::TYPE_INTEGER, 99, false ),
			array( false, '42', Parameter::TYPE_INTEGER, 99, 100 ),
			array( true, '42', Parameter::TYPE_INTEGER, 42, 42 ),
			array( false, '4.2', Parameter::TYPE_FLOAT, 42, 42 ),
			array( true, '4.2', Parameter::TYPE_FLOAT, 4.2, 4.2 ),
			array( true, '4.2', Parameter::TYPE_FLOAT, 0, 9 ),
			array( true, '42', Parameter::TYPE_FLOAT, 0, 99 ),
			array( false, '42', Parameter::TYPE_FLOAT, 0, 9 ),
			array( true, '-42', Parameter::TYPE_INTEGER, false, 99 ),
			array( true, '-42', Parameter::TYPE_INTEGER, -99, false ),
			array( true, '42', Parameter::TYPE_INTEGER, -99, false ),
		);
		
		foreach ( $tests as $test ) {
			$c = new CriterionInRange( $test[3], $test[4] );
			$p = new Parameter( 'test', $test[2] );
			$p->setUserValue( 'test', $test[1] );
			$this->assertEquals(
				$test[0],
				$c->validate( $p, array() )->isValid(),
				'Value "'. $test[1] . '" should ' . ( $test[0] ? '' : 'not ' ) . "be between '$test[3]' and '$test[4]'."
			);
		}
	}
	
	/**
	 * Tests CriterionIsFloat.
	 */
	public function testCriterionIsFloat() {
		$tests = array(
			array( true, '42' ),
			array( true, '4.2' ),
			array( false, '4.2.' ),
			array( false, '42.' ),
			array( false, '4a2' ),
			array( true, '-42' ),
			array( true, '-4.2' ),
			array( false, '' ),
			array( true, '0' ),
			array( true, '0.0' ),
		);
		
		foreach ( $tests as $test ) {
			$c = new CriterionIsFloat();
			$p = new Parameter( 'test' );
			$p->setUserValue( 'test', $test[1] );
			$this->assertEquals(
				$test[0],
				$c->validate( $p, array() )->isValid(),
				'Value "'. $test[1] . '" should ' . ( $test[0] ? '' : 'not ' ) . "be a float."
			);
		}
	}
	
	/**
	 * Tests CriterionIsInteger.
	 */
	public function testCriterionIsInteger() {
		$tests = array(
			array( true, '42', true ),
			array( false, '4.2', true ),
			array( false, '4.2.', true ),
			array( false, '42.', true ),
			array( false, '4a2', true ),
			array( true, '-42', true ),
			array( false, '-42', false ),
			array( false, '-4.2', true ),
			array( false, '', true ),
			array( true, '0', true ),
		);
		
		foreach ( $tests as $test ) {
			$c = new CriterionIsInteger( $test[2] );
			$p = new Parameter( 'test' );
			$p->setUserValue( 'test', $test[1] );
			$this->assertEquals(
				$test[0],
				$c->validate( $p, array() )->isValid(),
				'Value "'. $test[1] . '" should ' . ( $test[0] ? '' : 'not ' ) . "be an integer."
			);
		}
	}
	
	/**
	 * Tests CriterionUniqueItems.
	 */
	public function testCriterionUniqueItems() {
		$tests = array(
			array( true, array( 'foo', 'bar', 'baz' ), false ),
			array( true, array( 'foo', 'bar', 'baz' ), true ),
			array( false, array( 'foo', 'bar', 'baz', 'foo' ), false ),
			array( false, array( 'foo', 'bar', 'baz', 'foo' ), true ),
			array( false, array( 'foo', 'bar', 'baz', 'FOO' ), false ),
			array( true, array( 'foo', 'bar', 'baz', 'FOO' ), true ),
			array( true, array(), false ),
		);
		
		foreach ( $tests as $test ) {
			$c = new CriterionUniqueItems( $test[2] );
			$p = new ListParameter( 'test' );
			$p->setUserValue( 'test', '' );
			$p->setValue( $test[1] );
			
			$this->assertEquals(
				$test[0],
				$c->validate( $p, array() ),
				'Value "'. $test[1] . '" should ' . ( $test[0] ? '' : 'not ' ) . " have unique items."
			);
		}
	}
	
	/**
	 * Tests CriterionItemCount.
	 */
	public function testCriterionItemCount() {
		$tests = array(
			array( true, array( 'foo', 'bar', 'baz' ), 0, 5 ),
			array( false, array( 'foo', 'bar', 'baz' ), 0, 2 ),
			array( true, array( 'foo', 'bar', 'baz' ), 0, false ),
			array( true, array( 'foo', 'bar', 'baz' ), false, 99 ),
			array( true, array( 'foo', 'bar', 'baz' ), 3, 3 ),
			array( false, array(), 1, 1 ),
			array( true, array( 'foo', 'bar', 'baz' ), false, false ),
			array( true, array( 'foo', 'bar', 'baz' ), 3, null ),
			array( false, array( 'foo', 'bar', 'baz' ), 2, null ),
		);
		
		foreach ( $tests as $test ) {
			$c = new CriterionItemCount( $test[2], $test[3] );
			$p = new ListParameter( 'test' );
			$p->setUserValue( 'test', '' );
			$p->setValue( $test[1] );
			
			$this->assertEquals(
				$test[0],
				$c->validate( $p, array() ),
				'List "'. $GLOBALS['wgLang']->listToText( $test[1] ) . '" should ' . ( $test[0] ? '' : 'not ' ) . " have between and $test[2], $test[3] items."
			);
		}
	}
	
	/**
	 * Tests CriterionNotEmpty.
	 */
	public function testCriterionNotEmpty() {
		$tests = array(
			array( true, 'a' ),
			array( true, ' a ' ),
			array( false, '' ),
			array( false, '  ' ),
			array( false, "\n" ),
			array( false, " \n " ),
			array( true, " \n ." ),
		);
		
		foreach ( $tests as $test ) {
			$c = new CriterionNotEmpty();
			$p = new Parameter( 'test' );
			$p->setUserValue( 'test', $test[1] );
			
			$this->assertEquals(
				$test[0],
				$c->validate( $p, array() )->isValid(),
				'Value "'. $test[1]. '" should ' . ( !$test[0] ? '' : 'not ' ) . " be empty."
			);
		}
	}
	
}
