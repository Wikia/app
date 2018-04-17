<?php

declare( strict_types = 1 );

namespace FileFetcher;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * @license GNU GPL v2+
 * @author Gabriel Birke < gabriel.birke@wikimedia.de >
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ErrorLoggingFileFetcher implements FileFetcher {

	private $wrappedFileFetcher;
	private $logger;
	private $logLevel;

	public function __construct( FileFetcher $fileFetcher, LoggerInterface $logger, string $logLevel = LogLevel::ERROR ) {
		$this->wrappedFileFetcher = $fileFetcher;
		$this->logger = $logger;
		$this->logLevel = $logLevel;
	}

	/**
	 * @see FileFetcher::fetchFile
	 * @throws FileFetchingException
	 */
	public function fetchFile( string $fileUrl ): string {
		try {
			return $this->wrappedFileFetcher->fetchFile( $fileUrl );
		} catch ( FileFetchingException $e ) {
			$this->logger->log(
				$this->logLevel,
				$e->getMessage(),
				[
					'exception' => $e
				]
			);
			throw $e;
		}
	}

}
