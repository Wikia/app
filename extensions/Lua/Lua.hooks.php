<?php
/**
 * Lua parser extensions for MediaWiki - Hooks
 *
 * @author Fran Rogers
 * @package MediaWiki
 * @addtogroup Extensions
 * @license See 'COPYING'
 * @file
 */

class LuaHooks {
	/** ParserFirstCallInit hook */
	public static function parserInit() {
		global $wgParser;
		$wgParser->setHook( 'lua', 'LuaHooks::renderTag' );
		$wgParser->setFunctionHook('luaexpr', 'LuaHooks::renderExpr');
		return true;
	}

	/** LanguageGetMagic hook */
	public static function magic(&$magicWords, $langCode) {
		$magicWords['luaexpr'] = array(0, 'luaexpr');
		return true;
	}

	/** ParserBeforeTidy hook */
	public static function beforeTidy(&$parser, &$text) {
		global $wgLua;
		if (isset($wgLua)) {
			$wgLua->destroy();
		}
		return TRUE;
	}

	/** Parser hook for the <lua> tag */
	public static function renderTag($input, $args, &$parser) {
		global $wgLua;
		# Create a new LuaWrapper if needed
		if (!isset($wgLua))
			$wgLua = new LuaWrapper;

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
		try {
			return $parser->recursiveTagParse($wgLua->wrap($input));
		} catch (LuaError $e) {
			return $e->getMessage();
		}
	}
	
	/** Parser function hook for the #luaexpr function */
	public static function renderExpr(&$parser, $param1 = FALSE) {
		global $wgLua;
		# Create a new LuaWrapper if needed
		if (!isset($wgLua))
			$wgLua = LuaWrapper::create();
		
		# Execute this Lua chunk, wrapped in io.write().
		if ($param1 == FALSE)
			return '';
		try {
			return $wgLua->wrap("io.write($param1)");
		} catch (LuaError $e) {
			return $e->getMessage();
		}
	}
}
