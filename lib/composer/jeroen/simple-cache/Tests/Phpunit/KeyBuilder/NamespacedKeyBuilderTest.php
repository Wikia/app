<?php

namespace SimpleCache\Tests\Phpunit\KeyBuilder;

use SimpleCache\KeyBuilder\NamespacedKeyBuilder;

/**
 * @covers SimpleCache\KeyBuilder\NamespacedKeyBuilder
 *
 * @file
 * @ingroup SimpleCache
 * @group SimpleCache
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class NamespacedKeyBuilderCacheTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @dataProvider namespaceAndKeyProvider
	 */
	public function testGetKey( $namespace, $key ) {
		$keyBuilder = new NamespacedKeyBuilder( $namespace );

		$this->assertInternalType( 'string', $keyBuilder->buildKey( $key ) );
	}

	public function namespaceAndKeyProvider() {
		$argLists = array();

		$argLists[] = array( '', '' );
		$argLists[] = array( '', 'foo' );
		$argLists[] = array( 'foo', 'foo' );
		$argLists[] = array( 'foo', '' );
		$argLists[] = array( 'foo', 'bar' );
		$argLists[] = array( 'foo bar', 'bar baz' );

		return $argLists;
	}

}
