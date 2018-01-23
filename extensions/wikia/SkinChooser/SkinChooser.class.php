<?php

class SkinChooser {
	/**
	 * Set fallbacks for useskin=XXX skin names and support X-Skin header to determine skin
	 * @param IContextSource $context
	 */
	public static function onGetSkin( IContextSource $context ) {
		$request = $context->getRequest();
		$useskin = $request->getVal( 'useskin' );

		// map legacy skin names to their actual equivalents
		if ( $useskin === 'mercury' ) {
			$request->setVal( 'useskin', 'wikiamobile' );
		} elseif ( $useskin === 'wikia' ) {
			$request->setVal( 'useskin', 'oasis' );
		}

		// map X-Skin header to request param
		$skinFromHeader = $request->getHeader( 'X-Skin' );

		if ( isset( Skin::SKINS[$skinFromHeader] ) ) {
			$request->setVal( 'useskin', $skinFromHeader );
		} elseif ( $skinFromHeader === 'mercury' ) {
			// X-Skin header fallback for Mercury which is actually not a MediaWiki skin but a separate application
			$request->setVal( 'useskin', 'wikiamobile' );
		}
	}
}
