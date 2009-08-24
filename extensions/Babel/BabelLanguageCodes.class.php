<?php

/**
 * Handle in depth language code (and name) processing for the Babel extension,
 * can also be used by other extension which need such functionality.
 */

class BabelLanguageCodes {

	// File used if one is not specified.
	private $mFile;
	
	// Prefix at start of cache key.
	private $mCachePrefix;

	/**
	 * @param $file String: Code file to scan for codes and names.
	 * @param $cachePrefix String:  Prefix to use when adding values to the cache.
	 */
	public function __construct( $file = null, $cachePrefix = null ) {
		// Set the default file (can be overriden).
		if( $file === null ) {
			global $wgBabelLanguageCodesFile;
			$this->mFile = $wgBabelLanguageCodesFile;
		} else {
			$this->mFile = $file;
		}

		// Set the cache prefix (can be overriden).
		if( $cachePrefix === null ) {
			global $wgBabelCachePrefix;
			$this->mCachePrefix = $wgBabelCachePrefix;
		} else {
			$this->mCachePrefix = $cachePrefix;
		}
	}

	/**
	 * Take a code as input, then use various magic to return a "better"
	 * code if available.  The following order is used
	 *     - Cache.
	 *     - MediaWiki language codes.
	 *     - ISO 639-1 language codes.
	 *     - ISO 639-3 language codes.
	 * This can be achevied because we know the length that ISO language
	 * codes should be in the latter two categories. 
	 * @param $code String: Code to try and get a "better" code for.
	 * @param $file String: Code file to scan for codes.
	 * @param $cachePrefix String: Prefix to use when adding values to the cache.
	 * @return String (language code) or null (invalid language code).
	 */
	public function getCode( $code, $file = null, $cachePrefix = null ) {
		$cacheType = 'code';
		// Try cache.
		$fromCache = $this->mGetFromCache( $cacheType, $code, false, $cachePrefix );
		if( $fromCache === null  ) return null;      // Known invalid language code.
		if( $fromCache !== false ) return $fromCache; // Known   valid language code.
		// Try MediaWiki language files.
		global $wgLang;
		$mediawiki = $wgLang->getLanguageName( $code );
		if( $mediawiki !== '' ) return $code;
		// Try ISO code file.
		if( strlen( $code ) === 2 ) {
			// ISO 639-1
			$iso = $this->mScanFile( $code, $seek = 0, $find = 0 );
			if( $iso !== false ) return $this->mAddToCache( $cacheType, $code, $code, $cachePrefix );
		} elseif( strlen( $code ) === 3 ) {
			// ISO 639-3
			$iso = $this->mScanFile( $code, $seek = 1, $find = 0 );
			if( $iso === null ) return $this->mAddToCache( $cacheType, $code, $code, $cachePrefix );
			if( $iso !== false ) return $this->mAddToCache( $cacheType, $code, $iso, $cachePrefix );
		}
		// Invalid language code.
		return $this->mAddToCache( $cacheType, $code, null, $cachePrefix );
	}

	/**
	 * Take a code as input, and attempt to find a language name for it in
	 * a language that is as native as possible.  The following order is used:
	 *     - Cache.
	 *     - CLDR extension.
	 *     - MediaWiki native.
	 *     - ISO code files.
	 * @param $code String: Code to get name for.
	 * @param $file String: Code file to scan for names.
	 * @param $cachePrefix String: Prefix to use when adding values to the cache.
	 * @return String (name of language) or null (invalid language code).
	 */
	public function getName( $code, $file = null, $cachePrefix = null ) {
		$cacheType = 'name';
		// Get correct code, even though it should already be correct.
		$code = $this->getCode( $code, $file, $cachePrefix );
		if( $code === null ) return null;
		// Try cache.
		$fromCache = $this->mGetFromCache( $cacheType, $code, null, $cachePrefix );
		if( $fromCache !== null ) return $fromCache;
		// Try CLDR extension, then MediaWiki native.
		if( class_exists( 'LanguageNames' ) ) {
			$names = LanguageNames::getNames( $code, LanguageNames::FALLBACK_NORMAL, LanguageNames::LIST_MW_AND_CLDR );
		} else {
			$names = Language::getLanguageNames();
		}
		if( array_key_exists( $code, $names ) ) return $names[ $code ];
		//  Use English names, from codes file.
		if( strlen( $code ) === 2 ) {
			// ISO 639-1
			$name = $this->mScanFile( $code, 0, 2, $file );
		} elseif( strlen( $code ) === 3 ) {
			// ISO 639-3
			$name = $this->mScanFile( $code, 1, 2, $file );
		}
		return $this->mAddToCache( $cacheType, $code, $name, $cachePrefix );
	}

	/**
	 * Scan the codes file for a particular value.
	 * @param $check String: Value to compare with seek column.
	 * @param $seek Integer: Column seeking key from.
	 * @param $find Integer: Column seeking value from.
	 * @param $file String: Code file to scan for values.
	 * @return String (value), null (no value, but key found) or false (key not found).
	 */
	private function mScanFile( $check, $seek = 0, $find = 1, $file = null ) {
		if( $file === null ) $file = $this->mFile;
		$fp = fopen( $file, 'r' );
		while( !feof( $fp ) ) {
			$line = fgets( $fp );
			// Encode any strings, so they do not contain spaces.
			$count = substr_count( $line, '"' );
			$count = $count / 2;
			for( $i = 0; $i < $count; $i++ ) {
				$start = strpos( $line, '"' );
				$end   = strpos( $line, '"', $start + 1 );
				$string = substr( $line, $start + 1, $end - $start );
				$lineStart = substr( $line, 0, $start );
				$lineEnd   = substr( $line, $end + 2 );
				$encoded = base64_encode( $string );
				$line = $lineStart . '"' . $encoded . '"' . $lineEnd;
			}
			// Split up into indiviudal parts, for seeking.
			$parts = explode( ' ', $line );
			if( $parts[ $seek ] !== $check ) continue;
			if( $parts[ $find ] === '-' ) return null;
			$data = $parts[ $find ];
			// Decode if encoded.
			if( strpos( $data, '"' ) === 0 ) {
				$data = substr( $data, 1, -2 ); 
				$data = base64_decode( $data );
			}
			return $data;
		}
		// Key not found.
		return false;
	}

	/**
	 * Add a value to the cache.
	 * @param $type String: Type of data (code or name).
	 * @param $code String: Code data is for.
	 * @param $value String: Value to use.
	 * @param $prefix String: Prefix to key.
	 * @return String: Value entered.
	 */
	private function mAddToCache( $type, $code, $value, $prefix = null ) {
		if( $prefix === null ) $prefix = $this->mCachePrefix;
		$key = wfMemcKey( $prefix, $type, $code );
		global $wgMemc;
		$wgMemc->add( $key, $value, 216000 );
		return $value;
	}

	/**
	 * Get a value from the cache.
	 * @param $type String: Type of data (code or name).
	 * @param $code String: Code data is for.
	 * @param $default String: Default value to return if key not found.
	 * @param $prefix String: Prefix to key.
	 */
	 private function mGetFromCache( $type, $code, $default = false, $prefix = null ) {
		if( $prefix === null ) $prefix = $this->mCachePrefix;
		$key = wfMemcKey( $prefix, $type, $code );
		global $wgMemc;
		$value = $wgMemc->get( $key );
		if( is_string( $value ) && $value !== '' ) return $value;
	 	return $default;
	 }

}
