<?php
/**
 * Wikitext scripting infrastructure for MediaWiki: hooks.
 * Copyright (C) 2009-2012 Victor Vasiliev <vasilvv@gmail.com>
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
 * Hooks for the Scribunto extension.
 */
class ScribuntoHooks {
	/**
	 * Register parser hooks.
	 * @param $parser Parser
	 * @return bool
	 */
	public static function setupParserHook( &$parser ) {
		$parser->setFunctionHook( 'invoke', 'ScribuntoHooks::invokeHook', SFH_OBJECT_ARGS );
		return true;
	}

	/**
	 * Called when the interpreter is to be reset.
	 *
	 * @param $parser Parser
	 * @return bool
	 */
	public static function clearState( &$parser ) {
		Scribunto::resetParserEngine( $parser );
		return true;
	}

	/**
	 * Called when the parser is cloned
	 *
	 * @param $parser Parser
	 * @return bool
	 */
	public static function parserCloned( $parser ) {
		$parser->scribunto_engine = null;
		return true;
	}

	/**
	 * Hook function for {{#invoke:module|func}}
	 *
	 * @param $parser Parser
	 * @param $frame PPFrame
	 * @param $args array
	 * @throws MWException
	 * @throws ScribuntoException
	 * @return string
	 */
	public static function invokeHook( &$parser, $frame, $args ) {
		if ( !@constant( get_class( $frame ) . '::SUPPORTS_INDEX_OFFSET' ) ) {
			throw new MWException(
				'Scribunto needs MediaWiki 1.20 or later (Preprocessor::SUPPORTS_INDEX_OFFSET)' );
		}

		wfProfileIn( __METHOD__ );

		try {
			if ( count( $args ) < 2 ) {
				throw new ScribuntoException( 'scribunto-common-nofunction' );
			}
			$moduleName = trim( $frame->expand( $args[0] ) );
			$engine = Scribunto::getParserEngine( $parser );
			$title = Title::makeTitleSafe( NS_MODULE, $moduleName );
			if ( !$title ) {
				throw new ScribuntoException( 'scribunto-common-nosuchmodule' );
			}
			$module = $engine->fetchModuleFromParser( $title );
			if ( !$module ) {
				throw new ScribuntoException( 'scribunto-common-nosuchmodule' );
			}
			$functionName = trim( $frame->expand( $args[1] ) );

			unset( $args[0] );
			unset( $args[1] );
			$childFrame = $frame->newChild( $args, $title, 1 );
			$result = $module->invoke( $functionName, $childFrame );
			$result = UtfNormal::cleanUp( strval( $result ) );

			wfProfileOut( __METHOD__ );
			return $result;
		} catch( ScribuntoException $e ) {
			$trace = $e->getScriptTraceHtml( array( 'msgOptions' => array( 'content' ) ) );
			$html = Html::element( 'p', array(), $e->getMessage() );
			if ( $trace !== false ) {
				$html .= Html::element( 'p',
					array(),
					wfMessage( 'scribunto-common-backtrace' )->inContentLanguage()->text()
				) . $trace;
			}
			$out = $parser->getOutput();
			if ( !isset( $out->scribunto_errors ) ) {
				$out->addOutputHook( 'ScribuntoError' );
				$out->scribunto_errors = array();
				$parser->addTrackingCategory( 'scribunto-common-error-category' );
			}

			$out->scribunto_errors[] = $html;
			$id = 'mw-scribunto-error-' . ( count( $out->scribunto_errors ) - 1 );
			$parserError = wfMessage( 'scribunto-parser-error' )->inContentLanguage()->text() .
				$parser->insertStripItem( '<!--' . htmlspecialchars( $e->getMessage() ) . '-->' );
			wfProfileOut( __METHOD__ );

			// #iferror-compatible error element
			return "<strong class=\"error\"><span class=\"scribunto-error\" id=\"$id\">" .
				$parserError. "</span></strong>";
		}
	}

	/**
	 * Overrides the standard view for modules. Enables syntax highlighting when
	 * possible.
	 *
	 * @param $text string
	 * @param $title Title
	 * @param $output OutputPage
	 * @return bool
	 */
	public static function handleScriptView( $text, $title, $output ) {
		global $wgScribuntoUseGeSHi;

		if( $title->getNamespace() == NS_MODULE ) {
			$engine = Scribunto::newDefaultEngine();
			$language = $engine->getGeSHiLanguage();

			if( $wgScribuntoUseGeSHi && $language ) {
				$geshi = SyntaxHighlight_GeSHi::prepare( $text, $language );
				$geshi->set_language( $language );
				if( $geshi instanceof GeSHi && !$geshi->error() ) {
					$code = $geshi->parse_code();
					if( $code ) {
						$output->addHeadItem( "source-{$language}", SyntaxHighlight_GeSHi::buildHeadItem( $geshi ) );
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
	 * @param $title Title
	 * @param $lang string
	 * @return bool
	 */
	public static function getCodeLanguage( $title, &$lang ) {
		global $wgScribuntoUseCodeEditor;
		if( $wgScribuntoUseCodeEditor && $title->getNamespace() == NS_MODULE ) {
			$engine = Scribunto::newDefaultEngine();
			if( $engine->getCodeEditorLanguage() ) {
				$lang = $engine->getCodeEditorLanguage();
				return false;
			}
		}

		return true;
	}

	/**
	 * Indicates that modules are not wikitext.
	 * @param $title Title
	 * @param $result
	 * @return bool
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
	 * @param $parser Parser
	 * @param $report
	 * @return bool
	 */
	public static function reportLimits( $parser, &$report ) {
		if ( Scribunto::isParserEnginePresent( $parser ) ) {
			$engine = Scribunto::getParserEngine( $parser );
			$report .= $engine->getLimitReport();
		}
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

	/**
	 * EditPageBeforeEditChecks hook
	 * @param $editor EditPage
	 * @param $checkboxes Checkbox array
	 * @param $tabindex Current tabindex
	 */
	public static function beforeEditChecks( &$editor, &$checkboxes, &$tabindex ) {
		if ( $editor->getTitle()->getNamespace() !== NS_MODULE ) {
			return true;
		}

		$req = RequestContext::getMain()->getRequest();
		$name = 'scribunto_ignore_errors';

		$attribs = array(
			'tabindex' => ++$tabindex,
			'id' => "mw-$name",
		);
		$checkboxes['scribunto'] =
			Xml::check( $name, $req->getCheck( $name ), $attribs ) .
			'&#160;' .
			Xml::label( wfMessage( 'scribunto-ignore-errors' )->text(), "mw-$name" );

		// While we're here, lets set up the edit module
		global $wgOut;
		$wgOut->addModules( 'ext.scribunto.edit' );
		$editor->editFormTextAfterTools = '<div id="mw-scribunto-console"></div>';
		return true;
	}

	/**
	 * Wikia change - Add modules and console in the editor in Oasis
	 *
	 * @param  EditPage $editPage
	 * @param  Array   $hidden
	 * @return bool
	 */
	public static function onAfterDisplayingTextbox( EditPage $editPage, &$hidden ) {
		$app = F::app();
		if ( !$app->checkSkin( 'oasis' ) || $editPage->getTitle()->getNamespace() !== NS_MODULE ) {
			return true;
		}

		$editPage->addCustomCheckbox( 'scribunto_ignore_errors', wfMessage( 'scribunto-ignore-errors' )->escaped(), false );

		$app->wg->Out->addModules( 'ext.scribunto.edit' );
		$app->wg->Out->addHtml( '<div class="wikia-scribunto-console"><div id="mw-scribunto-console"></div></div>' );

		return true;
	}

	/**
	 * EditPageBeforeEditButtons hook
	 * @param $editor EditPage
	 * @param $buttons Button array
	 * @param $tabindex Current tabindex
	 */
	public static function beforeEditButtons( &$editor, &$buttons, &$tabindex ) {
		if ( $editor->getTitle()->getNamespace() !== NS_MODULE ) {
			return true;
		}

		unset( $buttons['preview'] );
		return true;
	}

	/**
	 * @param $editor EditPage
	 * @param $text string
	 * @param $error
	 * @param $summary
	 * @return bool
	 */
	public static function validateScript( $editor, $text, &$error, $summary ) {
		global $wgOut;
		$title = $editor->getTitle();

		if( $title->getNamespace() != NS_MODULE ) {
			return true;
		}

		$req = RequestContext::getMain()->getRequest();
		if ( $req->getBool( 'scribunto_ignore_errors' ) ) {
			return true;
		}

		$engine = Scribunto::newDefaultEngine();
		$engine->setTitle( $title );
		$status = $engine->validate( $text, $title->getPrefixedDBkey() );
		if( $status->isOK() ) {
			return true;
		}

		$errmsg = $status->getWikiText( 'scribunto-error-short', 'scribunto-error-long' );
		$error = <<<WIKI
<div class="errorbox">
{$errmsg}
</div>
<br clear="all" />
WIKI;
		if ( isset( $status->scribunto_error->params['module'] ) ) {
			$module = $status->scribunto_error->params['module'];
			$line = $status->scribunto_error->params['line'];
			if ( $module === $title->getPrefixedDBkey() && preg_match( '/^\d+$/', $line ) ) {
				$wgOut->addInlineScript( 'window.location.hash = ' . Xml::encodeJsVar( "#mw-ce-l$line" ) );
			}
		}

		return true;
	}

	/**
	 * @param $files array
	 * @return bool
	 */
	public static function unitTestsList( &$files ) {
		$tests = array(
			'engines/LuaStandalone/LuaStandaloneInterpreterTest.php',
			'engines/LuaStandalone/StandaloneTest.php',
			'engines/LuaSandbox/LuaSandboxInterpreterTest.php',
			'engines/LuaSandbox/SandboxTest.php',
			'engines/LuaCommon/LuaEnvironmentComparisonTest.php',
			'engines/LuaCommon/CommonTest.php',
			'engines/LuaCommon/SiteLibraryTest.php',
			'engines/LuaCommon/UriLibraryTest.php',
			'engines/LuaCommon/UstringLibraryTest.php',
		);
		foreach ( $tests as $test ) {
			$files[] = dirname( __FILE__ ) .'/../tests/' . $test;
		}
		return true;
	}

	/**
	 * @param $outputPage OutputPage
	 * @param $parserOutput ParserOutput
	 */
	public static function parserOutputHook( $outputPage, $parserOutput ) {
		$outputPage->addModules( 'ext.scribunto' );
		$outputPage->addInlineScript( 'mw.loader.using("ext.scribunto", function() {' .
			Xml::encodeJsCall( 'mw.scribunto.setErrors', array( $parserOutput->scribunto_errors ) )
			. '});' );
	}
}
