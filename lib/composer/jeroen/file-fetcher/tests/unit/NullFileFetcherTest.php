<?php

declare( strict_types=1 );

namespace FileFetcher\Tests\Phpunit;

use FileFetcher\NullFileFetcher;
use PHPUnit\Framework\TestCase;

/**
 * @covers FileFetcher\NullFileFetcher
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class NullFileFetcherTest extends TestCase {

	public function testReturnsEmptyString() {
		$this->assertSame( '', ( new NullFileFetcher() )->fetchFile( 'foo.txt' ) );
	}

}
