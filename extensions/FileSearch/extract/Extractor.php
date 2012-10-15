<?php

/**
 * Abstract implementation for extractors; classes which can extract
 * meaningful search text from uploaded files
 *
 * @file
 * @ingroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */
abstract class Extractor {

	public abstract function extract( $path );

	/**
	 * Return MIME types this extractor can process
	 *
	 * @return array
	 */
	public static function getMimes() {
		return array();
	}

}

