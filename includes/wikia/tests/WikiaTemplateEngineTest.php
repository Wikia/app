<?php

use PHPUnit\Framework\TestCase;

/**
* @ingroup mwabstract
*
* Unit tests for Wikia Template System.
*
* Covers:
* * Wikia\Template\Engne
* * Wikia\Template\PHPEngine
* * Wikia\Template\MustacheEngine
*
* @author Federico "Lox" Lucignano <federico@wikia-inc.com>
* @see WikiaTemplateEngineIntegration for the integration test
*/
class WikiaTemplateEngineTest extends TestCase {
	public function engines() {
		return [
			['Wikia\Template\PHPEngine'],
			['Wikia\Template\MustacheEngine']
		];
	}

	/**
	 * @dataProvider engines
	 */
	public function testPrefix( $class ) {
		$prefix = '/a/b/c';
		$tplEngine = ( new $class );

		//initial status
		$this->assertEquals( $tplEngine->getPrefix(), '' );

		//test setting/getting
		$tplEngine->setPrefix( $prefix );
		$this->assertEquals( $tplEngine->getPrefix(), $prefix );

		//test clearing, for reusage scenarios
		$tplEngine->setPrefix( null );
		$this->assertEquals( $tplEngine->getPrefix(), '' );
	}

	/**
	 * Test setting/getting a single value multiple times
	 *
	 * @dataProvider engines
	 */
	public function testValAccessor( $class ) {
		$keyOne = 'a';
		$keyTwo = 'b';
		$data = [$keyOne => 1, $keyTwo => 2];
		$tplEngine = new $class();

		//test initial status
		$this->assertNull( $tplEngine->getVal( $keyOne ) );
		$this->assertNull( $tplEngine->getVal( $keyTwo ) );

		//test setting/getting single values
		foreach ( $data as $key => $value ) {
			$tplEngine->setVal( $key, $value );
			$this->assertEquals( $tplEngine->getVal( $key ), $value );
		}

		//test the whole collection
		$this->assertEquals( $tplEngine->getData(), $data );

		//test unsetting a value
		$tplEngine->clearVal( $keyOne );
		$this->assertNull( $tplEngine->getVal( $keyOne ) );
		$this->assertEquals( $tplEngine->getVal( $keyTwo ), $data[$keyTwo] );
		$this->assertEquals( $tplEngine->getData(), [$keyTwo => $data[$keyTwo]] );
	}

	/**
	 * Test setting/getting multiple values multiple times
	 *
	 * @dataProvider engines
	 */
	public function testDataAccessor( $class ) {
		$data1 = ['a' => 1, 'b' => 2];
		$data2 = ['c' => 3, 'd' => 4];
		$data3 = ['b' => 3, 'c' => 4];

		$tplEngine = new $class;

		//test initial value
		$this->assertEquals( $tplEngine->getData(), [] );

		//test setting values
		$tplEngine->setData( $data1 );
		$this->assertEquals( $tplEngine->getData(), $data1 );

		//test setting values, should have only the data from this run
		$tplEngine->setData( $data2 );
		$this->assertEquals( $tplEngine->getData(), $data2 );

		//test updating/adding values
		$tplEngine->updateData( $data3 );
		$this->assertEquals( $tplEngine->getData(), array_merge( $data2, $data3 ) );

		//test cearing data
		$tplEngine->clearData();
		$this->assertEquals( $tplEngine->getData(), [] );
	}
}
