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
 * Special:Wikilog special page.
 * The primary function of this special page is to list all wikilog articles
 * (from all wikilogs) in reverse chronological order. The special page
 * provides many different ways to query articles by wikilog, date, tags, etc.
 * The special page also provides syndication feeds and can be included from
 * wiki articles.
 */
class SpecialWikilog
	extends IncludableSpecialPage
{
	/** Alternate views. */
	protected static $views = array( 'summary', 'archives' );

	/** Statuses. */
	protected static $statuses = array( 'all', 'published', 'drafts' );

	/**
	 * Constructor.
	 */
	function __construct( ) {
		parent::__construct( 'Wikilog' );
	}

	/**
	 * Execute the special page.
	 * Called from MediaWiki.
	 */
	public function execute( $parameters ) {
		global $wgRequest;

		$feedFormat = $wgRequest->getVal( 'feed' );

		if ( $feedFormat ) {
			$opts = $this->feedSetup();
			return $this->feedOutput( $feedFormat, $opts );
		} else {
			$opts = $this->webSetup( $parameters );
			return $this->webOutput( $opts );
		}
	}

	/**
	 * Returns default options.
	 */
	public function getDefaultOptions() {
		global $wgWikilogNumArticles;

		$opts = new FormOptions();
		$opts->add( 'view',     'summary' );
		$opts->add( 'show',     'published' );
		$opts->add( 'wikilog',  '' );
		$opts->add( 'category', '' );
		$opts->add( 'author',   '' );
		$opts->add( 'tag',      '' );
		$opts->add( 'year',     '', FormOptions::INTNULL );
		$opts->add( 'month',    '', FormOptions::INTNULL );
		$opts->add( 'day',      '', FormOptions::INTNULL );
		$opts->add( 'limit',    $wgWikilogNumArticles );
		$opts->add( 'template', '' );
		return $opts;
	}

	/**
	 * Prepare special page parameters for a web request.
	 */
	public function webSetup( $parameters ) {
		global $wgRequest, $wgWikilogExpensiveLimit;

		$opts = $this->getDefaultOptions();
		$opts->fetchValuesFromRequest( $wgRequest );

		# Collect inline parameters, they have precedence over query params.
		$this->parseInlineParams( $parameters, $opts );

		$opts->validateIntBounds( 'limit', 0, $wgWikilogExpensiveLimit );
		return $opts;
	}

	/**
	 * Prepare special page parameters for a feed request.
	 * Since feeds must be cached for performance purposes, it is not allowed
	 * to make arbitrary queries. Only published status and limit parameters
	 * are recognized. Other parameters are ignored.
	 */
	public function feedSetup() {
		global $wgRequest, $wgFeedLimit;

		$opts = $this->getDefaultOptions();
		$opts->fetchValuesFromRequest( $wgRequest, array( 'wikilog', 'show', 'limit' ) );
		$opts->validateIntBounds( 'limit', 0, $wgFeedLimit );
		return $opts;
	}

	/**
	 * Format the HTML output of the special page.
	 * @param $opts Form options, such as wikilog name, category, date, etc.
	 */
	public function webOutput( FormOptions $opts ) {
		global $wgRequest, $wgOut, $wgMimeType, $wgTitle, $wgParser;

		# Set page title, html title, nofollow, noindex, etc...
		$this->setHeaders();
		$this->outputHeader();

		# Build query object.
		$query = self::getQuery( $opts );

		# Prepare the parser.
		# This must be called here if not including, before the pager
		# object is created. WikilogTemplatePager fails otherwise.
		if ( !$this->including() ) {
			$popts = $wgOut->parserOptions();
			$wgParser->startExternalParse( $wgTitle, $popts, Parser::OT_HTML );
		}

		# Create the pager object that will create the list of articles.
		if ( $opts['view'] == 'archives' ) {
			$pager = new WikilogArchivesPager( $query, $this->including() );
		} elseif ( $opts['template'] ) {
			$templ = Title::makeTitle( NS_TEMPLATE, $opts['template'] );
			$pager = new WikilogTemplatePager( $query, $templ, $opts['limit'], $this->including() );
		} else {
			$pager = new WikilogSummaryPager( $query, $opts['limit'], $this->including() );
		}

		# Handle special page inclusion.
		if ( $this->including() ) {
			# Get pager body.
			$body = $pager->getBody();
		}
		else {
			# If a wikilog is selected, set the title.
			$title = $query->getWikilogTitle();
			if ( !is_null( $title ) ) {
				# Retrieve wikilog front page
				$article = new Article( $title );
				$content = $article->getContent();
				$wgOut->setPageTitle( $title->getPrefixedText() );
				$wgOut->addWikiTextTitle( $content, $title );
			}

			# Display query options.
			$body = $this->getHeader( $opts );

			# Get pager body.
			$body .= $pager->getBody();

			# Add navigation bars.
			$body .= $pager->getNavigationBar();
		}

		# Output.
		$body = Xml::wrapClass( $body, 'wl-wrapper', 'div' );
		$wgOut->addHTML( $body );

		# Get query parameter array, for the following links.
		$qarr = $query->getDefaultQuery();

		# Add feed links.
		$wgOut->setSyndicated();
		$altquery = wfArrayToCGI( array_intersect_key( $qarr, WikilogItemFeed::$paramWhitelist ) );
		if ( $altquery ) {
			$wgOut->setFeedAppendQuery( $altquery );
		}

		# Add links for alternate views.
		foreach ( self::$views as $alt ) {
			if ( $alt != $opts['view'] ) {
				$altquery = wfArrayToCGI( array( 'view' => $alt ), $qarr );
				$wgOut->addLink( array(
					'rel' => 'alternate',
					'href' => $wgTitle->getLocalURL( $altquery ),
					'type' => $wgMimeType,
					'title' => wfMsgExt( "wikilog-view-{$alt}",
						array( 'content', 'parsemag' ) )
				) );
			}
		}
	}

	/**
	 * Format the syndication feed output of the special page.
	 * @param $format Feed format ('atom' or 'rss').
	 * @param $opts Form options, such as wikilog name, category, date, etc.
	 */
	public function feedOutput( $format, FormOptions $opts ) {
		global $wgTitle;

		$feed = new WikilogItemFeed( $wgTitle, $format, self::getQuery( $opts ),
			$opts['limit'] );
		return $feed->execute();
	}

	/**
	 * Returns the name used as page title in the special page itself,
	 * and also the name that will be listed in Special:Specialpages.
	 */
	public function getDescription() {
		return wfMsg( 'wikilog-specialwikilog-title' );
	}

	/**
	 * Parse inline parameters passed after the special page name.
	 * Example: Special:Wikilog/Category:catname/tag=tagname/5
	 * @param $parameters Inline parameters after the special page name.
	 * @param $opts Form options.
	 */
	public function parseInlineParams( $parameters, FormOptions $opts ) {
		global $wgWikilogNamespaces;

		if ( empty( $parameters ) ) return;

		/* ';' supported for backwards compatibility */
		foreach ( preg_split( '|[/;]|', $parameters ) as $par ) {
			if ( is_numeric( $par ) ) {
				$opts['limit'] = intval( $par );
			} elseif ( in_array( $par, self::$statuses ) ) {
				$opts['show'] = $par;
			} elseif ( in_array( $par, self::$views ) ) {
				$opts['view'] = $par;
			} elseif ( preg_match( '/^t(?:ag)?=(.+)$/', $par, $m ) ) {
				$opts['tag'] = $m[1];
			} elseif ( preg_match( '/^y(?:ear)?=(.+)$/', $par, $m ) ) {
				$opts['year'] = intval( $m[1] );
			} elseif ( preg_match( '/^m(?:onth)?=(.+)$/', $par, $m ) ) {
				$opts['month'] = intval( $m[1] );
			} elseif ( preg_match( '/^d(?:ay)?=(.+)$/', $par, $m ) ) {
				$opts['day'] = intval( $m[1] );
			} elseif ( preg_match( '/^date=(.+)$/', $par, $m ) ) {
				if ( ( $date = self::parseDateParam( $m[1] ) ) ) {
					list( $opts['year'], $opts['month'], $opts['day'] ) = $date;
				}
			} else {
				if ( ( $t = Title::newFromText( $par ) ) !== null ) {
					$ns = $t->getNamespace();
					if ( in_array( $ns, $wgWikilogNamespaces ) ) {
						$opts['wikilog'] = $t->getPrefixedDBkey();
					} elseif ( $ns == NS_CATEGORY ) {
						$opts['category'] = $t->getDBkey();
					} elseif ( $ns == NS_USER ) {
						$opts['author'] = $t->getDBkey();
					} elseif ( $ns == NS_TEMPLATE ) {
						$opts['template'] = $t->getDBkey();
					}
				}
			}
		}
	}

	/**
	 * Formats and returns the page header.
	 * @param $opts Form options.
	 * @return HTML of the page header.
	 */
	protected function getHeader( FormOptions $opts ) {
		global $wgScript;

		$out = Html::hidden( 'title', $this->getTitle()->getPrefixedText() );

		$out .= self::getQueryForm( $opts );

		$unconsumed = $opts->getUnconsumedValues();
		foreach ( $unconsumed as $key => $value ) {
			$out .= Html::hidden( $key, $value );
		}

		$out = Xml::tags( 'form', array( 'action' => $wgScript ), $out );
		$out = Xml::fieldset( wfMsg( 'wikilog-form-legend' ), $out,
			array( 'class' => 'wl-options' )
		);
		return $out;
	}

	/**
	 * Formats and returns a query form.
	 * @param $opts Form options.
	 * @return HTML of the query form.
	 */
	protected static function getQueryForm( FormOptions $opts ) {
		global $wgContLang;

		$align = $wgContLang->isRtl() ? 'left' : 'right';
		$fields = self::getQueryFormFields( $opts );
		$columns = array_chunk( $fields, ( count( $fields ) + 1 ) / 2, true );

		$out = Xml::openElement( 'table', array( 'width' => '100%' ) ) .
				Xml::openElement( 'tr' );

		foreach ( $columns as $fields ) {
			$out .= Xml::openElement( 'td' );
			$out .= Xml::openElement( 'table' );

			foreach ( $fields as $row ) {
				$out .= Xml::openElement( 'tr' );
				if ( is_array( $row ) ) {
					$out .= Xml::tags( 'td', array( 'align' => $align ), $row[0] );
					$out .= Xml::tags( 'td', null, $row[1] );
				} else {
					$out .= Xml::tags( 'td', array( 'colspan' => 2 ), $row );
				}
				$out .= Xml::closeElement( 'tr' );
			}

			$out .= Xml::closeElement( 'table' );
			$out .= Xml::closeElement( 'td' );
		}

		$out .= Xml::closeElement( 'tr' ) . Xml::closeElement( 'table' );
		return $out;
	}

	/**
	 * Returns query form fields.
	 * @param $opts Form options.
	 * @return Array of form fields.
	 */
	protected static function getQueryFormFields( FormOptions $opts ) {
		global $wgWikilogEnableTags;

		$fields = array();

		$fields['wikilog'] = Xml::inputLabelSep(
			wfMsg( 'wikilog-form-wikilog' ), 'wikilog', 'wl-wikilog', 40,
			str_replace( '_', ' ', $opts->consumeValue( 'wikilog' ) )
		);

		$fields['category'] = Xml::inputLabelSep(
			wfMsg( 'wikilog-form-category' ), 'category', 'wl-category', 40,
			str_replace( '_', ' ', $opts->consumeValue( 'category' ) )
		);

		$fields['author'] = Xml::inputLabelSep(
			wfMsg( 'wikilog-form-author' ), 'author', 'wl-author', 40,
			str_replace( '_', ' ', $opts->consumeValue( 'author' ) )
		);

		if ( $wgWikilogEnableTags ) {
			$fields['tag'] = Xml::inputLabelSep(
				wfMsg( 'wikilog-form-tag' ), 'tag', 'wl-tag', 40,
				str_replace( '_', ' ', $opts->consumeValue( 'tag' ) )
			);
		}

		$fields['date'] = array(
			Xml::label( wfMsg( 'wikilog-form-date' ), 'wl-month' ),
			Xml::monthSelector( $opts->consumeValue( 'month' ), '', 'wl-month' ) .
				" " . Xml::input( 'year', 4, $opts->consumeValue( 'year' ), array( 'maxlength' => 4 ) )
		);
		$opts->consumeValue( 'day' );	// ignore day, not really useful

		$statusSelect = new XmlSelect( 'show', 'wl-status', $opts->consumeValue( 'show' ) );
		$statusSelect->addOption( wfMsg( 'wikilog-show-all' ), 'all' );
		$statusSelect->addOption( wfMsg( 'wikilog-show-published' ), 'published' );
		$statusSelect->addOption( wfMsg( 'wikilog-show-drafts' ), 'drafts' );
		$fields['status'] = array(
			Xml::label( wfMsg( 'wikilog-form-status' ), 'wl-status' ),
			$statusSelect->getHTML()
		);

		$fields['submit'] = Xml::submitbutton( wfMsg( 'allpagessubmit' ) );
		return $fields;
	}

	/**
	 * Returns a Wikilog query object given the form options.
	 * @param $opts Form options.
	 * @return Wikilog query object.
	 */
	public static function getQuery( $opts ) {
		global $wgWikilogNamespaces;

		$query = new WikilogItemQuery();
		$query->setPubStatus( $opts['show'] );
		if ( $opts['wikilog'] ) {
			$t = Title::newFromText( $opts['wikilog'] );
			if ( $t && in_array( $t->getNamespace(), $wgWikilogNamespaces ) ) {
				if ( $t->getText() == '*' ) {
					$query->setNamespace( $t->getNamespace() );
				} else {
					$query->setWikilogTitle( $t );
				}
			} else {
				$query->setEmpty();
			}
		}
		if ( ( $t = $opts['category'] ) ) {
			$query->setCategory( $t );
		}
		if ( ( $t = $opts['author'] ) ) {
			$query->setAuthor( $t );
		}
		if ( ( $t = $opts['tag'] ) ) {
			$query->setTag( $t );
		}
		$query->setDate( $opts['year'], $opts['month'], $opts['day'] );
		return $query;
	}

	/**
	 * Parse inline date parameter.
	 * @param $date Text representation of date "YYYY-MM-DD".
	 * @return Array(3) if date parsed successfully, where each element
	 *   represents a component of the date, being the last two optional.
	 *   False in case of error.
	 */
	public static function parseDateParam( $date ) {
		$m = array();
		if ( preg_match( '|^(\d+)(?:[/-](\d+)(?:[/-](\d+))?)?$|', $date, $m ) ) {
			return array(
				intval( $m[1] ),
				( isset( $m[2] ) ? intval( $m[2] ) : null ),
				( isset( $m[3] ) ? intval( $m[3] ) : null )
			);
		} else {
			return false;
		}
	}
}
