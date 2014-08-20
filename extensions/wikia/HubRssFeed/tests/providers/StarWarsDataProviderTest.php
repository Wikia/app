<?php

include_once dirname( __FILE__ ) . '/../../' . "providers/StarWarsDataProvider.class.php";

class StarWarsDataProviderTest extends WikiaBaseTest {

	/**
	 * @covers StarWarsDataProvider::canBeTitle
	 * @dataProvider testCanBeTitle_Provider
	 */
	public function testCanBeTitle( $text, $expectedResult ) {
		$dataProvider = new StarWarsDataProvider();
		$canBeTitle = self::getFn( $dataProvider, 'canBeTitle' );
		$this->assertEquals( $expectedResult, $canBeTitle( $text ) );
	}

	public function testCanBeTitle_Provider() {
		return [
			[ 'Hello World', true ],
			[ 'hello world', false ],
			[ '123', false ],
			[ 'StarWars.com', false ],
			[ 'Read more...', false ],
			[ 'Read More...', false ],
			[ 'read more', false ],
		];
	}

	protected static function getFn($obj, $name) {
		$class = new ReflectionClass(get_class($obj));
		$method = $class->getMethod($name);
		$method->setAccessible(true);

		return function () use ( $obj, $method ) {
			$args = func_get_args();
			return $method->invokeArgs( $obj, $args );
		};
	}

}