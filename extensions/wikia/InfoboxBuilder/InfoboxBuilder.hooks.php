<?php
namespace InfoboxBuilder;

/**
 * Hooking functions for the InfoboxBuilder extension
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

	/**
	 * Hooks parserFunctionHook() to ParserFirstCallInit
	 * @param  object $parser Parser object
	 * @return bool           Always true to continue loading other hooks.
	 */
	public static function setupParserHook( &$parser ) {
		$parser->setFunctionHook( 'infoboxbuilder', '\InfoboxBuilder\InfoboxBuilderHooks::parserFunctionHook', SFH_OBJECT_ARGS );
		return true;
	}

	/**
	 * Function executed by use of {{#infoboxbuilder:}} parser function.
	 * It gets the code from InfoboxBuilder.lua and creates new module object from it. The module is then invoked and the result is returned.
	 * @param  obj $parser Parser object
	 * @param  obj $frame  PPFrame object 
	 * @param  arr $args   Array of arguments passed from $frame object
	 * @return str         A string returned by InfoboxBuilder.lua
	 */
	public static function parserFunctionHook( &$parser, $frame, $args ) {
		wfProfileIn( __METHOD__ );

		$engine = \Scribunto::getParserEngine( $parser );

		unset( $args[0] );
		$childFrame = $frame->newChild( $args, $parser->getTitle(), 1 );

		$moduleText = file_get_contents( __DIR__ . '/includes/lua/InfoboxBuilder.lua' );
		$module = new \Scribunto_LuaModule( $engine, $moduleText, 'InfoboxBuilder' );
		$result = $module->invoke( 'builder', $childFrame );
		$result = \UtfNormal::cleanUp( strval( $result ) );

		wfProfileOut( __METHOD__ );
		return $result;
	}
}
