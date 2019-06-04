$messages = [ ];
if ( !function_exists( 'wfJsonI18nShimWikiaDesignSystem' ) ) {
	function wfJsonI18nShimWikiaDesignSystem( $cache, $code, &$cachedData ) {
		$codeSequence = array_merge( [ $code ], $cachedData['fallbackSequence'] );
		foreach ( $codeSequence as $csCode ) {
			$fileName = __DIR__ . "/i18n/$csCode.json";
			if ( is_readable( $fileName ) ) {
				$data = FormatJson::decode( file_get_contents( $fileName ), true );
				foreach ( array_keys( $data ) as $key ) {
					if ( $key === '' || $key[0] === '@' ) {
						unset( $data[$key] );
					}
				}
				$cachedData['messages'] = array_merge( $data, $cachedData['messages'] );
			}
			$cachedData['deps'][] = new FileDependency( $fileName );
		}
		return true;
	}
	$GLOBALS['wgHooks']['LocalisationCacheRecache'][] = 'wfJsonI18nShimWikiaDesignSystem';
}
