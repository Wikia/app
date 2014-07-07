<?php
/**
 * Built-in scripting language for MediaWiki: hooks.
 * Copyright (C) 2009-2011 Victor Vasiliev <vasilvv@gmail.com>
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
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

/**
 * Hooks for WikiScripts extension.
 */
class WSHooks {
	/**
	 * Returns the interpreter for a given parser.
	 * 
	 * @static
	 * @return WSIntepreter
	 */
	public static function getInterpreter( $parser ) {
		if( !isset( $parser->is_interpreter ) || !$parser->is_interpreter ) {
			$parser->is_interpreter = new WSInterpreter( $parser );
		}
		return $parser->is_interpreter;
	}

	/**
	 * Register parser hooks.
	 * @param $parser Parser
	 */
	public static function setupParserHook( &$parser ) {
		$parser->setFunctionHook( 'invoke', 'WSHooks::callHook', SFH_OBJECT_ARGS );
		$parser->setFunctionHook( 's', 'WSHooks::transcludeHook', SFH_NO_HASH | SFH_OBJECT_ARGS );
		return true;
	}

	/**
	 * Called when interpreter is to be reset.
	 * 
	 * @static
	 * @param  $parser Parser
	 * @return bool
	 */
	public static function clearState( &$parser ) {
		$parser->is_interpreter = null;
		return true;
	}

	/**
	 * Adds scriptlinks table to parser tests.
	 */
	public static function addTestTables( &$tables ) {
		$tables[] = 'scriptlinks';
		return true;
	}

	/**
	 * Handles the {{#invoke:module|func}} construction.
	 * 
	 * @static
	 * @param  $parser Parser
	 * @param  $frame
	 * @param  $args
	 * @return string
	 */
	public static function callHook( &$parser, $frame, $args ) {
		if( count( $args ) < 2 ) {
				throw new WSTransclusionException( 'nofunction' );
		}

		$module = $parser->mStripState->unstripBoth( array_shift( $args ) );
		$function = $frame->expand( array_shift( $args ) );
		return self::doRunHook( $parser, $frame, $module, $function, $args );
	}

	/**
	 * Handles the transclusion of the script ({{s:module}} hook).
	 * 
	 * @static
	 * @param  $parser Parser
	 * @param  $frame
	 * @param  $args
	 * @return string
	 */
	public static function transcludeHook( &$parser, $frame, $args ) {
		$module = $parser->mStripState->unstripBoth( array_shift( $args ) );
		return self::doRunHook( $parser, $frame, $module, 'main', $args );
	}

	private static function doRunHook( &$parser, $frame, $module, $function, $args ) {
		wfProfileIn( __METHOD__ );

		try {
			$i = self::getInterpreter( $parser );

			foreach( $args as &$arg ) {
				$arg = $frame->expand( $arg );
			}

			$result = $i->invokeUserFunctionFromWikitext( $module, $function, $args, $frame );

			wfProfileOut( __METHOD__ );
			return trim( $result );
		} catch( WSException $e ) {
			$msg = $e->getMessage();
			wfProfileOut( __METHOD__ );
			return "<strong class=\"error\">{$msg}</strong>";
		}
	}

	/**
	 * Overrides the standard view for modules. Enables syntax highlighting when
	 * possible.
	 * 
	 * @static
	 * @param  $text
	 * @param  $title Title
	 * @param  $output OutputPage
	 * @return bool
	 */
	public static function handleScriptView( $text, $title, $output ) {
		global $wgScriptsUseGeSHi;

		if( $title->getNamespace() == NS_MODULE ) {
			if( $wgScriptsUseGeSHi ) {
				$geshi = SyntaxHighlight_GeSHi::prepare( $text, 'wikiscript' );
				$geshi->set_language_path( dirname( __FILE__ ) . '/geshi' );
				$geshi->set_language( 'wikiscript' );
				if( $geshi instanceof GeSHi && !$geshi->error() ) {
					$code = $geshi->parse_code();
					if( $code ) {
						$output->addHeadItem( "source-wikiscript", SyntaxHighlight_GeSHi::buildHeadItem( $geshi ) );
						$output->addHTML( "<div dir=\"ltr\">{$code}</div>" );
						return false;
					}
				}
			}

			// No GeSHi, or GeSHi can't parse it, use plain <pre>
			$output->addHTML( "<pre class=\"mw-code mw-script\" dir=\"ltr\">\n" );
			$output->addHTML( htmlspecialchars( $text ) );
			$output->addHTML( "\n</pre>\n" );
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Indicates that modules are not wikitext.
	 */
	public static function isWikitextPage( $title, &$result ) {
		if( $title->getNamespace() == NS_MODULE ) {
			$result = false;
			return false;
		}
		return true;
	}

	/**
	 * Adds report of number of evaluations by the single wikitext page.
	 * 
	 * @static
	 * @param  $parser Parser
	 * @param  $report
	 * @return bool
	 */
	public static function reportLimits( $parser, &$report ) {
		global $wgScriptsLimits;
		$i = self::getInterpreter( $parser );
		$report .=
			"Scripts parser evaluations: {$i->mEvaluations}/{$wgScriptsLimits['evaluations']}\n" .
			"Scripts AST maximal depth: {$i->mMaxRecursion}/{$wgScriptsLimits['depth']}\n";
		return true;
	}

	/**
	 * Adds the module namespaces.
	 */
	public static function addCanonicalNamespaces( &$list ) {
		$list[NS_MODULE] = 'Module';
		$list[NS_MODULE_TALK] = 'Module_talk';
		return true;
	}

	public static function validateScript( $editor, $text, $section, &$error ) {
		global $wgUser;
		$title = $editor->mTitle;

		if( $title->getNamespace() == NS_MODULE ) {
			$errors = WSInterpreter::getSyntaxErrors( $title->getText(), $text );
			if( !$errors ) {
				return true;
			}

			$errmsg = wfMsgExt( 'wikiscripts-error', array( 'parsemag' ), array( count( $errors ) ) );
			$errlines = '* ' . implode( "\n* ", array_map( 'wfEscapeWikiText', $errors ) );
			$error = <<<HTML
<div class="errorbox">
{$errmsg}
{$errlines}
</div>
<br clear="all" />
HTML;

			return true;
		}
		
		return true;
	}
}
