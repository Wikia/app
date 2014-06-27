<?php
namespace InfoboxBuilder;

/**
 * Hook adding InfoboxBuilder as an external library
 * 
 * @param  string $engine
 * @param  array  $extraLibraries
 * @return bool
 */
public static function registerScribuntoLibraries( $engine, array &$extraLibraries ) {
	if ( $engine !== 'luacommon' ) {
		return true;
	}

	$extraLibraries['mw.InfoboxBuilder']     = '\InfoboxBuilder\LuaLibrary';
	$extraLibraries['mw.InfoboxBuilderView'] = '\InfoboxBuilder\LuaLibrary';

	return true;
}
