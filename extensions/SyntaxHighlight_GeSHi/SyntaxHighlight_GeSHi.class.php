<?php

class SyntaxHighlight_GeSHi {

	/**
	 * Has GeSHi been initialised this session?
	 */
	private static $initialised = false;

	/**
	 * List of languages available to GeSHi
	 */
	private static $languages = null;

	/**
	 * Parser hook
	 *
	 * @param string $text
	 * @param array $args
	 * @param Parser $parser
	 * @return string
	 */
	public static function parserHook( $text, $args = array(), $parser ) {
		global $wgSyntaxHighlightDefaultLang, $wgUseSiteCss, $wgUseTidy;
		wfProfileIn( __METHOD__ );
		self::initialise();
		// Replace strip markers (For e.g. {{#tag:syntaxhighlight|<nowiki>...}})
		$text = $parser->mStripState->unstripNoWiki( $text );
		$text = rtrim( $text );
		// Don't trim leading spaces away, just the linefeeds
		$text = preg_replace( '/^\n+/', '', $text );

		if( $wgUseTidy ) {
			// HTML Tidy will convert tabs to spaces incorrectly (bug 30930).
			// Preemptively replace the spaces in a more controlled fashion.
			$text = self::tabsToSpaces( $text );
		}

		// Validate language
		if( isset( $args['lang'] ) && $args['lang'] ) {
			$lang = $args['lang'];
		} else {
			// language is not specified. Check if default exists, if yes, use it.
			if ( !is_null( $wgSyntaxHighlightDefaultLang ) ) {
				$lang = $wgSyntaxHighlightDefaultLang;
			} else {
				$error = self::formatLanguageError( $text );
				wfProfileOut( __METHOD__ );
				return $error;
			}
		}
		$lang = strtolower( $lang );
		if( !preg_match( '/^[a-z_0-9-]*$/', $lang ) ) {
			$error = self::formatLanguageError( $text );
			wfProfileOut( __METHOD__ );
			return $error;
		}
		$geshi = self::prepare( $text, $lang );
		if( !$geshi instanceof GeSHi ) {
			$error = self::formatLanguageError( $text );
			wfProfileOut( __METHOD__ );
			return $error;
		}

		$enclose = self::getEncloseType( $args );

		// Line numbers
		if( isset( $args['line'] ) ) {
			$geshi->enable_line_numbers( GESHI_FANCY_LINE_NUMBERS );
		}
		// Highlighting specific lines
		if( isset( $args['highlight'] ) ) {
			$lines = self::parseHighlightLines( $args['highlight'] );
			if ( count( $lines ) ) {
				$geshi->highlight_lines_extra( $lines );
			}
		}
		// Starting line number
		if( isset( $args['start'] ) ) {
			$geshi->start_line_numbers_at( $args['start'] );
		}
		$geshi->set_header_type( $enclose );
		// Strict mode
		if( isset( $args['strict'] ) ) {
			$geshi->enable_strict_mode();
		}
		// Format
		$out = $geshi->parse_code();
		if ( $geshi->error == GESHI_ERROR_NO_SUCH_LANG ) {
			// Common error :D
			$error = self::formatLanguageError( $text );
			wfProfileOut( __METHOD__ );
			return $error;
		}
		$err = $geshi->error();
		if( $err ) {
			// Other unknown error!
			$error = self::formatError( $err );
			wfProfileOut( __METHOD__ );
			return $error;
		}
		// Armour for Parser::doBlockLevels()
		if( $enclose === GESHI_HEADER_DIV ) {
			$out = str_replace( "\n", '', $out );
		}
		// Register CSS
		$parser->getOutput()->addHeadItem( self::buildHeadItem( $geshi ), "source-{$lang}" );

		if( $wgUseSiteCss ) {
			$parser->getOutput()->addModuleStyles( 'ext.geshi.local' );
		}

		$encloseTag = $enclose === GESHI_HEADER_NONE ? 'span' : 'div';
		$attribs = Sanitizer::validateTagAttributes( $args, $encloseTag );

		//lang is valid in HTML context, but also used on GeSHi
		unset( $attribs['lang'] );

		if ( $enclose === GESHI_HEADER_NONE ) {
			$attribs = self::addAttribute( $attribs, 'class', 'mw-geshi ' . $lang . ' source-' . $lang );
		} else {
			// Default dir="ltr" (but allow dir="rtl", although unsure if needed)
			$attribs['dir'] = isset( $attribs['dir'] ) && $attribs['dir'] === 'rtl' ? 'rtl' : 'ltr';
			$attribs = self::addAttribute( $attribs, 'class', 'mw-geshi mw-content-' . $attribs['dir'] );
		}
		$out = Xml::tags( $encloseTag, $attribs, $out );

		wfProfileOut( __METHOD__ );
		return $out;
	}

	/**
	 * @param $attribs array
	 * @param $name string
	 * @param $value string
	 * @return array
	 */
	private static function addAttribute( $attribs, $name, $value ) {
		if( isset( $attribs[$name] ) ) {
			$attribs[$name] = $value . ' ' . $attribs[$name];
		} else {
			$attribs[$name] = $value;
		}
		return $attribs;
	}

	/**
	 * Take an input specifying a list of lines to highlight, returning
	 * a raw list of matching line numbers.
	 *
	 * Input is comma-separated list of lines or line ranges.
	 *
	 * @param $arg string
	 * @return array of ints
	 */
	protected static function parseHighlightLines( $arg ) {
		$lines = array();
		$values = array_map( 'trim', explode( ',', $arg ) );
		foreach ( $values as $value ) {
			if ( ctype_digit($value) ) {
				$lines[] = (int) $value;
			} elseif ( strpos( $value, '-' ) !== false ) {
				list( $start, $end ) = array_map( 'trim', explode( '-', $value ) );
				if ( self::validHighlightRange( $start, $end ) ) {
					for ($i = intval( $start ); $i <= $end; $i++ ) {
						$lines[] = $i;
					}
				} else {
					wfDebugLog( 'geshi', "Invalid range: $value\n" );
				}
			} else {
				wfDebugLog( 'geshi', "Invalid line: $value\n" );
			}
		}
		return $lines;
	}

	/**
	 * Validate a provided input range
	 * @param $start
	 * @param $end
	 * @return bool
	 */
	protected static function validHighlightRange( $start, $end ) {
		// Since we're taking this tiny range and producing a an
		// array of every integer between them, it would be trivial
		// to DoS the system by asking for a huge range.
		// Impose an arbitrary limit on the number of lines in a
		// given range to reduce the impact.
		$arbitrarilyLargeConstant = 10000;
		return
			ctype_digit($start) &&
			ctype_digit($end) &&
			$start > 0 &&
			$start < $end &&
			$end - $start < $arbitrarilyLargeConstant;
	}

	/**
	 * @param $args array
	 * @return int
	 */
	static function getEncloseType( $args ) {
		// Since version 1.0.8 geshi can produce valid pre, but we need to check for it
		if ( defined('GESHI_HEADER_PRE_VALID') ) {
			$pre = GESHI_HEADER_PRE_VALID;
		} else {
			$pre = GESHI_HEADER_PRE;
		}

		// "Enclose" parameter
		$enclose = $pre;
		if ( isset( $args['enclose'] ) ) {
			if ( $args['enclose'] === 'div' ) {
				$enclose = GESHI_HEADER_DIV;
			} elseif ( $args['enclose'] === 'none' ) {
				$enclose = GESHI_HEADER_NONE;
			}
		}

		if( isset( $args['line'] ) && $pre === GESHI_HEADER_PRE ) {
			// Force <div> mode to maintain valid XHTML, see
			// http://sourceforge.net/tracker/index.php?func=detail&aid=1201963&group_id=114997&atid=670231
			$enclose = GESHI_HEADER_DIV;
		}

		return $enclose;
	}

	/**
	 * Hook into Article::view() to provide syntax highlighting for
	 * custom CSS and JavaScript pages
	 *
	 * @param string $text
	 * @param Title $title
	 * @param OutputPage $output
	 * @return bool
	 */
	public static function viewHook( $text, $title, $output ) {
		global $wgUseSiteCss;
		// Determine the language
		$matches = array();
		preg_match( '!\.(css|js)$!u', $title->getText(), $matches );
		$lang = $matches[1] == 'css' ? 'css' : 'javascript';
		// Attempt to format
		$geshi = self::prepare( $text, $lang );
		if( $geshi instanceof GeSHi ) {
			$out = $geshi->parse_code();
			if( !$geshi->error() ) {
				// Done
				$output->addHeadItem( "source-$lang", self::buildHeadItem( $geshi ) );
				$output->addHTML( "<div dir=\"ltr\">{$out}</div>" );
				if( $wgUseSiteCss ) {
					$output->addModuleStyles( 'ext.geshi.local' );
				}
				return false;
			}
		}
		// Bottle out
		return true;
	}

	/**
	 * Initialise a GeSHi object to format some code, performing
	 * common setup for all our uses of it
	 *
	 * @param string $text
	 * @param string $lang
	 * @return GeSHi
	 */
	public static function prepare( $text, $lang ) {
		global $wgTitle, $wgOut;

		self::initialise();
		$geshi = new GeSHi( $text, $lang );
		if( $geshi->error() == GESHI_ERROR_NO_SUCH_LANG ) {
			return null;
		}
		$geshi->set_encoding( 'UTF-8' );
		$geshi->enable_classes();
		$geshi->set_overall_class( "source-$lang" );
		$geshi->enable_keyword_links( false );

		// Wikia change start
		if( $wgTitle instanceof Title && EditPageLayoutHelper::isCodeSyntaxHighlightingEnabled( $wgTitle ) ) {
			$theme = 'solarized-light';
			if( SassUtil::isThemeDark() ) {
				$theme = 'solarized-dark';
			}
			$geshi->set_language_path(GESHI_ROOT . $theme . DIRECTORY_SEPARATOR);
			$geshi->set_overall_id('theme-' . $theme);

			$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/SyntaxHighlight_GeSHi/styles/solarized.scss'));
		}
		// Wikia change end

		return $geshi;
	}

	/**
	 * Prepare a CSS snippet suitable for use as a ParserOutput/OutputPage
	 * head item
	 *
	 * @param GeSHi $geshi
	 * @return string
	 */
	public static function buildHeadItem( $geshi ) {
		global $wgUseSiteCss, $wgSquidMaxage;
		// begin Wikia change
		// VOLDEV-85
		// backporting core fix to monobook font size
		/**
		 * GeSHi comes by default with a font-family set to monospace, which
		 * causes the font-size to be smaller than one would expect.
		 * We append a CSS hack to the default GeSHi styles: specifying 'monospace'
		 * twice "resets" the browser font-size specified for monospace.
		 *
		 * The hack is documented in MediaWiki core under
		 * docs/uidesign/monospace.html and in bug 33496.
		 */
		// Preserve default since we don't want to override the other style
		// properties set by geshi (padding, font-size, vertical-align etc.)
		$geshi->set_code_style(
			'font-family: monospace, monospace;',
			/* preserve defaults = */ true
		);

		// No need to preserve default (which is just "font-family: monospace;")
		// outputting both is unnecessary
		$geshi->set_overall_style(
			'font-family: monospace, monospace;',
			/* preserve defaults = */ false
		);
		// end Wikia change

		$lang = $geshi->language;
		$css = array();
		$css[] = '<style type="text/css">/*<![CDATA[*/';
		$css[] = ".source-$lang {line-height: normal;}";
		$css[] = ".source-$lang li, .source-$lang pre {";
		$css[] = "\tline-height: normal; border: 0px none white;";
		$css[] = "}";
		$css[] = $geshi->get_stylesheet( false );
		$css[] = '/*]]>*/';
		$css[] = '</style>';
		return implode( "\n", $css );
	}

	/**
	 * Format an 'unknown language' error message and append formatted
	 * plain text to it.
	 *
	 * @param string $text
	 * @return string HTML fragment
	 */
	private static function formatLanguageError( $text ) {
		$error = self::formatError( htmlspecialchars( wfMsgForContent( 'syntaxhighlight-err-language' ) ), $text );
		return $error . '<pre>' . htmlspecialchars( $text ) . '</pre>';
	}

	/**
	 * Format an error message
	 *
	 * @param string $error
	 * @return string
	 */
	private static function formatError( $error = '' ) {
		$html = '';
		if( $error ) {
			$html .= "<p>{$error}</p>";
		}
		$html .= '<p>' . htmlspecialchars( wfMsgForContent( 'syntaxhighlight-specify' ) )
			. ' <samp>&lt;source lang=&quot;html4strict&quot;&gt;...&lt;/source&gt;</samp></p>'
			. '<p>' . htmlspecialchars( wfMsgForContent( 'syntaxhighlight-supported' ) ) . '</p>'
			. self::formatLanguages();
		return "<div style=\"border: solid red 1px; padding: .5em;\">{$html}</div>";
	}

	/**
	 * Format the list of supported languages
	 *
	 * @return string
	 */
	private static function formatLanguages() {
		$langs = self::getSupportedLanguages();
		$list = array();
		if( count( $langs ) > 0 ) {
			foreach( $langs as $lang ) {
				$list[] = '<samp>' . htmlspecialchars( $lang ) . '</samp>';
			}
			return '<p class="mw-collapsible mw-collapsed" style="padding: 0em 1em;">' . implode( ', ', $list ) . '</p><br style="clear: all"/>';
		} else {
			return '<p>' . htmlspecialchars( wfMsgForContent( 'syntaxhighlight-err-loading' ) ) . '</p>';
		}
	}

	/**
	 * Get the list of supported languages
	 *
	 * @return array
	 */
	private static function getSupportedLanguages() {
		if( !is_array( self::$languages ) ) {
			self::initialise();
			self::$languages = array();
			foreach( glob( GESHI_LANG_ROOT . "/*.php" ) as $file ) {
				self::$languages[] = basename( $file, '.php' );
			}
			sort( self::$languages );
		}
		return self::$languages;
	}

	/**
	 * Initialise messages and ensure the GeSHi class is loaded
	 * @return bool
	 */
	private static function initialise() {
		if( !self::$initialised ) {
			if( !class_exists( 'GeSHi' ) ) {
				require( 'geshi/geshi.php' );
			}
			self::$initialised = true;
		}
		return true;
	}

	/**
	 * Get the GeSHI's version information while Special:Version is read.
	 * @param $extensionTypes
	 * @return bool
	 */
	public static function hSpecialVersion_GeSHi( &$extensionTypes ) {
		global $wgExtensionCredits;
		self::initialise();
		$wgExtensionCredits['parserhook']['SyntaxHighlight_GeSHi']['version'] = GESHI_VERSION;
		return true;
	}

	/**
	 * @see SyntaxHighlight_GeSHi::hSpecialVersion_GeSHi
	 * @param $sp
	 * @param $extensionTypes
	 * @return bool
	 */
	public static function hOldSpecialVersion_GeSHi( &$sp, &$extensionTypes ) {
		return self::hSpecialVersion_GeSHi( $extensionTypes );
	}

	/**
	 * Convert tabs to spaces
	 *
	 * @param string $text
	 * @return string
	 */
	private static function tabsToSpaces( $text ) {
		$lines = explode( "\n", $text );
		$lines = array_map( array( __CLASS__, 'tabsToSpacesLine' ), $lines );
		return implode( "\n", $lines );
	}

	/**
	 * Convert tabs to spaces for a single line
	 *
	 * @param $line
	 * @internal param string $text
	 * @return string
	 */
	private static function tabsToSpacesLine( $line ) {
		$parts = explode( "\t", $line );
		$width = 8; // To match tidy's config & typical browser defaults
		$out = $parts[0];
		foreach( array_slice( $parts, 1 ) as $chunk ) {
			$spaces = $width - (strlen( $out ) % $width);
			$out .= str_repeat( ' ', $spaces );
			$out .= $chunk;
		}
		return $out;
	}
}
