<?php

declare( strict_types=1 );

namespace FileFetcher;

/**
 * Decorator for FileFetcher objects that records file fetching calls.
 *
 * @since 3.2
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SpyingFileFetcher implements FileFetcher {

	private $fileFetcher;

	private $fetchedUrls = [];

	public function __construct( FileFetcher $fileFetcher ) {
		$this->fileFetcher = $fileFetcher;
	}

	/**
	 * @see FileFetcher::fetchFile
	 * @throws FileFetchingException
	 */
	public function fetchFile( string $fileUrl ): string {
		$this->fetchedUrls[] = $fileUrl;
		return $this->fileFetcher->fetchFile( $fileUrl );
	}

	/**
	 * Returns an ordered list of fetched URLs. Duplicates are preserved.
	 *
	 * @return string[]
	 */
	public function getFetchedUrls(): array {
		return $this->fetchedUrls;
	}

}
