<?php

declare( strict_types = 1 );

namespace FileFetcher\Tests\Phpunit;

use FileFetcher\ErrorLoggingFileFetcher;
use FileFetcher\FileFetchingException;
use FileFetcher\InMemoryFileFetcher;
use FileFetcher\ThrowingFileFetcher;
use PHPUnit\Framework\TestCase;
use Psr\Log\LogLevel;
use Psr\Log\NullLogger;
use WMDE\PsrLogTestDoubles\LoggerSpy;

/**
 * @license GNU GPL v2+
 * @author Gabriel Birke < gabriel.birke@wikimedia.de >
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ErrorLoggingFileFetcherTest extends TestCase {

	public function testWhenWrappedFetcherReturnsValue_itIsReturned() {
		$logger = new LoggerSpy();
		$fileFetcher = new ErrorLoggingFileFetcher(
			new InMemoryFileFetcher( [ 'song.txt' => 'I\'m a little teapot' ] ),
			$logger
		);
		$this->assertSame( 'I\'m a little teapot', $fileFetcher->fetchFile( 'song.txt' ) );
		$logger->assertNoLoggingCallsWhereMade();
	}

	public function testWhenWrappedFetcherThrowsAnException_itIsRethrown() {
		$errorLoggingFileFetcher = new ErrorLoggingFileFetcher(
			new ThrowingFileFetcher(),
			new NullLogger()
		);
		$this->expectException( FileFetchingException::class );
		$errorLoggingFileFetcher->fetchFile( 'song.txt' );
	}

	public function testWhenWrappedFetcherThrowsAnException_theExceptionIsLogged() {
		$logger = new LoggerSpy();
		$fileFetcher = new ErrorLoggingFileFetcher(
			new ThrowingFileFetcher(),
			$logger
		);

		// @codingStandardsIgnoreStart
		try {
			$fileFetcher->fetchFile( 'song.txt' );
			$this->fail( 'Should have thrown a FileFetchingException' );
		} catch ( FileFetchingException $e ) {
		}
		// @codingStandardsIgnoreEnd

		$calls = $logger->getLogCalls();
		$this->assertCount( 1, $calls );
		$this->assertArrayHasKey( 'exception', $calls->getFirstCall()->getContext() );
		$this->assertSame( LogLevel::ERROR, $calls->getFirstCall()->getLevel() );
	}

	public function testGivenLogLevel_exceptionsAreLoggedAtThisLevel() {
		$logger = new LoggerSpy();
		$fileFetcher = new ErrorLoggingFileFetcher(
			new ThrowingFileFetcher(),
			$logger,
			LogLevel::CRITICAL
		);

		// @codingStandardsIgnoreStart
		try {
			$fileFetcher->fetchFile( 'song.txt' );
		} catch ( FileFetchingException $e ) {
		}
		// @codingStandardsIgnoreEnd

		$this->assertSame( LogLevel::CRITICAL, $logger->getLogCalls()->getFirstCall()->getLevel() );
	}

}
