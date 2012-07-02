<?php

/**
 * Extractor which processes plain text files
 *
 * @file
 * @ingroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */
class TextExtractor extends Extractor {

	public function extract( $path ) {
		return file_get_contents( $path );
	}
	
	/**
	 * Return MIME types this extractor can process
	 *
	 * @return array
	 */
	public static function getMimes() {
		return array(
			'text/plain',
		);
	}

}

