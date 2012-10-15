<?php
/**
 * Lua parser extensions for MediaWiki - Hooks
 *
 * @author Fran Rogers
 * @ingroup Extensions
 * @license See 'COPYING'
 * @file
 */

class LuaHooks {
	/**
	 * ParserFirstCallInit hook
	 * @param $parser Parser
	 * @return bool
	 */
	public static function parserInit( &$parser ) {
		$parser->setHook( 'lua', 'LuaHooks::renderTag' );
		$parser->setFunctionHook('luaexpr', 'LuaHooks::renderExpr');
		return true;
	}

	/** ParserBeforeTidy hook */
	public static function beforeTidy(&$parser, &$text) {
		global $wgLua;
		if ( $wgLua !== null ) {
			$wgLua->destroy();
		}
		return true;
	}

	/**
	 * Parser hook for the <lua> tag
	 * @param $input
	 * @param $args
	 * @param $parser Parser
	 * @return string
	 */
	public static function renderTag($input, $args, $parser) {
		try {
			global $wgLua;
			# Create a new LuaWrapper if needed
			if ( $wgLua === null ) {
				$wgLua = new LuaWrapper;
			}

			# Process the tag's arguments into a chunk of Lua code
			# that initializes them in the Lua sandbox
			$arglist = '';
			foreach ($args as $key => $value)
				$arglist .= (preg_replace('/\W/', '', $key) . '=\'' .
						 addslashes($parser->recursiveTagParse($value)) .
						 '\';');
			if ($arglist) {
				try {
					$wgLua->wrap($arglist);
				} catch (LuaError $e) {
					return $e->getMessage();
				}
			}

			# Execute this Lua chunk, and send the results through the 
			# Parser.
			return $parser->recursiveTagParse($wgLua->wrap($input));
		} catch (LuaError $e) {
			return $e->getMessage();
		}
	}

	/**
	 * Parser function hook for the #luaexpr function
	 * @param $parser Parser
	 * @param $param1 bool
	 * @return string
	 */
	public static function renderExpr(&$parser, $param1 = FALSE) {
		global $wgLua;
		# Create a new LuaWrapper if needed
		if ( $wgLua === null ) {
			$wgLua = new LuaWrapper;
		}
		
		# Execute this Lua chunk, wrapped in io.write().
		if ( $param1 == false ) {
			return '';
		}
		try {
			return $wgLua->wrap("io.write($param1)");
		} catch (LuaError $e) {
			return $e->getMessage();
		}
	}
}
