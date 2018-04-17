<?php

declare( strict_types=1 );

namespace FileFetcher\Tests\Integration;

use FileFetcher\FileFetchingException;
use FileFetcher\SimpleFileFetcher;
use PHPUnit\Framework\TestCase;

/**
 * @covers FileFetcher\SimpleFileFetcher
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SimpleFileFetcherTest extends TestCase {

	public function testGetThisFileFromDisk() {
		$fetcher = new SimpleFileFetcher();

		$contents = $fetcher->fetchFile( __FILE__ );

		$this->assertEquals( file_get_contents( __FILE__ ), $contents );
	}

	public function testGetThisFileFromGitHub() {
		$fetcher = new SimpleFileFetcher();

		$contents = $fetcher->fetchFile(
			'http://raw.github.com/JeroenDeDauw/FileFetcher/master/tests/integration/SimpleFileFetcherTest.php'
		);

		$this->assertInternalType( 'string', $contents );

		$this->assertInternalType( 'integer', strpos( $contents, __FUNCTION__ ) );
	}

	public function testGivenNotFoundFile_exceptionIsThrown() {
		$fetcher = new SimpleFileFetcher();

		$this->expectException( FileFetchingException::class );
		$fetcher->fetchFile(
			'http://raw.github.com/JeroenDeDauw/FileFetcher/master/foo.php'
		);
	}

	public function testGivenInvalidUrl_exceptionIsThrown() {
		$fetcher = new SimpleFileFetcher();

		$this->expectException( FileFetchingException::class );
		$fetcher->fetchFile(
			'foo bar baz'
		);
	}

}
