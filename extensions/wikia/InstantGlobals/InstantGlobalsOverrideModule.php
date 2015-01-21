<?php
/**
 * Implements Module for overriding InstantGlobals through querystring params
 *
 */
class InstantGlobalsOverrideModule extends ResourceLoaderModule {

	public function getScript( ResourceLoaderContext $context ) {

		return sprintf( 'Wikia.InstantGlobals = %s', json_encode( $variables ) );
	}

}
