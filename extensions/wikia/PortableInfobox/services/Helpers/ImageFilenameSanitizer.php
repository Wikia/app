<?php

namespace Wikia\PortableInfobox\Helpers;

class ImageFilenameSanitizer {
	private static $instance = null;
	private $filePrefixRegex = [ ];

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

	/**
	 * @param $contLang \Language
	 * Used as local cache for getting string to remove
	 */
	private function getFilePrefixRegex( $contLang ) {
		$langCode = $contLang->getCode();
		if ( empty( $this->filePrefixRegex[$langCode] ) ) {
			$fileNamespaces = [ \MWNamespace::getCanonicalName( NS_FILE ), $contLang->getNamespaces()[NS_FILE] ];

			$aliases = $contLang->getNamespaceAliases();
			foreach ( $aliases as $alias => $namespaceId ) {
				if ( $namespaceId == NS_FILE )
					$fileNamespaces [] = $alias;
			}
			$this->filePrefixRegex[$langCode] = '^(' . implode( '|', $fileNamespaces ) . '):';
		}
		return $this->filePrefixRegex[$langCode];
	}

	/**
	 * @param $filename string
	 * @param $contLang \Language
	 * @return mixed
	 */
	public function sanitizeImageFileName( $filename, $contLang ) {
		// replace the MW square brackets and surrounding whitespace
		$trimmedFilename = trim( $filename, "\t\n\r[]" );

		$filePrefixRegex = $this->getFilePrefixRegex( $contLang );
		$unprefixedFilename = mb_ereg_replace( $filePrefixRegex, "", $trimmedFilename );
		// strip
		$filenameParts = explode( '|', $unprefixedFilename );
		if ( !empty( $filenameParts[0] ) ) {
			$filename = $filenameParts[0];
		}
		return $filename;
	}
}
