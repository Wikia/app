<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();
/**#@+
 * A parser extension that adds two functions, #lst and #lstx, and the
 * <section> tag, for transcluding marked sections of text.
 *
 * @file
 * @ingroup Extensions
 *
 * @link http://www.mediawiki.org/wiki/Extension:Labeled_Section_Transclusion Documentation
 *
 * @bug 5881
 *
 * @author Steve Sanbeg
 * @copyright Copyright © 2006, Steve Sanbeg
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

##
# Standard initialisation code
##

$wgHooks['ParserFirstCallInit'][] = 'LabeledSectionTransclusion::setup';
// @todo FIXME: LanguageGetMagic is obsolete, but LabeledSectionTransclusion::setupMagic()
//              contains magic hack that $magicWords cannot handle.
$wgHooks['LanguageGetMagic'][] = 'LabeledSectionTransclusion::setupMagic';

$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'name'           => 'LabeledSectionTransclusion',
	'author'         => 'Steve Sanbeg',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Labeled_Section_Transclusion',
	'descriptionmsg' => 'lst-desc',
);
$wgParserTestFiles[] = dirname( __FILE__ ) . "/lstParserTests.txt";
$wgExtensionMessagesFiles['LabeledSectionTransclusion'] = dirname( __FILE__ ) . '/lst.i18n.php';

// Local settings variable
// Must be set now to avoid injection via register_globals
$wgLstLocal = null;

// @todo FIXME: move to a separate file.
class LabeledSectionTransclusion {
	static function setup( $parser ) {
		$parser->setHook( 'section', array( __CLASS__, 'noop' ) );
		$parser->setFunctionHook( 'lst', array( __CLASS__, 'pfuncIncludeObj' ), SFH_OBJECT_ARGS );
		$parser->setFunctionHook( 'lstx', array( __CLASS__, 'pfuncExcludeObj' ), SFH_OBJECT_ARGS );

		return true;
	}

	// / Add the magic words - possibly with more readable aliases
	static function setupMagic( &$magicWords, $langCode ) {
		global $wgParser, $wgLstLocal;

		switch( $langCode ) {
		case 'de':
			$include = 'Abschnitt';
			$exclude = 'Abschnitt-x';
			$wgLstLocal = array( 'section' => 'Abschnitt', 'begin' => 'Anfang', 'end' => 'Ende' ) ;
		break;
		case 'he':
			$include = 'קטע';
			$exclude = 'בלי קטע';
			$wgLstLocal = array( 'section' => 'קטע', 'begin' => 'התחלה', 'end' => 'סוף' ) ;
		break;
		case 'pt':
			$include = 'trecho';
			$exclude = 'trecho-x';
			$wgLstLocal = array( 'section' => 'trecho', 'begin' => 'começo', 'end' => 'fim' );
			break;
		}

		if ( isset( $include ) ) {
			$magicWords['lst'] = array( 0, 'lst', 'section', $include );
			$magicWords['lstx'] = array( 0, 'lstx', 'section-x', $exclude );
			$wgParser->setHook( $include, array( __CLASS__, 'noop' ) );
		} else {
			$magicWords['lst'] = array( 0, 'lst', 'section' );
			$magicWords['lstx'] = array( 0, 'lstx', 'section-x' );
		}

		return true;
	}

	##############################################################
	# To do transclusion from an extension, we need to interact with the parser
	# at a low level. This is the general transclusion functionality
	##############################################################

	/// Register what we're working on in the parser, so we don't fall into a trap.
	static function open_( $parser, $part1 ) {
		// Infinite loop test
		if ( isset( $parser->mTemplatePath[$part1] ) ) {
			wfDebug( __METHOD__ . ": template loop broken at '$part1'\n" );
			return false;
		} else {
			$parser->mTemplatePath[$part1] = 1;
			return true;
		}

	}

	/// Finish processing the function.
	static function close_( $parser, $part1 ) {
		// Infinite loop test
		if ( isset( $parser->mTemplatePath[$part1] ) ) {
			unset( $parser->mTemplatePath[$part1] );
		} else {
			wfDebug( __METHOD__ . ": close unopened template loop at '$part1'\n" );
		}
	}

	/**
	 * Handle recursive substitution here, so we can break cycles, and set up
	 * return values so that edit sections will resolve correctly.
	 * @param Parser $parser
	 * @param Title $title of target page
	 * @param string $text
	 * @param string $part1 Key for cycle detection
	 * @param int $skiphead Number of source string headers to skip for numbering
	 * @return mixed string or magic array of bits
	 * @todo handle mixed-case </section>
	 * @private
	 */
	static function parse_( $parser, $title, $text, $part1, $skiphead = 0 ) {
		// if someone tries something like<section begin=blah>lst only</section>
		// text, may as well do the right thing.
		$text = str_replace( '</section>', '', $text );

		if ( self::open_( $parser, $part1 ) ) {
			// Try to get edit sections correct by munging around the parser's guts.
			return array( $text, 'title' => $title, 'replaceHeadings' => true,
					 'headingOffset' => $skiphead, 'noparse' => false, 'noargs' => false );
		} else {
			return "[[" . $title->getPrefixedText() . "]]" .
				"<!-- WARNING: LST loop detected -->";
		}

	}

	##############################################################
	# And now, the labeled section transclusion
	##############################################################

	/**
	 * Parser tag hook for <section>.
	 * The section markers aren't paired, so we only need to remove them.
	 *
	 * @param string $in
	 * @param array $assocArgs
	 * @param Parser $parser
	 * @return string HTML output
	 */
	static function noop( $in, $assocArgs = array(), $parser = null ) {
		return '';
	}

	/**
	 * Generate a regex to match the section(s) we're interested in.
	 * @param string $sec Name of target section
	 * @param string $to Optional name of section to end with, if transcluding
	 *                   multiple sections in sequence. If blank, will assume
	 *                   same section name as started with.
	 * @return string regex
	 * @private
	 */
	static function getPattern_( $sec, $to ) {
		global $wgLstLocal;

		$beginAttr = self::getAttrPattern_( $sec, 'begin' );
		if ( $to == '' ) {
			$endAttr = self::getAttrPattern_( $sec, 'end' );
		} else {
			$endAttr = self::getAttrPattern_( $to, 'end' );
		}

		if ( isset( $wgLstLocal ) ) {
			$section_re = "(?i:section|$wgLstLocal[section])";
		} else {
			$section_re = "(?i:section)";
		}

		return "/<$section_re$beginAttr\/?>(.*?)\n?<$section_re$endAttr\/?>/s";
	}

	/**
	 * Generate a regex fragment matching the attribute portion of a section tag
	 * @param string $sec Name of the target section
	 * @param string $type Either "begin" or "end" depending on the type of section tag to be matched
	 */
	static function getAttrPattern_( $sec, $type ) {
		global $wgLstLocal;
		$sec = preg_quote( $sec, '/' );
		$ws = "(?:\s+[^>]*)?"; // was like $ws="\s*"
		if ( isset( $wgLstLocal ) ) {
			if ( $type == 'begin' ) {
				$attrName = "(?i:begin|{$wgLstLocal['begin']})";
			} else {
				$attrName = "(?i:end|{$wgLstLocal['end']})";
			}
		} else {
			if ( $type == 'begin' ) {
				$attrName = "(?i:begin)";
			} else {
				$attrName = "(?i:end)";
			}
		}
		return "$ws\s+$attrName=(?:$sec|\"$sec\"|'$sec')$ws";
	}

	/**
	 * Count headings in skipped text.
	 *
	 * Count skipped headings, so parser (as of r18218) can skip them, to
	 * prevent wrong heading links (see bug 6563).
	 *
	 * @param string $text
	 * @param int $limit Cutoff point in the text to stop searching
	 * @return int Number of matches
	 * @private
	 */
	static function countHeadings_( $text, $limit ) {
		$pat = '^(={1,6}).+\1\s*$()';

		// return preg_match_all( "/$pat/im", substr($text,0,$limit), $m);

		$count = 0;
		$offset = 0;
		$m = array();
		while ( preg_match( "/$pat/im", $text, $m, PREG_OFFSET_CAPTURE, $offset ) ) {
			if ( $m[2][1] > $limit ) {
				break;
			}

			$count++;
			$offset = $m[2][1];
		}

		return $count;
	}

	/**
	 * Fetches content of target page if valid and found, otherwise
	 * produces wikitext of a link to the target page.
	 *
	 * @param Parser $parser
	 * @param string $page title text of target page
	 * @param (out) Title $title normalized title object
	 * @param (out) string $text wikitext output
	 * @return string bool true if returning text, false if target not found
	 * @private
	 */
	static function getTemplateText_( $parser, $page, &$title, &$text )	{
		$title = Title::newFromText( $page );

		if ( is_null( $title ) ) {
			$text = '';
			return true;
		} else {
			if ( method_exists( $parser, 'fetchTemplateAndTitle' ) ) {
				list( $text, $title ) = $parser->fetchTemplateAndTitle( $title );
			} else {
				$text = $parser->fetchTemplate( $title );
			}
		}

		// if article doesn't exist, return a red link.
		if ( $text == false ) {
			$text = "[[" . $title->getPrefixedText() . "]]";
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Set up some variables for MW-1.12 parser functions
	 */
	static function setupPfunc12( $parser, $frame, $args, $func = 'lst' ) {
		if ( !count( $args ) ) {
			return '';
		}

		$title = Title::newFromText( trim( $frame->expand( array_shift( $args ) ) ) );
		if ( !$title ) {
			return '';
		}
		if ( !$frame->loopCheck( $title ) ) {
			return "[[" . $title->getPrefixedText() . "]]" .
				"<!-- WARNING: LST loop detected -->";
		}

		list( $root, $finalTitle ) = $parser->getTemplateDom( $title );

		// if article doesn't exist, return a red link.
		if ( $root === false ) {
			return "[[" . $title->getPrefixedText() . "]]";
		}

		$newFrame = $frame->newChild( false, $finalTitle );
		if ( !count( $args ) ) {
			return $newFrame->expand( $root );
		}

		$begin = trim( $frame->expand( array_shift( $args ) ) );

		if ( $func == 'lstx' ) {
			if ( !count( $args ) ) {
				$repl = '';
			} else {
				$repl = trim( $frame->expand( array_shift( $args ) ) );
			}
		}

		if ( !count( $args ) ) {
			$end = $begin;
		} else {
			$end = trim( $frame->expand( array_shift( $args ) ) );
		}

		$beginAttr = self::getAttrPattern_( $begin, 'begin' );
		$beginRegex = "/^$beginAttr$/s";
		$endAttr = self::getAttrPattern_( $end, 'end' );
		$endRegex = "/^$endAttr$/s";

		return compact( 'dom', 'root', 'newFrame', 'repl', 'beginRegex', 'begin', 'endRegex' );
	}

	/**
	 * Returns true if the given extension name is "section"
	 */
	static function isSection( $name ) {
		global $wgLstLocal;
		$name = strtolower( $name );
		return $name == 'section'
			|| ( isset( $wgLstLocal['section'] ) && strtolower( $wgLstLocal['section'] ) == $name );
	}

	/**
	 * Returns the text for the inside of a split <section> node
	 */
	static function expandSectionNode( $parser, $frame, $parts ) {
		if ( isset( $parts['inner'] ) ) {
			return $parser->replaceVariables( $parts['inner'], $frame );
		} else {
			return '';
		}
	}

	/**
	 * MW 1.12 version of #lst
	 */
	static function pfuncIncludeObj( $parser, $frame, $args ) {
		$setup = self::setupPfunc12( $parser, $frame, $args, 'lst' );
		if ( !is_array( $setup ) ) {
			return $setup;
		}
		extract( $setup );

		$text = '';
		$node = $root->getFirstChild();
		while ( $node ) {
			// If the name of the begin node was specified, find it.
			// Otherwise transclude everything from the beginning of the page.
			if ( $begin != '' ) {
				// Find the begin node
				$found = false;
				for ( ; $node; $node = $node->getNextSibling() ) {
					if ( $node->getName() != 'ext' ) {
						continue;
					}
					$parts = $node->splitExt();
					$parts = array_map( array( $newFrame, 'expand' ), $parts );
					if ( self::isSection( $parts['name'] ) ) {
						if ( preg_match( $beginRegex, $parts['attr'] ) ) {
							$found = true;
							break;
						}
					}
				}
				if ( !$found || !$node ) {
					break;
				}
			}

			// Write the text out while looking for the end node
			$found = false;
			for ( ; $node; $node = $node->getNextSibling() ) {
				if ( $node->getName() === 'ext' ) {
					$parts = $node->splitExt();
					$parts = array_map( array( $newFrame, 'expand' ), $parts );
					if ( self::isSection( $parts['name'] ) ) {
						if ( preg_match( $endRegex, $parts['attr'] ) ) {
							$found = true;
							break;
						}
						$text .= self::expandSectionNode( $parser, $newFrame, $parts );
					} else {
						$text .= $newFrame->expand( $node );
					}
				} else {
					$text .= $newFrame->expand( $node );
				}
			}
			if ( !$found ) {
				break;
			} elseif ( $begin == '' ) {
				// When the end node was found and text is transcluded from 
				// the beginning of the page, finish the transclusion
				break;
			}

			$node = $node->getNextSibling();
		}
		return $text;
	}

	/**
	 * MW 1.12 version of #lstx
	 */
	static function pfuncExcludeObj( $parser, $frame, $args ) {
		$setup = self::setupPfunc12( $parser, $frame, $args, 'lstx' );
		if ( !is_array( $setup ) ) {
			return $setup;
		}
		extract( $setup );

		$text = '';
		for ( $node = $root->getFirstChild(); $node; $node = $node ? $node->getNextSibling() : false ) {
			// Search for the start tag
			$found = false;
			for ( ; $node; $node = $node->getNextSibling() ) {
				if ( $node->getName() == 'ext' ) {
					$parts = $node->splitExt();
					$parts = array_map( array( $newFrame, 'expand' ), $parts );
					if ( self::isSection( $parts['name'] ) ) {
						if ( preg_match( $beginRegex, $parts['attr'] ) ) {
							$found = true;
							break;
						}
						$text .= self::expandSectionNode( $parser, $newFrame, $parts );
					} else {
						$text .= $newFrame->expand( $node );
					}
				} else {
					$text .= $newFrame->expand( $node );
				}
			}

			if ( !$found ) {
				break;
			}

			// Append replacement text
			$text .= $repl;

			// Search for the end tag
			for ( ; $node; $node = $node->getNextSibling() ) {
				if ( $node->getName() == 'ext' ) {
					$parts = $node->splitExt( $node );
					$parts = array_map( array( $newFrame, 'expand' ), $parts );
					if ( self::isSection( $parts['name'] ) ) {
						if ( preg_match( $endRegex, $parts['attr'] ) ) {
							$text .= self::expandSectionNode( $parser, $newFrame, $parts );
							break;
						}
					}
				}
			}
		}
		return $text;
	}
}
# vim: sw=2 sts=2 et :
