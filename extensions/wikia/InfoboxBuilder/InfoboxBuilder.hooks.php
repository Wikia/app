<?php
namespace InfoboxBuilder;

/**
 * Hook handlers for the InfoboxBuilder extension
 *
 * @license GNU GPL v2+
 *
 * @author Adam Karmiński < adamk@wikia-inc.com > 
 */
final class InfoboxBuilderHooks {
	/**
	 * Hook adding InfoboxBuilder as an external library
	 * 
	 * @param  string $engine
	 * @param  array  $extraLibraries
	 * @return bool
	 */
	public static function registerScribuntoLibraries( $engine, array &$extraLibraries ) {
		if ( $engine !== 'luasandbox' ) {
			return true;
		}

		$extraLibraries['mw.InfoboxBuilder']     = '\InfoboxBuilder\LuaLibrary';
		// $extraLibraries['mw.InfoboxBuilderView'] = '\InfoboxBuilder\LuaLibrary';

		return true;
	}
}
