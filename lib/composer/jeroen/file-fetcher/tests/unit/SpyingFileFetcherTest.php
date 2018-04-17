<?php

declare( strict_types=1 );

namespace FileFetcher\Tests\Phpunit;

use FileFetcher\FileFetchingException;
use FileFetcher\InMemoryFileFetcher;
use FileFetcher\SpyingFileFetcher;
use FileFetcher\ThrowingFileFetcher;
use PHPUnit\Framework\TestCase;

/**
 * @covers FileFetcher\SpyingFileFetcher
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SpyingFileFetcherTest extends TestCase {

	public function testReturnsResultOfDecoratedFetcher() {
		$innerFetcher = new InMemoryFileFetcher( [
			'url' => 'content'
		] );

		$spyingFetcher = new SpyingFileFetcher( $innerFetcher );

		$this->assertSame( 'content', $spyingFetcher->fetchFile( 'url' ) );

		$this->expectException( FileFetchingException::class );
		$spyingFetcher->fetchFile( 'foo' );
	}

	public function testWhenNoCalls_getFetchedUrlsReturnsEmptyArray() {
		$innerFetcher = new InMemoryFileFetcher( [
			'url' => 'content'
		] );

		$spyingFetcher = new SpyingFileFetcher( $innerFetcher );

		$this->assertSame( [], $spyingFetcher->getFetchedUrls() );
	}

	public function testWhenSomeCalls_getFetchedUrlsReturnsTheArguments() {
		$innerFetcher = new InMemoryFileFetcher( [
			'url' => 'content',
			'foo' => 'bar'
		] );

		$spyingFetcher = new SpyingFileFetcher( $innerFetcher );
		$spyingFetcher->fetchFile( 'url' );
		$spyingFetcher->fetchFile( 'foo' );
		$spyingFetcher->fetchFile( 'url' );

		$this->assertSame( [ 'url', 'foo', 'url' ], $spyingFetcher->getFetchedUrls() );
	}

	public function testCallsCausingExceptionsGetRecorded() {
		$spyingFetcher = new SpyingFileFetcher( new ThrowingFileFetcher() );

		// @codingStandardsIgnoreStart
		try {
			$spyingFetcher->fetchFile( 'url' );
		}
		catch ( FileFetchingException $ex ) {
		}

		try {
			$spyingFetcher->fetchFile( 'foo' );
		}
		catch ( FileFetchingException $ex ) {
		}
		// @codingStandardsIgnoreEnd

		$this->assertSame( [ 'url', 'foo' ], $spyingFetcher->getFetchedUrls() );
	}

}
