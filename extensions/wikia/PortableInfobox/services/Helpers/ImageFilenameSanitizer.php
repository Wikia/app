<?php

namespace Wikia\PortableInfobox\Helpers;

/**
 * Class ImageFilenameSanitizer
 * @package Wikia\PortableInfobox\Helpers
 */
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
		global $wgNamespaceAliases;
		$langCode = $contLang->getCode();
		if ( empty( $this->filePrefixRegex[ $langCode ] ) ) {
			$fileNamespaces = [
				\MWNamespace::getCanonicalName( NS_FILE ),
				$contLang->getNamespaces()[ NS_FILE ],
			];

			$aliases = array_merge( $contLang->getNamespaceAliases(), $wgNamespaceAliases );
			foreach ( $aliases as $alias => $namespaceId ) {
				if ( $namespaceId == NS_FILE ) {
					$fileNamespaces [] = $alias;
				}
			}
			$this->filePrefixRegex[ $langCode ] = '^(' . implode( '|', $fileNamespaces ) . '):';
		}

		return $this->filePrefixRegex[ $langCode ];
	}

	/**
	 * @param $filename string
	 * @param $contLang \Language
	 *
	 * @return mixed
	 */
	public function sanitizeImageFileName( $filename, $contLang ) {
		$plainText = $this->convertToPlainText( $filename );
		$filePrefixRegex = $this->getFilePrefixRegex( $contLang );
		$textLines = explode( PHP_EOL, $plainText );

		foreach ( $textLines as $potentialFilename ) {
			$filename = $this->extractFilename( $potentialFilename, $filePrefixRegex );
			if ( $filename ) {
				return $filename;
			}

		}

		return $plainText;
	}

	/**
	 * @param $filename
	 *
	 * @return string
	 */
	private function convertToPlainText( $filename ) {
		// strip HTML tags
		$filename = strip_tags( $filename );
		// replace the surrounding whitespace
		$filename = trim( $filename );

		return $filename;
	}

	/**
	 * @param $potentialFilename
	 * @param $filePrefixRegex
	 *
	 * @return string|null
	 */
	private function extractFilename( $potentialFilename, $filePrefixRegex ) {
		$trimmedFilename = trim( $potentialFilename, "[]" );
		$unprefixedFilename = mb_ereg_replace( $filePrefixRegex, "", $trimmedFilename );
		$filenameParts = explode( '|', $unprefixedFilename );
		if ( !empty( $filenameParts[ 0 ] ) ) {
			return urldecode( $filenameParts[0] );
		}

		return null;
	}
}
