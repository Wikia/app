<?php

namespace ParamProcessor\Tests;

use ParamProcessor\ParamDefinitionFactory;

/**
 * @covers ParamProcessor\ParamDefinitionFactory
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ParamDefinitionFactoryTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {
		new ParamDefinitionFactory();
		$this->assertTrue( true );
	}

	// TODO: test other methods

}
