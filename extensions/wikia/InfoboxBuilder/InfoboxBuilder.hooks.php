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
		$extraLibraries['mw.InfoboxBuilderHF']   = '\InfoboxBuilder\LuaLibrary';
		$extraLibraries['mw.InfoboxBuilderView'] = '\InfoboxBuilder\LuaLibrary';
		$extraLibraries['mw.InfoboxBuilder']     = '\InfoboxBuilder\LuaLibrary';

		return true;
	}

	public static function setupParserHook( &$parser ) {
		$parser->setFunctionHook( 'infoboxbuilder', '\InfoboxBuilder\InfoboxBuilderHooks::parserFunctionHook', SFH_OBJECT_ARGS );
		return true;
	}

	public static function parserFunctionHook( &$parser, $frame, $args ) {
		// wfProfileIn( __METHOD__ );

		// wfProfileOut( __METHOD__ );
		return "success! {$param1}";
	}
}
