<?php

namespace Wikia\ContentReview;

class ImportJS {
	const MODULE_ENTRYPOINT = 'ImportJS';
	const IMPORT_SCRIPTS_FUNCTION = 'importWikiaScriptPages';
	const IMPORT_SCRIPTS_KEY = 'content-review-importjs';
	const IMPORT_SCRIPTS_VERSION = '1.0';

	/**
	 * Get js script to load imports
	 *
	 * @return String
	 */
	public function getImportScripts() {
		$importScripts = \WikiaDataAccess::cache(
			$this->getImportJSMemcKey(),
			2592000, // 30 days,
			function() {
				$importScripts = '';
				$title = \Title::newFromText( self::MODULE_ENTRYPOINT, NS_MEDIAWIKI );

				if ( $title instanceof \Title && $title->exists() ) {
					$revision = \Revision::newFromTitle( $title );
					$scripts = explode( PHP_EOL, $revision->getRawText() );

					$imports = $this->prepareImports( $scripts );
					$importScripts = $this->createInlineScript( $imports );
				}

				return $importScripts;
			}
		);

		return $importScripts;
	}

	/**
	 * Check and filter provided scripts.
	 *
	 * Names should end with '.js' extension.
	 * External scripts are allowed only from dev.wikia.com
	 *
	 * @param array $scripts
	 * @return array
	 */
	public function prepareImports( Array $scripts ) {
		$imports = [];

		foreach ( $scripts as $key => $script ) {
			$script = trim( $script );

			if ( substr( $script, -3 ) === Helper::JS_FILE_EXTENSION
				&& !preg_match( \Title::getTitleInvalidRegex(), $script )
			) {
				$scriptParts = explode( ':', $script );
				$count = count( $scriptParts );
				// Local script
				if ( $count === 1 ) {
					$imports[] = $script;
					// External script, only dev.wikia.com is allowed
				} elseif ( $count === 2 && $scriptParts[0] === 'dev' ) {
					$imports[] = 'external:' . $script;
				}
			}
		}

		return $imports;
	}

	/**
	 * Create inline script with function to load imports
	 *
	 * @param array $imports
	 * @return string
	 */
	public function createInlineScript( Array $imports ) {
		$importScript = '';

		if ( !empty( $imports ) ) {
			$imports = array_map( 'Xml::escapeJsString', $imports );

			$code = sprintf(
				'(function(){%s(["%s"]);})();',
				self::IMPORT_SCRIPTS_FUNCTION,
				implode( '", "', $imports )
			);

			$importScript = \Html::inlineScript( $code );
		}

		return $importScript;
	}

	/**
	 * Check if given page is MediaWiki:ImportJS page
	 *
	 * @param \Title $title
	 * @return bool
	 */
	static public function isImportJSPage( \Title $title ) {
		return $title->inNamespace( NS_MEDIAWIKI ) && $title->getText() === self::MODULE_ENTRYPOINT;
	}

	/**
	 * Get description how to manage script imports
	 *
	 * @return \Message
	 */
	static public function getImportJSDescriptionMessage() {
		return wfMessage( 'content-review-importjs-description' );
	}

	/**
	 * Purge cache with inline script
	 */
	static public function purgeImportScripts() {
		\WikiaDataAccess::cachePurge( self::getImportJSMemcKey() );
	}

	/**
	 * Get cache key
	 *
	 * @return String
	 */
	static public function getImportJSMemcKey() {
		return wfMemcKey( self::IMPORT_SCRIPTS_KEY, self::IMPORT_SCRIPTS_VERSION );
	}
}
