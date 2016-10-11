<?php

namespace ParamProcessor\Tests\Definitions;

use ParamProcessor\Options;
use ParamProcessor\ParamDefinition;
use ParamProcessor\IParamDefinition;
use ParamProcessor\Param;
use ParamProcessor\ParamDefinitionFactory;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class ParamDefinitionTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Returns a list of arrays that hold values to test handling of.
	 * Each array holds the following unnamed elements:
	 * - value (mixed, required)
	 * - valid (boolean, required)
	 * - expected (mixed, optional)
	 *
	 * ie array( '42', true, 42 )
	 *
	 * @since 0.1
	 *
	 * @param boolean $stringlyTyped
	 *
	 * @return array
	 */
	public abstract function valueProvider( $stringlyTyped = true );

	public abstract function getType();

	public function getDefinitions() {
		$params = [];

		$params['empty'] = [];

		$params['values'] = [
			'values' => [ 'foo', '1', '0.1', 'yes', 1, 0.1 ]
		];

		return $params;
	}

	public function definitionProvider() {
		$definitions = $this->getDefinitions();

		foreach ( $definitions as &$definition ) {
			$definition['type'] = $this->getType();
		}

		return $definitions;
	}

	public function getEmptyInstance() {
		return ParamDefinitionFactory::singleton()->newDefinitionFromArray( [
			'name' => 'empty',
			'message' => 'test-empty',
			'type' => $this->getType(),
		] );
	}

	public function instanceProvider() {
		$definitions = [];

		foreach ( $this->definitionProvider() as $name => $definition ) {
			if ( !array_key_exists( 'message', $definition ) ) {
				$definition['message'] = 'test-' . $name;
			}

			$definition['name'] = $name;
			$definitions[] = [ ParamDefinitionFactory::singleton()->newDefinitionFromArray( $definition ) ];
		}

		return $definitions;
	}

	/**
	 * @dataProvider instanceProvider
	 */
	public function testGetType( IParamDefinition $definition )  {
		$this->assertEquals( $this->getType(), $definition->getType() );
	}

	/**
	 * @dataProvider instanceProvider
	 */
	public function testValidate( IParamDefinition $definition ) {
		foreach ( [ true, false ] as $stringlyTyped ) {
			$values = $this->valueProvider( $stringlyTyped );
			$options = new Options();
			$options->setRawStringInputs( $stringlyTyped );

			foreach ( $values[$definition->getName()] as $data ) {
				list( $input, $valid, ) = $data;

				$param = new Param( $definition );
				$param->setUserValue( $definition->getName(), $input, $options );
				$definitions = [];
				$param->process( $definitions, [], $options );

				$this->assertEquals(
					$valid,
					$param->getErrors() === [],
					'The validation process should ' . ( $valid ? '' : 'not ' ) . 'pass'
				);
			}
		}

		$this->assertTrue( true );
	}

	/**
	 * @dataProvider instanceProvider
	 */
	public function testFormat( IParamDefinition $sourceDefinition ) {
		$values = $this->valueProvider();
		$options = new Options();

		foreach ( $values[$sourceDefinition->getName()] as $data ) {
			$definition = clone $sourceDefinition;

			list( $input, $valid, ) = $data;

			$param = new Param( $definition );
			$param->setUserValue( $definition->getName(), $input, $options );

			if ( $valid && array_key_exists( 2, $data ) ) {
				$defs = [];
				$param->process( $defs, [], $options );

				$this->assertEquals(
					$data[2],
					$param->getValue()
				);
			}
		}

		$this->assertTrue( true );
	}

	protected function validate( ParamDefinition $definition, $testValue, $validity, Options $options = null ) {
		$def = clone $definition;
		$options = $options === null ? new Options() : $options;

		$param = new Param( $def );
		$param->setUserValue( $def->getName(), $testValue, $options );

		$defs = [];
		$param->process( $defs, [], $options );

		$this->assertEquals( $validity, $param->getErrors() === [] );
	}

}