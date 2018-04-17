<?php

declare( strict_types=1 );

namespace FileFetcher;

/**
 * Adapter around file_get_contents.
 *
 * @since 3.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SimpleFileFetcher implements FileFetcher {

	/**
	 * @see FileFetcher::fetchFile
	 * @throws FileFetchingException
	 */
	public function fetchFile( string $fileUrl ): string {
		$fileContent = @file_get_contents( $fileUrl );

		if ( is_string( $fileContent ) ) {
			return $fileContent;
		}

		throw new FileFetchingException( $fileUrl );
	}

}
