<?php

namespace Wikia\PortableInfobox\Helpers;

class ImageFilenameSanitizer {
	private static $instance = null;

	private function __construct() {
	}

	/**
	 * @return null|ImageFilenameSanitizer
	 */
	public static function getInstance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function sanitizeImageFileName( $filename ) {
		return $filename;
	}
}