<?php

namespace ParserHooks\Tests;

use ParserHooks\HookDefinition;

/**
 * @covers ParserHooks\HookDefinition
 *
 * @group ParserHooks
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class HookDefinitionTest extends \PHPUnit_Framework_TestCase {

	public function namesProvider() {
		return $this->arrayWrap( array(
			'foo',
			'foo bar',
			array( 'foo' ),
			array( 'foobar' ),
			array( 'foo', 'bAr' ),
			array( 'foo', 'bar', 'baz BAH', 'BAR' ),
		) );
	}

	/**
	 * @dataProvider namesProvider
	 *
	 * @param string|string[] $names
	 */
	public function testGetNames( $names ) {
		$definition = new HookDefinition( $names );
		$obtainedNames = $definition->getNames();

		$this->assertInternalType( 'array', $obtainedNames );
		$this->assertContainsOnly( 'string', $obtainedNames );
		$this->assertEquals( (array)$names, $obtainedNames );
	}

	public function parametersProvider() {
		return $this->arrayWrap( array(
			array()
		) );
	}

	/**
	 * @dataProvider parametersProvider
	 *
	 * @param array $parameters
	 */
	public function testGetParameters( array $parameters ) {
		$definition = new HookDefinition( 'foo', $parameters );

		$this->assertEquals( $parameters, $definition->getParameters() );
	}

	public function defaultParametersProvider() {
		return $this->arrayWrap( array(
			'foo',
			'foo bar',
			array( 'foo' ),
			array( 'foobar' ),
			array( 'foo', 'bAr' ),
			array( 'foo', 'bar', 'baz BAH', 'BAR' ),
		) );
	}

	/**
	 * @dataProvider namesProvider
	 *
	 * @param string|string[] $defaultParameters
	 */
	public function testGetDefaultParameters( $defaultParameters ) {
		$definition = new HookDefinition( 'foo', array(), $defaultParameters );
		$obtainedDefaultParams = $definition->getDefaultParameters();

		$this->assertInternalType( 'array', $obtainedDefaultParams );
		$this->assertContainsOnly( 'string', $obtainedDefaultParams );
		$this->assertEquals( (array)$defaultParameters, $obtainedDefaultParams );
	}

	protected function arrayWrap( array $elements ) {
		return array_map(
			function( $element ) {
				return array( $element );
			},
			$elements
		);
	}

	public function testCannotConstructWithEmptyNameList() {
		$this->setExpectedException( 'InvalidArgumentException' );
		new HookDefinition( array() );
	}

	public function testCannotConstructWithNonStringName() {
		$this->setExpectedException( 'InvalidArgumentException' );
		new HookDefinition( 42 );
	}

	public function testCannotConstructWithNonStringNames() {
		$this->setExpectedException( 'InvalidArgumentException' );
		new HookDefinition( array( 'foo', 42, 'bar' ) );
	}

	public function testCannotConstructWithNonStringDefaultArg() {
		$this->setExpectedException( 'InvalidArgumentException' );
		new HookDefinition( 'foo', array(), 42 );
	}

	public function testCannotConstructWithNonStringDefaultArgs() {
		$this->setExpectedException( 'InvalidArgumentException' );
		new HookDefinition(
			'foo',
			array(),
			array( 'foo', 42, 'bar' )
		);
	}

}
