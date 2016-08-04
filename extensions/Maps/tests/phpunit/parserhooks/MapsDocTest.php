<?php

namespace Maps\Test;

/**
 * @covers MapsMapsDoc
 *
 * @group Maps
 * @group ParserHook
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MapsDocTest extends ParserHookTest {

	/**
	 * @see ParserHookTest::getInstance
	 * @since 2.0
	 * @return \ParserHook
	 */
	protected function getInstance() {
		return new \MapsMapsDoc();
	}

	/**
	 * @see ParserHookTest::parametersProvider
	 * @since 2.0
	 * @return array
	 */
	public function parametersProvider() {
		$paramLists = array();

		$paramLists[] = array();

		return $this->arrayWrap( $paramLists );
	}

	/**
	 * @see ParserHookTest::processingProvider
	 * @since 3.0
	 * @return array
	 */
	public function processingProvider() {
		$argLists = array();

		$values = array( 'service' => 'googlemaps3' );

		$expected = array( 'service' => 'googlemaps3' );

		$argLists[] = array( $values, $expected );


		$values = array( 'service' => 'GOOGLEmaps3' );

		$expected = array( 'service' => 'googlemaps3' );

		$argLists[] = array( $values, $expected );

		return $argLists;
	}

}