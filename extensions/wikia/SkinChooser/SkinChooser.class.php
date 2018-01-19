<?php

class SkinChooser {
	/**
	 * Set fallbacks for useskin=XXX skin names and support X-Skin header to determine skin
	 * @param RequestContext $context
	 */
	public static function onGetSkin( RequestContext $context ) {
		$request = $context->getRequest();
		$useskin = $request->getVal( 'useskin' );

		// map legacy skin names
		switch ( true ) {
			case $useskin === 'mercury':
				$request->setVal( 'useskin', 'wikiamobile' );
				return;
			case $useskin === 'wikia':
				$request->setVal( 'useskin', 'oasis' );
				return;
		}

		if ( $useskin === 'mercury' ) {
			$request->setVal( 'useskin', 'wikiamobile' );
		}

		if ( $useskin === 'wikia' ) {
			$request->setVal( 'useskin', 'oasis' );
		}

		// map X-Skin header to request param
		$skinFromHeader = $request->getHeader( 'X-Skin' );

		switch ( true ) {
			case isset( Skin::SKINS[$skinFromHeader] ):
				$request->setVal( 'useskin', $skinFromHeader );
				return;
			// X-Skin header fallback for Mercury which is actually not a MediaWiki skin but a separate application
			case $skinFromHeader === 'mercury':
				$request->setVal( 'useskin', $skinFromHeader );
		}
	}
}
