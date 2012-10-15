<?php
/**
 * Built-in scripting language for MediaWiki
 * Copyright (C) 2009 Victor Vasiliev <vasilvv@gmail.com>
 * http://www.mediawiki.org/
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

if( !defined( 'MEDIAWIKI' ) )
	die();

$wgExtensionCredits['parserhook']['InlineScripts'] = array(
	'path'           => __FILE__,
	'name'           => 'InlineScripts',
	'author'         => 'Victor Vasiliev',
	'description'    => 'Provides a build into wikitext scripting language',
	'descriptionmsg' => 'inlinescriprs-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:InlineScripts',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['InlineScripts'] = $dir . 'InlineScripts.i18n.php';
$wgAutoloadClasses['InlineScriptInterpreter'] = $dir . 'interpreter/Interpreter.php';
$wgAutoloadClasses['ISScanner'] = $dir . 'interpreter/Scanner.php';
$wgAutoloadClasses['ISLRParser'] = $dir . 'interpreter/LRParser.php';
$wgParserTestFiles[] = $dir . 'interpreterTests.txt';
$wgHooks['ParserFirstCallInit'][] = 'InlineScriptsHooks::setupParserHook';
$wgHooks['ParserClearState'][] = 'InlineScriptsHooks::clearState';
$wgHooks['ParserLimitReport'][] = 'InlineScriptsHooks::reportLimits';

$wgInlineScriptsLimits = array(
	/**
	 * Maximal amount of tokens (strings, keywords, numbers, operators,
	 * but not whitespace) to be parsed.
	 */
	'tokens' => 25000,
	/**
	 * Maximal amount of operations (multiplications, comarsionss, function
	 * calls) to be done.
	 */
	'evaluations' => 10000,
	/**
	 * Maximal depth of recursion when evaluating the parser tree. For
	 * example 2 + 2 * 2 ** 2 is parsed to (2 + (2 * (2 ** 2))) and needs
	 * depth 3 to be parsed.
	 */
	'depth' => 250,
);

$wgInlineScriptsParserClass = 'ISLRParser';

class InlineScriptsHooks {
	static $scriptParser = null;

	/**
	 * Register parser hook
	 */
	public static function setupParserHook( &$parser ) {
		$parser->setFunctionTagHook( 'wikiscript', 'InlineScriptsHooks::scriptHook', SFH_OBJECT_ARGS );
		$parser->setFunctionHook( 'inline', 'InlineScriptsHooks::inlineHook', SFH_OBJECT_ARGS );
		return true;
	}

	public static function clearState( &$parser ) {
		$parser->is_evalsCount = 0;
		$parser->is_tokensCount = 0;
		$parser->is_maxDepth = 0;
		return true;
	}

	public static function inlineHook( &$parser, $frame, $args ) {
		wfProfileIn( __METHOD__ );
		$scriptParser = self::getInterpreter();
		try {
			$result = $scriptParser->evaluate( $parser->mStripState->unstripBoth( $args[0] ),
				$parser, $frame );
		} catch( ISException $e ) {
			$msg = nl2br( htmlspecialchars( $e->getMessage() ) );
			wfProfileOut( __METHOD__ );
			return "<strong class=\"error\">{$msg}</strong>";
		}
		wfProfileOut( __METHOD__ );
		return trim( $result );
	}

	public static function scriptHook( &$parser, $frame, $code, $attribs ) {
		wfProfileIn( __METHOD__ );
		$scriptParser = self::getInterpreter();
		try {
			$result = $scriptParser->execute( $code, $parser, $frame );
		} catch( ISException $e ) {
			$msg = nl2br( htmlspecialchars( $e->getMessage() ) );
			wfProfileOut( __METHOD__ );
			return "<strong class=\"error\">{$msg}</strong>";
		}
		if( !(isset( $attribs['noparse'] ) && $attribs['noparse']) ) {
			$result = $parser->replaceVariables( $result, $frame );
		}
		wfProfileOut( __METHOD__ );
		return trim( $result );
	}

	public static function reportLimits( &$parser, &$report ) {
		global $wgInlineScriptsParserParams;
		$limits = $wgInlineScriptsParserParams['limits'];
		$report .=
			"Inline scripts parser evaluations: {$parser->is_evalsCount}/{$limits['evaluations']}\n" .
			"Inline scripts tokens: {$parser->is_tokensCount}/{$limits['tokens']}\n" .
			"Inline scripts AST maximal depth: {$parser->is_maxDepth}/{$limits['depth']}\n";
		return true;
	}

	public static function getInterpreter() {
		if( !self::$scriptParser )
			self::$scriptParser = new InlineScriptInterpreter();
		return self::$scriptParser;
	}
}
