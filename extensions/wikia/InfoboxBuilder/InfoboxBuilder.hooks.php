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
	 * @param  Parser $parser Parser object
	 * @return bool           Always true to continue loading other hooks.
	 */
	public static function setupParserHook( \Parser $parser ) {
		$parser->setFunctionHook( 'infoboxbuilder', '\InfoboxBuilder\InfoboxBuilderHooks::parserFunctionHook', SFH_OBJECT_ARGS );
		return true;
	}

	/**
	 * Function executed by use of {{#infoboxbuilder:}} parser function.
	 * It gets the code from InfoboxBuilder.lua and creates new module object
	 * from it. The module is then invoked and the result is returned.
	 * @param  Parser  $parser Parser object
	 * @param  PPFrame $frame  PPFrame object
	 * @param  array   $args   Array of arguments passed from $frame object
	 * @return string          A string returned by InfoboxBuilder.lua
	 */
	public static function parserFunctionHook( \Parser $parser, $frame, $args ) {
		wfProfileIn( __METHOD__ );

		try {
			/**
			 * Add the registered SCSS with the default theme
			 */
			$parser->getOutput()->addModuleStyles( 'ext.wikia.InfoboxBuilder' );

			$engine = \Scribunto::getParserEngine( $parser );

			unset( $args[0] );
			$childFrame = $frame->newChild( $args, $parser->getTitle(), 1 );

			$moduleText = file_get_contents( __DIR__ . '/includes/lua/InfoboxBuilder.lua' );
			$module = new \Scribunto_LuaModule( $engine, $moduleText, 'InfoboxBuilder' );
			$result = $module->invoke( 'builder', $childFrame );
			$result = \UtfNormal::cleanUp( strval( $result ) );

			wfProfileOut( __METHOD__ );
			return $result;
		} catch( \ScribuntoException $e ) {
			$trace = $e->getScriptTraceHtml( array( 'msgOptions' => array( 'content' ) ) );
			$html = \Html::element( 'p', array(), $e->getMessage() );
			if ( $trace !== false ) {
				$html .= \Html::element( 'p',
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
	 * Function that adds SCSS to output.
	 * @param  EditPageLayoutController $controller
	 * @return true (to proceed with hooks loading)
	 */
	public static function addInfoboxBuilderStyles( \EditPageLayoutController $controller ) {
		$controller->getContext()->getOutput()->addModuleStyles( 'ext.wikia.InfoboxBuilder' );
		return true;
	}
}
