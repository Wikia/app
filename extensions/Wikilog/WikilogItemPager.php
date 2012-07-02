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
 * Common wikilog pager interface.
 */
interface WikilogItemPager
	extends Pager
{
	function including( $x = null );
}

/**
 * Summary pager.
 *
 * Lists wikilog articles from one or more wikilogs (selected by the provided
 * query parameters) in reverse chronological order, displaying article
 * sumaries, authors, date and number of comments. This pager also provides
 * a "read more" link when appropriate. If there are more articles than
 * some threshold, the user may navigate through "newer posts"/"older posts"
 * links.
 *
 * Formatting is controlled by a number of system messages.
 */
class WikilogSummaryPager
	extends ReverseChronologicalPager
	implements WikilogItemPager
{
	# Override default limits.
	public $mLimitsShown = array( 5, 10, 20, 50 );

	# Local variables.
	protected $mQuery = null;			///< Wikilog item query data
	protected $mIncluding = false;		///< If pager is being included
	protected $mShowEditLink = false;	///< If edit links are shown.

	/**
	 * Constructor.
	 * @param $query Query object, containing the parameters that will select
	 *   which articles will be shown.
	 * @param $limit Override how many articles will be listed.
	 */
	function __construct( WikilogItemQuery $query, $limit = false, $including = false ) {
		# WikilogItemQuery object drives our queries.
		$this->mQuery = $query;
		$this->mIncluding = $including;

		# Parent constructor.
		parent::__construct();

		# Fix our limits, Pager's defaults are too high.
		global $wgUser, $wgWikilogNumArticles;
		$this->mDefaultLimit = $wgWikilogNumArticles;

		if ( $limit ) {
			$this->mLimit = $limit;
		} else {
			list( $this->mLimit, /* $offset */ ) =
				$this->mRequest->getLimitOffset( $wgWikilogNumArticles, '' );
		}

		# This is too expensive, limit listing.
		global $wgWikilogExpensiveLimit;
		if ( $this->mLimit > $wgWikilogExpensiveLimit )
			$this->mLimit = $wgWikilogExpensiveLimit;

		# Check parser state, setup edit links.
		global $wgOut, $wgParser, $wgTitle;
		if ( $this->mIncluding ) {
			$popt = $wgParser->getOptions();
		} else {
			$popt = $wgOut->parserOptions();

			# We will need a clean parser if not including.
			$wgParser->startExternalParse( $wgTitle, $popt, Parser::OT_HTML );
		}
		$this->mShowEditLink = $popt->getEditSection();
	}

	/**
	 * Property accessor/mutators.
	 */
	function including( $x = null ) { return wfSetVar( $this->mIncluding, $x ); }

	function getQueryInfo() {
		return $this->mQuery->getQueryInfo( $this->mDb );
	}

	function getDefaultQuery() {
		return parent::getDefaultQuery() + $this->mQuery->getDefaultQuery();
	}

	function getIndexField() {
		return 'wlp_pubdate';
	}

	function getStartBody() {
		return "<div class=\"wl-roll visualClear\">\n";
	}

	function getEndBody() {
		return "</div>\n";
	}

	function getEmptyBody() {
		return '<div class="wl-empty">' . wfMsgExt( 'wikilog-pager-empty', array( 'parsemag' ) ) . "</div>";
	}

	function getNavigationBar() {
		if ( !$this->isNavigationBarShown() ) return '';
		if ( !isset( $this->mNavigationBar ) ) {
			$navbar = new WikilogNavbar( $this, 'chrono-rev' );
			$this->mNavigationBar = $navbar->getNavigationBar( $this->mLimit );
		}
		return $this->mNavigationBar;
	}

	function formatRow( $row ) {
		global $wgWikilogExtSummaries;
		$skin = $this->getSkin();
		$header = $footer = '';

		# Retrieve article parser output and other data.
		$item = WikilogItem::newFromRow( $row );
		list( $article, $parserOutput ) = WikilogUtils::parsedArticle( $item->mTitle );
		list( $summary, $content ) = WikilogUtils::splitSummaryContent( $parserOutput );

		# Retrieve the common header and footer parameters.
		$params = $item->getMsgParams( $wgWikilogExtSummaries, $parserOutput );

		# Article title heading, with direct link article page and optional
		# edit link (if user can edit the article).
		$titleText = Sanitizer::escapeHtmlAllowEntities( $item->mName );
		if ( !$item->getIsPublished() )
			$titleText .= wfMsgForContent( 'wikilog-draft-title-mark' );
		$heading = $skin->link( $item->mTitle, $titleText, array(), array(),
			array( 'known', 'noclasses' )
		);
		if ( $this->mShowEditLink && $item->mTitle->quickUserCan( 'edit' ) ) {
			$heading = $this->doEditLink( $item->mTitle, $item->mName ) . $heading;
		}
		$heading = Xml::tags( 'h2', null, $heading );

		# Sumary entry header.
		$key = $this->mQuery->isSingleWikilog()
			? 'wikilog-summary-header-single'
			: 'wikilog-summary-header';
		$msg = wfMsgExt( $key, array( 'content', 'parsemag' ), $params );
		if ( !empty( $msg ) ) {
			$header = WikilogUtils::wrapDiv( 'wl-summary-header', $this->parse( $msg ) );
		}

		# Summary entry text.
		if ( $summary ) {
			$more = $this->parse( wfMsgForContentNoTrans( 'wikilog-summary-more', $params ) );
			$summary = WikilogUtils::wrapDiv( 'wl-summary', $summary . $more );
		} else {
			$summary = WikilogUtils::wrapDiv( 'wl-summary', $content );
		}

		# Summary entry footer.
		$key = $this->mQuery->isSingleWikilog()
			? 'wikilog-summary-footer-single'
			: 'wikilog-summary-footer';
		$msg = wfMsgExt( $key, array( 'content', 'parsemag' ), $params );
		if ( !empty( $msg ) ) {
			$footer = WikilogUtils::wrapDiv( 'wl-summary-footer', $this->parse( $msg ) );
		}

		# Assembly the entry div.
		$divclass = array( 'wl-entry', 'visualClear' );
		if ( !$item->getIsPublished() )
			$divclass[] = 'wl-draft';
		$entry = WikilogUtils::wrapDiv(
			implode( ' ', $divclass ),
			$heading . $header . $summary . $footer
		);
		return $entry;
	}

	/**
	 * Parse a given wikitext and returns the resulting HTML fragment.
	 * Uses either $wgParser->recursiveTagParse() or $wgParser->parse()
	 * depending whether the content is being included in another
	 * article. Note that the parser state can't be reset, or it will
	 * break the parser output.
	 * @param $text Wikitext that should be parsed.
	 * @return Resulting HTML fragment.
	 */
	protected function parse( $text ) {
		global $wgTitle, $wgParser, $wgOut;
		if ( $this->mIncluding ) {
			return $wgParser->recursiveTagParse( $text );
		} else {
			$popts = $wgOut->parserOptions();
			$output = $wgParser->parse( $text, $wgTitle, $popts, true, false );
			return $output->getText();
		}
	}

	/**
	 * Returns a wikilog article edit link, much similar to a section edit
	 * link in normal articles.
	 * @param $title Title  The title of the target article.
	 * @param $tooltip string  The tooltip to be included in the link, wrapped
	 *   in the 'wikilog-edit-hint' message.
	 * @return string  HTML fragment.
	 */
	private function doEditLink( $title, $tooltip = null ) {
		$skin = $this->getSkin();
		$attribs = array();
		if ( !is_null( $tooltip ) ) {
			$attribs['title'] = wfMsg( 'wikilog-edit-hint', $tooltip );
		}
		$link = $skin->link( $title, wfMsg( 'wikilog-edit-lc' ),
			$attribs,
			array( 'action' => 'edit' ),
			array( 'noclasses', 'known' )
		);

		$result = wfMsgHtml ( 'editsection-brackets', $link );
		$result = "<span class=\"editsection\">$result</span>";

		wfRunHooks( 'DoEditSectionLink', array( $skin, $title, "", $tooltip, &$result ) );
		return $result;
	}
}

/**
 * Template pager.
 *
 * Lists wikilog articles like #WikilogSummaryPager, but using a given
 * template to format the summaries. The template receives the article
 * data through its parameters:
 *
 * - 'class': div element class attribute
 * - 'wikilogTitle': title (as text) of the wikilog page
 * - 'wikilogPage': title (prefixed, for link) of the wikilog page
 * - 'title': title (as text) of the article page
 * - 'page': title (prefixed, for link) of the article page
 * - 'authors': authors
 * - 'tags': tags
 * - 'published': empty (draft) or "*" (published)
 * - 'date': article publication date
 * - 'time': article publication time
 * - 'tz': timezone information
 * - 'updatedDate': article last update date
 * - 'updatedTime': article last update time
 * - 'summary': article summary
 * - 'hasMore': empty (summary only) or "*" (has more than summary)
 * - 'comments': comments page link
 */
class WikilogTemplatePager
	extends WikilogSummaryPager
{
	protected $mTemplate, $mTemplateTitle;

	/**
	 * Constructor.
	 */
	function __construct( WikilogItemQuery $query, Title $template, $limit = false, $including = false ) {
		global $wgParser;

		# Parent constructor.
		parent::__construct( $query, $limit, $including );

		# Load template
		list( $this->mTemplate, $this->mTemplateTitle ) =
			$wgParser->getTemplateDom( $template );
		if ( $this->mTemplate === false )
			$this->mTemplate = "[[:$template]]";
	}

	function getDefaultQuery() {
		$query = parent::getDefaultQuery();
		$query['template'] = $this->mTemplateTitle->getPartialURL();
		return $query;
	}

	function getStartBody() {
		return "<div class=\"wl-tpl-roll\">\n";
	}

	function getEndBody() {
		return "</div>\n";
	}

	function formatRow( $row ) {
		global $wgParser;

		# Retrieve article parser output and other data.
		$item = WikilogItem::newFromRow( $row );
		list( $article, $parserOutput ) = WikilogUtils::parsedArticle( $item->mTitle );
		list( $summary, $content ) = WikilogUtils::splitSummaryContent( $parserOutput );
		if ( empty( $summary ) ) {
			$summary = $content;
			$hasMore = false;
		} else {
			$hasMore = true;
		}

		# Some general data.
		$authors = WikilogUtils::authorList( array_keys( $item->mAuthors ) );
		$tags = implode( wfMsgForContent( 'comma-separator' ), array_keys( $item->mTags ) );
		$comments = WikilogUtils::getCommentsWikiText( $item );
		$divclass = 'wl-entry' . ( $item->getIsPublished() ? '' : ' wl-draft' );

		$itemPubdate = $item->getPublishDate();
		list( $publishedDate, $publishedTime, $publishedTz ) =
				WikilogUtils::getLocalDateTime( $itemPubdate );

		$itemUpdated = $item->getUpdatedDate();
		list( $updatedDate, $updatedTime, ) =
				WikilogUtils::getLocalDateTime( $itemUpdated );

		# Template parameters.
		$vars = array(
			'class'         => $divclass,
			'wikilogTitle'  => $item->mParentName,
			'wikilogPage'   => $item->mParentTitle->getPrefixedText(),
			'title'         => $item->mName,
			'page'          => $item->mTitle->getPrefixedText(),
			'authors'       => $authors,
			'tags'          => $tags,
			'published'     => $item->getIsPublished() ? '*' : '',
			'date'          => $publishedDate,
			'time'          => $publishedTime,
			'tz'            => $publishedTz,
			'updatedDate'   => $updatedDate,
			'updatedTime'   => $updatedTime,
			'summary'       => $wgParser->insertStripItem( $summary ),
			'hasMore'       => $hasMore ? '*' : '',
			'comments'      => $comments
		);

		$frame = $wgParser->getPreprocessor()->newCustomFrame( $vars );
		$text = $frame->expand( $this->mTemplate );

		return $this->parse( $text );
	}
}

/**
 * Archives pager.
 *
 * Lists wikilog articles in a table, with date, authors, wikilog and
 * title, without summaries, for easy navigation through large amounts of
 * articles.
 */
class WikilogArchivesPager
	extends TablePager
	implements WikilogItemPager
{
	# Local variables.
	protected $mQuery = null;			///< Wikilog item query data
	protected $mIncluding = false;		///< If pager is being included

	/**
	 * Constructor.
	 */
	function __construct( WikilogItemQuery $query, $including = false ) {
		# WikilogItemQuery object drives our queries.
		$this->mQuery = $query;
		$this->mIncluding = $including;

		# Parent constructor.
		parent::__construct();
	}

	/**
	 * Property accessor/mutators.
	 */
	function including( $x = null ) { return wfSetVar( $this->mIncluding, $x ); }

	function getQueryInfo() {
		return $this->mQuery->getQueryInfo( $this->mDb );
	}

	function getDefaultQuery() {
		$query = parent::getDefaultQuery() + $this->mQuery->getDefaultQuery();
		$query['view'] = 'archives';
		return $query;
	}

	function getTableClass() {
		return 'wl-archives TablePager';
	}

	function isFieldSortable( $field ) {
		static $sortableFields = array(
			'wlp_pubdate',
			'wlp_updated',
			'wlw_title',
			'wlp_title',
		);
		return in_array( $field, $sortableFields );
	}

	function getNavigationBar() {
		if ( !$this->isNavigationBarShown() ) return '';
		if ( !isset( $this->mNavigationBar ) ) {
			$navbar = new WikilogNavbar( $this, 'pages' );
			$this->mNavigationBar = $navbar->getNavigationBar( $this->mLimit );
		}
		return $this->mNavigationBar;
	}

	function formatRow( $row ) {
		$attribs = array();
		$columns = array();
		$this->mCurrentRow = $row;
		$this->mCurrentItem = WikilogItem::newFromRow( $row );
		if ( !$this->mCurrentItem->getIsPublished() ) {
			$attribs['class'] = 'wl-draft';
		}
		foreach ( $this->getFieldNames() as $field => $name ) {
			$value = isset( $row->$field ) ? $row->$field : null;
			$formatted = strval( $this->formatValue( $field, $value ) );
			if ( $formatted == '' ) {
				$formatted = WL_NBSP;
			}
			$class = 'TablePager_col_' . htmlspecialchars( $field );
			$columns[] = "<td class=\"$class\">$formatted</td>";
		}
		return Xml::tags( 'tr', $attribs, implode( "\n", $columns ) ) . "\n";
	}

	function formatValue( $name, $value ) {
		global $wgContLang;

		switch ( $name ) {
			case 'wlp_pubdate':
				$s = $wgContLang->timeanddate( $value, true );
				if ( !$this->mCurrentRow->wlp_publish ) {
					$s = Xml::wrapClass( $s, 'wl-draft-inline' );
				}
				return $s;

			case 'wlp_updated':
				return $value;

			case 'wlp_authors':
				return $this->authorList( $this->mCurrentItem->mAuthors );

			case 'wlw_title':
				$page = $this->mCurrentItem->mParentTitle;
				$text = Sanitizer::escapeHtmlAllowEntities( $this->mCurrentItem->mParentName );
				return $this->getSkin()->link( $page, $text, array(), array(),
					array( 'known', 'noclasses' ) );

			case 'wlp_title':
				$page = $this->mCurrentItem->mTitle;
				$text = Sanitizer::escapeHtmlAllowEntities( $this->mCurrentItem->mName );
				$s = $this->getSkin()->link( $page, $text, array(), array(),
					array( 'known', 'noclasses' ) );
				if ( !$this->mCurrentRow->wlp_publish ) {
					$draft = wfMsg( 'wikilog-draft-title-mark' );
					$s = Xml::wrapClass( "$s $draft", 'wl-draft-inline' );
				}
				return $s;

			case 'wlp_num_comments':
				$page = $this->mCurrentItem->mTitle->getTalkPage();
				$text = $this->mCurrentItem->getNumComments();
				return $this->getSkin()->link( $page, $text, array(), array(),
					array( 'known', 'noclasses' ) );

			case '_wl_actions':
				if ( $this->mCurrentItem->mTitle->quickUserCan( 'edit' ) ) {
					return $this->doEditLink( $this->mCurrentItem->mTitle, $this->mCurrentItem->mName );
				} else {
					return '';
				}

			default:
				return htmlentities( $value );
		}
	}

	function getDefaultSort() {
		return 'wlp_pubdate';
	}

	function getFieldNames() {
		global $wgWikilogEnableComments;

		$fields = array();

		$fields['wlp_pubdate']			= wfMsgHtml( 'wikilog-published' );
 		// $fields['wlp_updated']			= wfMsgHtml( 'wikilog-updated' );
		$fields['wlp_authors']			= wfMsgHtml( 'wikilog-authors' );

		if ( !$this->mQuery->isSingleWikilog() )
			$fields['wlw_title']		= wfMsgHtml( 'wikilog-wikilog' );

		$fields['wlp_title']			= wfMsgHtml( 'wikilog-title' );

		if ( $wgWikilogEnableComments )
			$fields['wlp_num_comments']	= wfMsgHtml( 'wikilog-comments' );

		$fields['_wl_actions']			= wfMsgHtml( 'wikilog-actions' );
		return $fields;
	}

	/**
	 * Formats the given list of authors into a textual comma-separated list.
	 * @param $list Array with wikilog article author information.
	 * @return Resulting HTML fragment.
	 */
	private function authorList( $list ) {
		if ( is_string( $list ) ) {
			return $this->authorLink( $list );
		}
		elseif ( is_array( $list ) ) {
			$list = array_keys( $list );
			return implode( ', ', array_map( array( &$this, 'authorLink' ), $list ) );
		}
		else {
			return '';
		}
	}

	/**
	 * Formats an author user page link.
	 * @param $name Username of the author.
	 * @return Resulting HTML fragment.
	 */
	private function authorLink( $name ) {
		$skin = $this->getSkin();
		$title = Title::makeTitle( NS_USER, $name );
		return $skin->link( $title, $name );
	}

	/**
	 * Returns a wikilog article edit link, much similar to a section edit
	 * link in normal articles.
	 * @param $title Title  The title of the target article.
	 * @param $tooltip string  The tooltip to be included in the link, wrapped
	 *   in the 'wikilog-edit-hint' message.
	 * @return string  HTML fragment.
	 */
	private function doEditLink( $title, $tooltip = null ) {
		$skin = $this->getSkin();
		$attribs = array();
		if ( !is_null( $tooltip ) ) {
			$attribs['title'] = wfMsg( 'wikilog-edit-hint', $tooltip );
		}
		$link = $skin->link( $title, wfMsg( 'wikilog-edit-lc' ),
			$attribs,
			array( 'action' => 'edit' ),
			array( 'noclasses', 'known' )
		);

		$result = wfMsgHtml ( 'editsection-brackets', $link );
		return $result;
	}
}
