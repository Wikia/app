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
 * Utilitary functions used by the Wikilog extension.
 */
class WikilogUtils
{
	/**
	 * Retrieves an article parsed output either from parser cache or by
	 * parsing it again. If parsing again, stores it back into parser cache.
	 *
	 * @param $title Article title object.
	 * @param $feed Whether the result should be part of a feed.
	 * @return Two-element array containing the article and its parser output.
	 *
	 * @note Mw1.16+ provides Article::getParserOptions() and
	 *   Article::getParserOutput(), that could be used here in the future.
	 *   The problem is that getParserOutput() uses ParserCache exclusively,
	 *   which means that only ParserOptions control the key used to store
	 *   the output in the cache and there is no hook yet in
	 *   ParserCache::getKey() to set these extra bits (and the
	 *   'PageRenderingCache' hook is not useful here, it is in the wrong
	 *   place without access to the parser options). This is certainly
	 *   something that should be fixed in the future.  FIXME
	 *
	 * @note This function makes a clone of the parser if
	 *   $wgWikilogCloneParser is set, but cloning the parser is not
	 *   officially supported. The problem here is that we need a different
	 *   parser that we could mess up without interfering with normal page
	 *   rendering, and we can't create a new instance because of too many
	 *   broken extensions around. Check self::parserSanityCheck().
	 */
	public static function parsedArticle( Title $title, $feed = false ) {
		global $wgWikilogCloneParser;
		global $wgUser, $wgEnableParserCache;
		global $wgParser, $wgParserConf;

		static $parser = null;

		$article = new Article( $title );

		# First try the parser cache.
		$useParserCache = $wgEnableParserCache &&
			intval( $wgUser->getOption( 'stubthreshold' ) ) == 0 &&
			$article->exists();
		$parserCache = ParserCache::singleton();

		# Parser options.
		$parserOpt = ParserOptions::newFromUser( $wgUser );
		$parserOpt->setTidy( true );
		if ( $feed ) {
			$parserOpt->setEditSection( false );

			$parserOpt->addExtraKey( "WikilogFeed" );
		} else {
			$parserOpt->enableLimitReport();
		}

		if ( $useParserCache ) {
			# Look for the parsed article output in the parser cache.
			$parserOutput = $parserCache->get( $article, $parserOpt );

			# On success, return the object retrieved from the cache.
			if ( $parserOutput ) {
				return array( $article, $parserOutput );
			}
		}

		# Enable some feed-specific behavior.
		if ( $feed ) {
			$saveFeedParse = WikilogParser::enableFeedParsing();
			$saveExpUrls = WikilogParser::expandLocalUrls();
		}

		# Get a parser instance, if not already cached.
		if ( is_null( $parser ) ) {
			if ( !StubObject::isRealObject( $wgParser ) ) {
				$wgParser->_unstub();
			}
			if ( $wgWikilogCloneParser ) {
				$parser = clone $wgParser;
			} else {
				$class = $wgParserConf['class'];
				$parser = new $class( $wgParserConf );
			}
		}
		$parser->startExternalParse( $title, $parserOpt, Parser::OT_HTML );

		# Parse article.
		$arttext = $article->fetchContent();
		$parserOutput = $parser->parse( $arttext, $title, $parserOpt );

		# Save in parser cache.
		if ( $useParserCache && $parserOutput->getCacheTime() != -1 ) {
			$parserCache->save( $parserOutput, $article, $parserOpt );
		}

		# Restore default behavior.
		if ( $feed ) {
			WikilogParser::enableFeedParsing( $saveFeedParse );
			WikilogParser::expandLocalUrls( $saveExpUrls );
		}

		return array( $article, $parserOutput );
	}

	/**
	 * Check sanity of a second parser instance against the global one.
	 *
	 * @param $newparser New parser instance to be checked.
	 * @return Whether the second parser instance contains the same hooks as
	 *   the global one.
	 */
	private static function parserSanityCheck( $newparser ) {
		global $wgParser;

		$newparser->firstCallInit();

		$th_diff = array_diff_key( $wgParser->mTagHooks, $newparser->mTagHooks );
		$tt_diff = array_diff_key( $wgParser->mTransparentTagHooks, $newparser->mTransparentTagHooks );
		$fh_diff = array_diff_key( $wgParser->mFunctionHooks, $newparser->mFunctionHooks );

		if ( !empty( $th_diff ) || !empty( $tt_diff ) || !empty( $fh_diff ) ) {
			wfDebug( "*** Wikilog WARNING: Detected broken extensions installed. "
				  . "A second instance of the parser is not properly initialized. "
				  . "The following hooks are missing:\n" );
			if ( !empty( $th_diff ) ) {
				$hooks = implode( ', ', array_keys( $th_diff ) );
				wfDebug( "***    Tag hooks: $hooks.\n" );
			}
			if ( !empty( $tt_diff ) ) {
				$hooks = implode( ', ', array_keys( $tt_diff ) );
				wfDebug( "***    Transparent tag hooks: $hooks.\n" );
			}
			if ( !empty( $fh_diff ) ) {
				$hooks = implode( ', ', array_keys( $fh_diff ) );
				wfDebug( "***    Function hooks: $hooks.\n" );
			}
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Formats a list of authors.
	 * Given a list of authors, this function formats it in wiki syntax,
	 * with links to their user and user-talk pages, according to the
	 * 'wikilog-author-signature' system message.
	 *
	 * @param $list Array of authors.
	 * @return Wikitext-formatted textual list of authors.
	 */
	public static function authorList( $list ) {
		global $wgContLang;

		if ( is_string( $list ) ) {
			return self::authorSig( $list );
		}
		elseif ( is_array( $list ) ) {
			$authors = array_map( array( __CLASS__, 'authorSig' ), $list );
			return $wgContLang->listToText( $authors );
		}
		else {
			return '';
		}
	}

	/**
	 * Formats a single author signature.
	 * Uses the 'wikilog-author-signature' system message, in order to provide
	 * user and user-talk links.
	 *
	 * @param $author String, author name.
	 * @return Wikitext-formatted author signature.
	 */
	public static function authorSig( $author ) {
		static $authorSigCache = array();
		if ( !isset( $authorSigCache[$author] ) )
			$authorSigCache[$author] = wfMsgForContent( 'wikilog-author-signature', $author );
		return $authorSigCache[$author];
	}

	/**
	 * Formats a list of categories.
	 * Given a list of categories, this function formats it in wiki syntax,
	 * with links to either their page or to Special:Wikilog.
	 *
	 * @param $list Array of categories.
	 * @return Wikitext-formatted textual list of categories.
	 */
	public static function categoryList( $list ) {
		global $wgContLang;
		$special = $wgContLang->specialPage( 'Wikilog' );
		$categories = array();
		foreach ( $list as $cat ) {
			$title = Title::makeTitle( NS_CATEGORY, $cat );
			$categoryUrl = $title->getPrefixedText();
			$categoryTxt = $title->getText();
			$categories[] = "[[{$special}/{$categoryUrl}|{$categoryTxt}]]";
		}
		return $wgContLang->listToText( $categories );
	}

	/**
	 * Formats a list of tags.
	 * Given a list of tags, this function formats it in wiki syntax,
	 * with links to Special:Wikilog.
	 *
	 * @param $list Array of tags.
	 * @return Wikitext-formatted textual list of tags.
	 */
	public static function tagList( $list ) {
		global $wgContLang;
		$special = $wgContLang->specialPage( 'Wikilog' );
		$tags = array();
		foreach ( $list as $tag ) {
			$tags[] = "[[{$special}/t={$tag}|{$tag}]]";
		}
		return $wgContLang->listToText( $tags );
	}

	/**
	 * Split summary of a wikilog article from the contents.
	 * If summary is part of the parser output, use it; otherwise, try to
	 * extract it from the content text (section zero, before the first
	 * heading).
	 *
	 * @param $parserOutput ParserOutput object.
	 * @return Two-element array with summary and content. Summary may be
	 *   NULL if nonexistent.
	 */
	public static function splitSummaryContent( $parserOutput ) {
		global $wgUseTidy;

		$content = Sanitizer::removeHTMLcomments( $parserOutput->getText() );

		if ( isset( $parserOutput->mExtWikilog ) && $parserOutput->mExtWikilog->mSummary ) {
			# Parser output contains wikilog output and summary, use it.
			$summary = Sanitizer::removeHTMLcomments( $parserOutput->mExtWikilog->mSummary );
		} else {
			# Try to extract summary from the content text.
			$blocks = preg_split( '/<(h[1-6]).*?>.*?<\\/\\1>/i', $content, 2 );
			if ( count( $blocks ) > 1 ) {
				# Long article with multiple sections, use only the first one.
				$summary = $blocks[0];
				# It is possible for the regex to split on a heading that is
				# not a child of the root element (e.g. <div><h2>...</h2>
				# </div> leaving an open <div> tag). In order to handle such
				# cases, we pass the summary through tidy if it is available.
				if ( $wgUseTidy ) {
					$summary = MWTidy::tidy( $summary );
				}
			} else {
				# Short article with a single section, use no summary and
				# leave to the caller to decide what to do.
				$summary = null;
			}
		}

		return array( $summary, $content );
	}

	/**
	 * Formats a comments page link.
	 *
	 * @param $item WikilogItem object.
	 * @return Wikitext-formatted comments link.
	 */
	public static function getCommentsWikiText( WikilogItem &$item ) {
		$commentsNum = $item->getNumComments();
		$commentsMsg = ( $commentsNum ? 'wikilog-has-comments' : 'wikilog-no-comments' );
		$commentsUrl = $item->mTitle->getTalkPage()->getPrefixedURL();
		$commentsTxt = wfMsgExt( $commentsMsg, array( 'parsemag', 'content' ), $commentsNum );
		return "[[{$commentsUrl}|{$commentsTxt}]]";
	}

	/**
	 * Causes an update to the given Wikilog main page.
	 */
	public static function updateWikilog( $title ) {
		if ( $title->exists() ) {
			$title->invalidateCache();
			$title->purgeSquid();

			$dbw = wfGetDB( DB_MASTER );
			$dbw->update(
				'wikilog_wikilogs',
				array( 'wlw_updated' => $dbw->timestamp() ),
				array( 'wlw_page' => $title->getArticleId(), ),
				__METHOD__
			);
		}
	}

	/**
	 * Given a MagicWord, returns any array element which key matches the
	 * magic word. Always case-sensitive.
	 */
	public static function arrayMagicKeyGet( &$array, MagicWord $mw ) {
		foreach ( $mw->getSynonyms() as $key ) {
			if ( array_key_exists( $key, $array ) )
				return $array[$key];
		}
		return null;
	}

	/**
	 * Builds an HTML form in a table.
	 */
	public static function buildForm( $fields ) {
		$rows = array();
		foreach ( $fields as $field ) {
			if ( is_array( $field ) ) {
				$row = Xml::tags( 'td', array( 'class' => 'mw-label' ), $field[0] ) .
					Xml::tags( 'td', array( 'class' => 'mw-input' ), $field[1] );
			} else {
				$row = Xml::tags( 'td', array( 'class' => 'mw-input',
					'colspan' => 2 ), $field );
			}
			$rows[] = Xml::tags( 'tr', array(), $row );
		}
		$form = Xml::tags( 'table', array( 'width' => '100%' ),
			implode( "\n", $rows ) );
		return $form;
	}

	/**
	 * Wraps a div, with a class, around some HTML fragment.
	 * Similar to Xml::wrapClass(..., 'div') or Xml::tags('div',...).
	 * This is something that should be in includes/Xml.php, doing it here
	 * to avoid Mw version dependency.
	 */
	public static function wrapDiv( $class, $text ) {
		return Xml::tags( 'div', array( 'class' => $class ), $text );
	}

	/**
	 * Returns the date and user parameters suitable for substitution in
	 * {{wl-publish:...}} parser function.
	 */
	public static function getPublishParameters() {
		global $wgUser, $wgLocaltimezone;

		$user = $wgUser->getName();
		$popt = ParserOptions::newFromUser( $wgUser );

		$unixts = wfTimestamp( TS_UNIX, $popt->getTimestamp() );
		if ( isset( $wgLocaltimezone ) ) {
			$oldtz = getenv( 'TZ' );
			putenv( "TZ={$wgLocaltimezone}" );
			$date = date( 'Y-m-d H:i:s O', $unixts );
			putenv( "TZ={$oldtz}" );
		} else {
			$date = date( 'Y-m-d H:i:s O', $unixts );
		}

		return array( 'date' => $date, 'user' => $user );
	}

	/**
	 * Return the given timestamp as a tuple with date, time and timezone
	 * in the local timezone (if defined). This is meant to be compatible
	 * with signatures produced by Parser::pstPass2(). It was based on this
	 * same function.
	 *
	 * @param $timestamp Timestamp.
	 * @return Array(3) containing date, time and timezone.
	 */
	public static function getLocalDateTime( $timestamp ) {
		global $wgContLang, $wgLocaltimezone;

		$ts = wfTimestamp( TS_UNIX, $timestamp );

		if ( isset( $wgLocaltimezone ) ) {
			$oldtz = date_default_timezone_get();
			date_default_timezone_set( $wgLocaltimezone );
		}

		$ts = date( 'YmdHis', $ts );
		$tz = date( 'T', $ts );

		if ( isset( $oldtz ) ) {
			date_default_timezone_set( $oldtz );
		}

		$date = $wgContLang->date( $ts, false, false );
		$time = $wgContLang->time( $ts, false, false );

		# Check for translation of timezones.
		$key = 'timezone-' . strtolower( trim( $tz ) );
		$value = wfMsgForContent( $key );
		if ( !wfEmptyMsg( $key, $value ) ) $tz = $value;

		return array( $date, $time, $tz );
	}

}

/**
 * Generates a more user-friendly navigation bar for use in article and
 * comment pagers (shared between WikilogItemPager and WikilogCommentPager).
 */
class WikilogNavbar
{
	static $pagingLabels = array(
		'prev'  => '‹ $1',
		'next'  => '$1 ›',
		'first' => '« $1',
		'last'  => '$1 »'
	);
	static $linkTextMsgs = array(
		# pages style:  « first  ‹ previous 20  ...  next 20 ›  last »
		'pages' => array(
			'prev' => 'prevn',
			'next' => 'nextn',
			'first' => 'wikilog-pager-first',
			'last' => 'wikilog-pager-last'
		),
		# pages-sim style:  « first  ‹ previous  ...  next ›  last »
		'pages-sim' => array(
			'prev' => 'wikilog-pager-prev',
			'next' => 'wikilog-pager-next',
			'first' => 'wikilog-pager-first',
			'last' => 'wikilog-pager-last'
		),
		# chrono-fwd style:  « oldest  ‹ older 20  ...  newer 20 ›  newest »
		'chrono-fwd' => array(
			'prev' => 'pager-older-n',
			'next' => 'pager-newer-n',
			'first' => 'wikilog-pager-oldest',
			'last' => 'wikilog-pager-newest'
		),
		# chrono-rev style:  « newest  ‹ newer 20  ...  older 20 ›  oldest »
		'chrono-rev' => array(
			'prev' => 'pager-newer-n',
			'next' => 'pager-older-n',
			'first' => 'wikilog-pager-newest',
			'last' => 'wikilog-pager-oldest'
		),
	);

	protected $mPager, $mType;

	/**
	 * Constructor.
	 * @param $pager IndexPager  Pager object.
	 * @param $type string  Type of navigation bar to generate:
	 *   * 'pages': For normal pages, with 'first', 'last', 'previous', 'next';
	 *   * 'chrono-fwd': For chronological events, in forward order (later
	 *        pages contain newer events);
	 *   * 'chrono-rev': For chronological events, in reverse order (later
	 *        pages contain older events).
	 */
	function __construct( IndexPager $pager, $type = 'pages' ) {
		$this->mPager = $pager;
		$this->mType = $type;
	}

	/**
	 * Format and return the navigation bar.
	 * @param $limit integer  Number of itens being displayed.
	 * @return string  HTML-formatted navigation bar.
	 */
	public function getNavigationBar( $limit ) {
		global $wgLang;

		$limit = $wgLang->formatNum( $limit );
		$opts = array( 'parsemag', 'escapenoentities' );
		$linkTexts = $disabledTexts = array();
		foreach ( self::$linkTextMsgs[$this->mType] as $type => $msg ) {
			$label = wfMsgExt( $msg, $opts, $limit );
			$linkTexts[$type] = wfMsgReplaceArgs( self::$pagingLabels[$type], array( $label ) );
			$disabledTexts[$type] = Xml::wrapClass( $linkTexts[$type], 'disabled' );
		}

		$pagingLinks = $this->mPager->getPagingLinks( $linkTexts, $disabledTexts );
// 		$limitLinks = $this->mPager->getLimitLinks(); // XXX: Not used yet.
		$ellipsis = wfMsg( 'ellipsis' );
		$html = "{$pagingLinks['first']} {$pagingLinks['prev']} {$ellipsis} {$pagingLinks['next']} {$pagingLinks['last']}";
		$html = WikilogUtils::wrapDiv( 'wl-pagination', $html );

		$dir = $wgLang->getDir();

		return Xml::tags( 'div',
			array(
				'class' => 'wl-navbar',
				'dir' => $dir
			),
			$html
		);
	}

}
