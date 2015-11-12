<?php

namespace Wikia\ContentReview;

class ImportJS {
	const IMPORT_SCRIPTS = 'ImportJS';
	const IMPORT_SCRIPTS_FUNCTION = 'importWikiaScriptPages';
	const IMPORT_SCRIPTS_KEY = 'content-review-importjs';
	const IMPORT_SCRIPTS_VERSION = '1.0';

	/**
	 * Get js script to load imports
	 *
	 * @return String
	 */
	public function getImportScripts() {
		$importScript = \WikiaDataAccess::cache(
			$this->getImportJSMemcKey(),
			2592000, // 30 days,
			function() {
				$importScript = '';
				$title = \Title::newFromText( self::IMPORT_SCRIPTS, NS_MEDIAWIKI );

				if ( $title instanceof \Title && $title->getArticleID() != 0 ) {
					$revision = \Revision::newFromTitle( $title );
					$scripts = explode( PHP_EOL, $revision->getRawText() );

					$imports = $this->prepareImports( $scripts );
					$importScript = $this->createInlineScript( $imports );
				}

				return $importScript;
			}
		);

		return $importScript;
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

		foreach( $scripts as $key => $script ) {
			$script = trim( $script );

			if ( strtoupper( substr( $script, -3 ) ) === '.JS' ) {
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
			$code = '(function(){'
				. self::IMPORT_SCRIPTS_FUNCTION . '(["' . implode( '", "', $imports ) . '"]);'
				. '})();';
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
		return $title->inNamespace( NS_MEDIAWIKI ) && $title->getText() === self::IMPORT_SCRIPTS;
	}

	/**
	 * Get description how to manage script imports
	 *
	 * @return String
	 */
	static public function getImportJSDescription() {
		return wfMessage( 'content-review-importjs-description' )->escaped();
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
