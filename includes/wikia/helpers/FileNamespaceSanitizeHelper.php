<?php

class FileNamespaceSanitizeHelper {
	private static $instance = null;
	private $filePrefixRegex = [ ];

	private function __construct() {
	}

	/**
	 * @return null|FileNamespaceSanitizeHelper
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
			
			//be able to match user-provided file namespaces that may contain both underscores and spaces
			$fileNamespaces = array_map(function( $namespace ) {
				return mb_ereg_replace('_', '(_|\ )', $namespace);
			}, $fileNamespaces);

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

		if ( !empty( $filenameParts[0] ) ) {
			return rawurldecode( $filenameParts[0] );
		}

		return self::removeImageParams( $unprefixedFilename );
	}

	/**
	 * @desc removes all files and images occurrences from wikitext
	 *
	 * @param string $wikitext
	 * @param $lang \Language
	 * @return string wikitext without files and images
	 */
	public function stripFilesFromWikitext( $wikitext, $lang ) {
		$filePrefixRegex = substr( $this->getFilePrefixRegex( $lang ), 1 );
		$wikitext = preg_replace( '/\[\[' . $filePrefixRegex .'.*\]\]/U', '', $wikitext );

		return $wikitext;
	}

	/**
	 * @desc for a given wikitext, return an array of images or files occurences,
	 * without brackets and without any params
	 *
	 * @param string $wikitext to find images or files in
	 * @param $lang
	 * @return array of images ['File:sefes', 'File:blabla']
	 * or false if no images found
	 */
	public function getCleanFileMarkersFromWikitext( $wikitext, $lang ) {
		$filePrefixRegex = substr( $this->getFilePrefixRegex( $lang ), 1 );
		preg_match_all( '/\[\[(' . $filePrefixRegex .'[^|\]]*).*?\]\]/', $wikitext, $images );

		return count( $images[1] ) ? $images[1] : false;
	}

	/**
	 * @desc for given file wikitext without brackets, return it without any params
	 * or null if empty string
	 *
	 * @param $fileWikitext
	 * @return string | null
	 */
	public function removeImageParams( $fileWikitext ) {
		$filenameParts = explode( '|', $fileWikitext );
		if ( empty( $filenameParts[0] ) ) {
			return null;
		}

		return urldecode( $filenameParts[0] );
	}
}
