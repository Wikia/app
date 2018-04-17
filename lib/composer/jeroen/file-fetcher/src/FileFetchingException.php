<?php

declare( strict_types=1 );

namespace FileFetcher;

/**
 * @since 3.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class FileFetchingException extends \RuntimeException {

	private $fileUrl;

	public function __construct( string $fileUrl, string $message = null, \Exception $previous = null ) {
		$this->fileUrl = $fileUrl;

		parent::__construct(
			$message ?: 'Could not fetch file: ' . $fileUrl,
			0,
			$previous
		);
	}

	public function getFileUrl(): string {
		return $this->fileUrl;
	}

}
