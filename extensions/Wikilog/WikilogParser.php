<?php
/**
 * MediaWiki Wikilog extension
 * Copyright © 2008-2010 Juliano F. Ravasi
 * http://www.mediawiki.org/wiki/Extension:Wikilog
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
 * @file
 * @ingroup Extensions
 * @author Juliano F. Ravasi < dev juliano info >
 */

if ( !defined( 'MEDIAWIKI' ) )
	die();

/**
 * This class holds the parser functions that hooks into the Parser in order
 * to collect Wikilog metadata.
 */
class WikilogParser
{
	/**
	 * Anchor printed when a --more-- separator is substituted.
	 */
	const MORE_ANCHOR = "<span id=\"wl-more\"></span>";

	/**
	 * True if parsing articles with feed output specific settings.
	 * This is an horrible hack needed because of many MediaWiki misdesigns.
	 */
	static private $feedParsing = false;

	/**
	 * True if we are expanding local URLs (in order to render stand-alone,
	 * base-less feeds). This is an horrible hack needed because of many
	 * MediaWiki misdesigns.
	 */
	static private $expandingUrls = false;


	###
	## Parser hooks
	#

	/**
	 * ParserFirstCallInit hook handler function.
	 */
	public static function FirstCallInit( &$parser ) {
		$mwSummary =& MagicWord::get( 'wlk-summary' );
		foreach ( $mwSummary->getSynonyms() as $tagname ) {
			$parser->setHook( $tagname, array( 'WikilogParser', 'summary' ) );
		}

		$parser->setFunctionHook( 'wl-settings', array( 'WikilogParser', 'settings' ), SFH_NO_HASH );
		$parser->setFunctionHook( 'wl-publish',  array( 'WikilogParser', 'publish'  ), SFH_NO_HASH );
		$parser->setFunctionHook( 'wl-author',   array( 'WikilogParser', 'author'   ), SFH_NO_HASH );
		$parser->setFunctionHook( 'wl-tags',     array( 'WikilogParser', 'tags'     ), SFH_NO_HASH );
		$parser->setFunctionHook( 'wl-info',     array( 'WikilogParser', 'info'     ), SFH_NO_HASH );
		return true;
	}

	/**
	 * ParserClearState hook handler function.
	 */
	public static function ClearState( &$parser ) {
		# These two parser attributes contain our private information.
		# They take a piggyback ride on the parser object.
		$parser->mExtWikilog = new WikilogParserOutput;
		$parser->mExtWikilogInfo = null;

		# Disable TOC in feeds.
		if ( self::$feedParsing ) {
			$parser->mShowToc = false;
		}
		return true;
	}

	/**
	 * ParserBeforeStrip hook handler function.
	 */
	public static function BeforeStrip( &$parser, &$text, &$stripState ) {
		global $wgUser;

		# Do nothing if a title is not set.
		if ( ! ( $title = $parser->getTitle() )  )
			return true;

		# Do nothing if it is not a wikilog article.
		if ( ! ( $parser->mExtWikilogInfo = Wikilog::getWikilogInfo( $title ) ) )
			return true;

		if ( $parser->mExtWikilogInfo->isItem() ) {
			# By default, use the item name as the default sort in categories.
			# This can be overriden by {{DEFAULTSORT:...}} if the user wants.
			$parser->setDefaultSort( $parser->mExtWikilogInfo->getItemName() );
		}

		return true;
	}

	/**
	 * ParserAfterTidy hook handler function.
	 */
	public static function AfterTidy( &$parser, &$text ) {
		$parser->mOutput->mExtWikilog = $parser->mExtWikilog;
		return true;
	}

	/**
	 * InternalParseBeforeLinks hook handler function. Called after nowiki,
	 * comments and templates are treated.
	 * For wikilog pages, look for the "--more--" marker and extract the
	 * article summary before it. If not found, look for the first heading
	 * and use the text before it (intro section).
	 */
	public static function InternalParseBeforeLinks( &$parser, &$text, &$stripState ) {
		if ( $parser->mExtWikilogInfo && $parser->mExtWikilogInfo->isItem() ) {
			static $moreRegex = false;
			if ( $moreRegex === false ) {
				$mwMore =& MagicWord::get( 'wlk-more' );
				$words = $mwMore->getBaseRegex();
				$flags = $mwMore->getRegexCase();
				$moreRegex = "/(?<=^|\\n)--+ *(?:$words) *--+\s*/$flags";
			}

			# Find and replace the --more-- marker. Extract summary.
			# We do it anyway even if the summary is already set, in order
			# to replace the marker with an invisible anchor.
			$p = preg_split( $moreRegex, $text, 2 );
			if ( count( $p ) > 1 ) {
				self::trySetSummary( $parser, trim( $p[0] ) );
				$anchor = $parser->insertStripItem( self::MORE_ANCHOR );
				$text = $p[0] . $anchor . $p[1];
			} elseif ( !$parser->mExtWikilog->mSummary ) {
				# Otherwise, make a summary from the intro section.
				# Why we don't use $parser->getSection()? Because it has the
				# side-effect of clearing the parser state, which is bad here
				# since this hook happens during parsing. Instead, we
				# anticipate the $parser->doHeadings() call and extract the
				# text before the first heading.
				$text = $parser->doHeadings( $text );
				$p = preg_split( '/<(h[1-6])\\b.*?>.*?<\\/\\1\\s*>/i', $text, 2 );
				if ( count( $p ) > 1 ) {
					self::trySetSummary( $parser, trim( $p[0] ) );
				}
			}
		}
		return true;
	}

	/**
	 * GetLocalURL hook handler function.
	 * Expands local URL @a $url if self::$expandingUrls is true.
	 */
	public static function GetLocalURL( &$title, &$url, $query ) {
		if ( self::$expandingUrls ) {
			$url = wfExpandUrl( $url );
		}
		return true;
	}

	/**
	 * GetFullURL hook handler function.
	 * Fix some brain-damage in Title::getFullURL() (as of MW 1.13) that
	 * prepends $wgServer to URL without using wfExpandUrl(), in part because
	 * we want (above in Wikilog::GetLocalURL()) to return an absolute URL
	 * from Title::getLocalURL() in situations where action != 'render'.
	 * @todo Report this bug to MediaWiki bugzilla.
	 */
	public static function GetFullURL( &$title, &$url, $query ) {
		global $wgServer;
		if ( self::$expandingUrls ) {
			$l = strlen( $wgServer );
			if ( substr( $url, 0, 2 * $l ) == $wgServer . $wgServer ) {
				$url = substr( $url, $l );
			}
		}
		return true;
	}

	###
	## Parser tags and functions
	#

	/**
	 * Summary tag parser hook handler.
	 */
	public static function summary( $text, $params, $parser ) {
		$mwHidden =& MagicWord::get( 'wlk-hidden' );

		# Remove extra space to make block rendering easier.
		$text = trim( $text );
		self::trySetSummary( $parser, $text );

		$hidden = WikilogUtils::arrayMagicKeyGet( $params, $mwHidden );
		return $hidden ? '<!-- -->' : $parser->recursiveTagParse( $text );
	}

	/**
	 * {{wl-settings:...}} parser function handler.
	 */
	public static function settings( &$parser /* ... */ ) {
		global $wgOut;
		self::checkNamespace( $parser );

		$mwIcon     =& MagicWord::get( 'wlk-icon' );
		$mwLogo     =& MagicWord::get( 'wlk-logo' );
		$mwSubtitle =& MagicWord::get( 'wlk-subtitle' );

		$args = array_slice( func_get_args(), 1 );
		foreach ( $args as $arg ) {
			$parts = array_map( 'trim', explode( '=', $arg, 2 ) );

			if ( empty( $parts[0] ) ) continue;
			if ( count( $parts ) < 2 ) $parts[1] = '';
			list( $key, $value ) = $parts;

			if ( $mwIcon->matchStart( $key ) ) {
				if ( ( $icon = self::parseImageLink( $parser, $value ) ) ) {
					$parser->mExtWikilog->mIcon = $icon->getTitle();
				}
			} elseif ( $mwLogo->matchStart( $key ) ) {
				if ( ( $logo = self::parseImageLink( $parser, $value ) ) ) {
					$parser->mExtWikilog->mLogo = $logo->getTitle();
				}
			} elseif ( $mwSubtitle->matchStart( $key ) ) {
				$popt = $parser->getOptions();
				$popt->enableLimitReport( false );
				$output = $parser->parse( $value, $parser->getTitle(), $popt, true, false );
				$parser->mExtWikilog->mSummary = $output->getText();
			} else {
				$warning = wfMsg( 'wikilog-error-msg', wfMsg( 'wikilog-invalid-param', htmlspecialchars( $key ) ) );
				$parser->mOutput->addWarning( $warning );
			}
		}

		return '<!-- -->';
	}

	/**
	 * {{wl-publish:...}} parser function handler.
	 */
	public static function publish( &$parser, $pubdate /*, $author... */ ) {
		self::checkNamespace( $parser );

		$parser->mExtWikilog->mPublish = true;
		$args = array_slice( func_get_args(), 2 );

		# First argument is the publish date
		if ( !is_null( $pubdate ) ) {
			wfSuppressWarnings(); // Shut up E_STRICT warnings about timezone.
			$ts = strtotime( $pubdate );
			wfRestoreWarnings();
			if ( $ts > 0 ) {
				$parser->mExtWikilog->mPubDate = wfTimestamp( TS_MW, $ts );
			}
			else {
				$warning = wfMsg( 'wikilog-error-msg', wfMsg( 'wikilog-invalid-date', $pubdate ) );
				$parser->mOutput->addWarning( $warning );
			}
		}

		# Remaining arguments are author names
		foreach ( $args as $name ) {
			if ( !self::tryAddAuthor( $parser, $name ) )
				break;
		}

		return '<!-- -->';
	}

	/**
	 * {{wl-author:...}} parser function handler.
	 */
	public static function author( &$parser /*, $author... */ ) {
		self::checkNamespace( $parser );

		$args = array_slice( func_get_args(), 1 );
		foreach ( $args as $name ) {
			if ( !self::tryAddAuthor( $parser, $name ) )
				break;
		}
		return '<!-- -->';
	}

	/**
	 * {{wl-tags:...}} parser function handler.
	 */
	public static function tags( &$parser /*, $tag... */ ) {
		self::checkNamespace( $parser );

		$args = array_slice( func_get_args(), 1 );
		foreach ( $args as $tag ) {
			if ( !self::tryAddTag( $parser, $tag ) )
				break;
		}
		return '<!-- -->';
	}

	/**
	 * {{wl-info:...}} parser function handler.
	 * Provides general information about the extension.
	 */
	public static function info( &$parser, $id /*, $tag... */ ) {
		global $wgWikilogNamespaces, $wgWikilogEnableTags;
		global $wgWikilogEnableComments;
		global $wgContLang;

		$args = array_slice( func_get_args(), 2 );

		switch ( $id ) {
			case 'num-namespaces':
				return count( $wgWikilogNamespaces );
			case 'all-namespaces':
				$namespaces = array();
				foreach ( $wgWikilogNamespaces as $ns )
					$namespaces[] = $wgContLang->getFormattedNsText( $ns );
				return $wgContLang->listToText( $namespaces );
			case 'namespace-by-index':
				$index = empty( $args ) ? 0 : intval( array_shift( $args ) );
				if ( isset( $wgWikilogNamespaces[$index] ) ) {
					return $wgContLang->getFormattedNsText( $wgWikilogNamespaces[$index] );
				} else {
					return '';
				}
			case 'tags-enabled':
				return $wgWikilogEnableTags ? '*' : '';
			case 'comments-enabled':
				return $wgWikilogEnableComments ? '*' : '';
			default:
				return '';
		}
	}

	###
	## Wikilog parser settings.
	#

	/**
	 * Enable special wikilog feed parsing.
	 *
	 * This function changes the parser behavior in order to output
	 *
	 * The proper way to use this function is:
	 * @code
	 *   $saveFeedParse = WikilogParser::enableFeedParsing();
	 *   # ...code that uses $wgParser in order to parse articles...
	 *   WikilogParser::enableFeedParsing( $saveFeedParse );
	 * @endcode
	 *
	 * @note Using this function changes the behavior of Parser. When enabled,
	 *   parsed content should be cached under a different key.
	 */
	public static function enableFeedParsing( $enable = true ) {
		$prev = self::$feedParsing;
		self::$feedParsing = $enable;
		return $prev;
	}

	/**
	 * Enable expansion of local URLs.
	 *
	 * In order to output stand-alone content with all absolute links, it is
	 * necessary to expand local URLs. MediaWiki tries to do this in a few
	 * places by sniffing into the 'action' GET request parameter, but this
	 * fails in many ways. This function tries to remedy this.
	 *
	 * This function pre-expands all base URL fragments used by MediaWiki,
	 * and also enables URL expansion in the Wikilog::GetLocalURL hook.
	 * The original values of all URLs are saved when $enable = true, and
	 * restored back when $enabled = false.
	 *
	 * The proper way to use this function is:
	 * @code
	 *   $saveExpUrls = WikilogParser::expandLocalUrls();
	 *   # ...code that uses $wgParser in order to parse articles...
	 *   WikilogParser::expandLocalUrls( $saveExpUrls );
	 * @endcode
	 *
	 * @note Using this function changes the behavior of Parser. When enabled,
	 *   parsed content should be cached under a different key.
	 */
	public static function expandLocalUrls( $enable = true ) {
		global $wgScriptPath, $wgUploadPath, $wgStylePath, $wgMathPath, $wgLocalFileRepo;
		static $originalPaths = null;

		$prev = self::$expandingUrls;

		if ( $enable ) {
			if ( !self::$expandingUrls ) {
				self::$expandingUrls = true;

				# Save original values.
				$originalPaths = array( $wgScriptPath, $wgUploadPath,
					$wgStylePath, $wgMathPath, $wgLocalFileRepo['url'] );

				# Expand paths.
				$wgScriptPath = wfExpandUrl( $wgScriptPath );
				$wgUploadPath = wfExpandUrl( $wgUploadPath );
				$wgStylePath  = wfExpandUrl( $wgStylePath  );
				$wgMathPath   = wfExpandUrl( $wgMathPath   );
				$wgLocalFileRepo['url'] = wfExpandUrl( $wgLocalFileRepo['url'] );

				# Destroy existing RepoGroup, if any.
				RepoGroup::destroySingleton();
			}
		} else {
			if ( self::$expandingUrls ) {
				self::$expandingUrls = false;

				# Restore original values.
				list( $wgScriptPath, $wgUploadPath, $wgStylePath, $wgMathPath,
					$wgLocalFileRepo['url'] ) = $originalPaths;

				# Destroy existing RepoGroup, if any.
				RepoGroup::destroySingleton();
			}
		}

		return $prev;
	}


	###
	## Internal stuff.
	#

	/**
	 * Set the article summary, ignore if already set.
	 * @return True if set, false otherwise.
	 */
	private static function trySetSummary( &$parser, $text ) {
		if ( !$parser->mExtWikilog->mSummary ) {
			$popt = clone $parser->getOptions();
			$popt->enableLimitReport( false );
			$output = $parser->parse( $text, $parser->getTitle(), $popt, true, false );
			$parser->mExtWikilog->mSummary = $output->getText();
// 			wfDebug( "Wikilog summary set to:\n----\n" . $parser->mExtWikilog->mSummary . "\n----\n" );
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Adds an author to the current article. If too many authors, warns.
	 * @return False on overflow, true otherwise.
	 */
	private static function tryAddAuthor( &$parser, $name ) {
		global $wgWikilogMaxAuthors;

		if ( count( $parser->mExtWikilog->mAuthors ) >= $wgWikilogMaxAuthors ) {
			$warning = wfMsg( 'wikilog-error-msg', wfMsg( 'wikilog-too-many-authors' ) );
			$parser->mOutput->addWarning( $warning );
			return false;
		}

		$user = User::newFromName( $name );
		if ( $user ) {
			$parser->mExtWikilog->mAuthors[$user->getName()] = $user->getID();
		}
		else {
			$warning = wfMsg( 'wikilog-error-msg', wfMsg( 'wikilog-invalid-author', $name ) );
			$parser->mOutput->addWarning( $warning );
		}
		return true;
	}

	/**
	 * Adds a tag to the current article. If too many tags, warns.
	 * @return False on overflow, true otherwise.
	 */
	private static function tryAddTag( &$parser, $tag ) {
		global $wgWikilogMaxTags;

		static $tcre = false;
		if ( !$tcre ) { $tcre = '/[^' . Title::legalChars() . ']/'; }

		if ( count( $parser->mExtWikilog->mTags ) >= $wgWikilogMaxTags ) {
			$warning = wfMsg( 'wikilog-error-msg', wfMsg( 'wikilog-too-many-tags' ) );
			$parser->mOutput->addWarning( $warning );
			return false;
		}

		if ( !empty( $tag ) && !preg_match( $tcre, $tag ) ) {
			$parser->mExtWikilog->mTags[$tag] = 1;
		}
		else {
			$warning = wfMsg( 'wikilog-error-msg', wfMsg( 'wikilog-invalid-tag', $tag ) );
			$parser->mOutput->addWarning( $warning );
		}
		return true;
	}

	/**
	 * Check if the calling parser function is being executed in Wikilog
	 * context. Generates a parser warning if it isn't.
	 */
	private static function checkNamespace( &$parser ) {
		global $wgWikilogNamespaces;
		static $tested = false;

		if ( !$tested ) {
			$title = $parser->getTitle();
			if ( !in_array( $title->getNamespace(), $wgWikilogNamespaces ) ) {
				$warning = wfMsg( 'wikilog-error-msg', wfMsg( 'wikilog-out-of-context' ) );
				$parser->mOutput->addWarning( $warning );
			}
			$tested = true;
		}
	}

	/**
	 * Parses an image link.
	 * Wrapper around parseMediaLink() that only returns images. Parser
	 * warnings are generated if the file is not an image, or if it is
	 * invalid.
	 *
	 * @return File instance, or NULL.
	 */
	private static function parseImageLink( &$parser, $text ) {
		$obj = self::parseMediaLink( $parser, $text );
		if ( !$obj ) {
			$warning = wfMsg( 'wikilog-error-msg', wfMsg( 'wikilog-invalid-file', htmlspecialchars( $text ) ) );
			$parser->mOutput->addWarning( $warning );
			return null;
		}

		list( $t1, $t2, $file ) = $obj;
		if ( !$file ) {
			$warning = wfMsg( 'wikilog-error-msg', wfMsg( 'wikilog-file-not-found', htmlspecialchars( $t1 ) ) );
			$parser->mOutput->addWarning( $warning );
			return null;
		}

		$type = $file->getMediaType();
		if ( $type != MEDIATYPE_BITMAP && $type != MEDIATYPE_DRAWING ) {
			$warning = wfMsg( 'wikilog-error-msg', wfMsg( 'wikilog-not-an-image', $file->getName() ) );
			$parser->mOutput->addWarning( $warning );
			return null;
		}

		return $file;
	}

	/**
	 * Parses a media link.
	 * This is a very small subset of Parser::replaceInternalLinks() that
	 * parses a single image or media link, and returns the parsed text,
	 * as well as a File instance of the referenced media, if available.
	 *
	 * @return Three-element array containing the matched parts of the link,
	 *   and the file object, or NULL.
	 */
	private static function parseMediaLink( &$parser, $text ) {
		$tc = Title::legalChars();
		if ( !preg_match( "/\\[\\[([{$tc}]+)(?:\\|(.+?))?]]/", $text, $m ) )
			return null;

		$nt = Title::newFromText( $m[1] );
		if ( !$nt )
			return null;

		$ns = $nt->getNamespace();
		if ( $ns == NS_IMAGE || $ns == NS_MEDIA ) {
			$parser->mOutput->addLink( $nt );
			return @ array( $m[1], $m[2], wfFindFile( $nt ) );
		} else {
			return null;
		}
	}
}

/**
 * Wikilog parser output. This class is first attached to the Parser as
 * $parser->mExtWikilog, and then copied to the parser output
 * $popt->mExtWikilog in WikilogParser::AfterTidy().
 */
class WikilogParserOutput
{
	/* Item and Wikilog metadata */
	public $mSummary = false;
	public $mAuthors = array();
	public $mTags = array();

	/* Item metadata */
	public $mPublish = false;
	public $mPubDate = null;

	/* Wikilog settings */
	public $mIcon = null;
	public $mLogo = null;

	/* Acessor functions, lacking... */
	public function getAuthors() { return $this->mAuthors; }
	public function getTags() { return $this->mTags; }
}
