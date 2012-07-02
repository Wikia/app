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

class WikilogMainPage
	extends Article
	implements WikilogCustomAction
{
	/**
	 * Alternate views.
	 */
	protected static $views = array( 'summary', 'archives' );

	/**
	 * Wikilog data.
	 */
	private   $mWikilogDataLoaded = false;
	public    $mWikilogSubtitle   = false;
	public    $mWikilogIcon       = false;
	public    $mWikilogLogo       = false;
	public    $mWikilogAuthors    = false;
	public    $mWikilogUpdated    = false;
	public    $mWikilogPubdate    = false;

	/**
	 * Constructor.
	 */
	public function __construct( &$title, &$wi ) {
		parent::__construct( $title );
	}

	/**
	 * View action handler.
	 */
	public function view() {
		global $wgRequest, $wgOut, $wgMimeType;

		$query = new WikilogItemQuery( $this->mTitle );
		$query->setPubStatus( $wgRequest->getVal( 'show' ) );

		# RSS or Atom feed requested. Ignore all other options.
		if ( ( $feedFormat = $wgRequest->getVal( 'feed' ) ) ) {
			global $wgWikilogNumArticles;
			$feed = new WikilogItemFeed( $this->mTitle, $feedFormat, $query,
				$wgRequest->getInt( 'limit', $wgWikilogNumArticles ) );
			return $feed->execute();
		}

		# View selection.
		$view = $wgRequest->getVal( 'view', 'summary' );

		# Query filter options.
		$query->setCategory( $wgRequest->getVal( 'category' ) );
		$query->setAuthor( $wgRequest->getVal( 'author' ) );
		$query->setTag( $wgRequest->getVal( 'tag' ) );

		$year = $wgRequest->getIntOrNull( 'year' );
		$month = $wgRequest->getIntOrNull( 'month' );
		$day = $wgRequest->getIntOrNull( 'day' );
		$query->setDate( $year, $month, $day );

		# Display wiki text page contents.
		parent::view();

		# Create pager object, according to the type of listing.
		if ( $view == 'archives' ) {
			$pager = new WikilogArchivesPager( $query );
		} else {
			$pager = new WikilogSummaryPager( $query );
		}

		# Display list of wikilog posts.
		$body = $pager->getBody();
		$body .= $pager->getNavigationBar();
		$wgOut->addHTML( Xml::openElement( 'div', array( 'class' => 'wl-wrapper' ) ) );
		$wgOut->addHTML( $body );
		$wgOut->addHTML( Xml::closeElement( 'div' ) );

		# Get query parameter array, for the following links.
		$qarr = $query->getDefaultQuery();

		# Add feed links.
		$wgOut->setSyndicated();
		if ( isset( $qarr['show'] ) ) {
			$altquery = wfArrayToCGI( array_intersect_key( $qarr, WikilogItemFeed::$paramWhitelist ) );
			$wgOut->setFeedAppendQuery( $altquery );
		}

		# Add links for alternate views.
		foreach ( self::$views as $alt ) {
			if ( $alt != $view ) {
				$altquery = wfArrayToCGI( array( 'view' => $alt ), $qarr );
				$wgOut->addLink( array(
					'rel' => 'alternate',
					'href' => $this->mTitle->getLocalURL( $altquery ),
					'type' => $wgMimeType,
					'title' => wfMsgExt( "wikilog-view-{$alt}",
						array( 'content', 'parsemag' ) )
				) );
			}
		}
	}

	/**
	 * Wikilog action handler.
	 */
	public function wikilog() {
		global $wgUser, $wgOut, $wgRequest;

		if ( $this->mTitle->exists() && $wgRequest->getBool( 'wlActionNewItem' ) )
			return $this->actionNewItem();

		$wgOut->setPageTitle( wfMsg( 'wikilog-tab-title' ) );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );

		if ( $this->mTitle->exists() ) {
			$skin = $wgUser->getSkin();
			$wgOut->addHTML( $this->formatWikilogDescription( $skin ) );
			$wgOut->addHTML( $this->formatWikilogInformation( $skin ) );
			if ( $this->mTitle->quickUserCan( 'edit' ) ) {
				$wgOut->addHTML( $this->formNewItem() );
			}
		} elseif ( $this->mTitle->userCan( 'create' ) ) {
			$text = wfMsgExt( 'wikilog-missing-wikilog', 'parse' );
			$text = WikilogUtils::wrapDiv( 'noarticletext', $text );
			$wgOut->addHTML( $text );
		} else {
			$this->showMissingArticle();
		}
	}

	/**
	 * Returns wikilog description as formatted HTML.
	 */
	protected function formatWikilogDescription( $skin ) {
		$this->loadWikilogData();

		$s = '';
		if ( $this->mWikilogIcon ) {
			$title = Title::makeTitle( NS_IMAGE, $this->mWikilogIcon );
			$file = wfFindFile( $title );
			$s .= $skin->makeImageLink2( $title, $file,
				array( 'align' => 'left' ),
				array( 'width' => '32' )
			);
		}
		$s .= Xml::tags( 'div', array( 'class' => 'wl-title' ),
			$skin->link( $this->mTitle, null, array(), array(), array( 'known', 'noclasses' ) ) );

		$st =& $this->mWikilogSubtitle;
		if ( is_array( $st ) ) {
			$tc = new WlTextConstruct( $st[0], $st[1] );
			$s .= Xml::tags( 'div', array( 'class' => 'wl-subtitle' ), $tc->getHTML() );
		} elseif ( is_string( $st ) && !empty( $st ) ) {
			$s .= Xml::element( 'div', array( 'class' => 'wl-subtitle' ), $st );
		}

		return Xml::tags( 'div', array( 'class' => 'wl-description' ), $s );
	}

	/**
	 * Returns wikilog information as formatted HTML.
	 */
	protected function formatWikilogInformation( $skin ) {
		$dbr = wfGetDB( DB_SLAVE );

		$row = $dbr->selectRow(
			array( 'wikilog_posts', 'page' ),
			'COUNT(*) as total, SUM(wlp_publish) as published',
			array(
				'wlp_page = page_id',
				'wlp_parent' => $this->mTitle->getArticleId(),
				'page_is_redirect' => 0
			),
			__METHOD__
		);
		$n_total = intval( $row->total );
		$n_published = intval( $row->published );
		$n_drafts = $n_total - $n_published;

		$cont = $this->formatPostCount( $skin, 'p', 'published', $n_published );
		$cont .= Xml::openElement( 'ul' );
		$cont .= $this->formatPostCount( $skin, 'li', 'drafts', $n_drafts );
		$cont .= $this->formatPostCount( $skin, 'li', 'all', $n_total );
		$cont .= Xml::closeElement( 'ul' );

		return Xml::fieldset( wfMsg( 'wikilog-information' ), $cont ) . "\n";
	}

	/**
	 * Used by formatWikilogInformation(), formats a post count link.
	 */
	private function formatPostCount( $skin, $elem, $type, $num ) {
		global $wgWikilogFeedClasses;

		// Uses messages 'wikilog-post-count-published', 'wikilog-post-count-drafts', 'wikilog-post-count-all'
		$s = $skin->link( $this->mTitle,
			wfMsgExt( "wikilog-post-count-{$type}", array( 'parsemag' ), $num ),
			array(),
			array( 'view' => "archives", 'show' => $type ),
			array( 'knwon', 'noclasses' )
		);
		if ( !empty( $wgWikilogFeedClasses ) ) {
			$f = array();
			foreach ( $wgWikilogFeedClasses as $format => $class ) {
				$f[] = $skin->link( $this->mTitle,
					wfMsg( "feed-{$format}" ),
					array( 'class' => "feedlink", 'type' => "application/{$format}+xml" ),
					array( 'view' => "archives", 'show' => $type, 'feed' => $format ),
					array( 'known', 'noclasses' )
				);
			}
			$s .= ' (' . implode( ', ', $f ) . ')';
		}
		return Xml::tags( $elem, null, $s );
	}

	/**
	 * Returns a form for new item creation.
	 */
	protected function formNewItem() {
		global $wgScript;

		$fields = array();
		$fields[] = Html::hidden( 'title', $this->mTitle->getPrefixedText() );
		$fields[] = Html::hidden( 'action', 'wikilog' );
		$fields[] = Xml::inputLabel( wfMsg( 'wikilog-item-name' ),
			'wlItemName', 'wl-item-name', 50 );
		$fields[] = Xml::submitButton( wfMsg( 'wikilog-new-item-go' ),
			array( 'name' => 'wlActionNewItem' ) );

		$form = Xml::tags( 'form',
			array( 'action' => $wgScript ),
			implode( "\n", $fields )
		);

		return Xml::fieldset( wfMsg( 'wikilog-new-item' ), $form ) . "\n";
	}

	/**
	 * Wikilog "new item" action handler.
	 */
	protected function actionNewItem() {
		global $wgOut, $wgRequest;

		if ( !$this->mTitle->quickUserCan( 'edit' ) ) {
			$wgOut->loginToUse();
			$wgOut->output();
			exit;
		}

		$itemname = $wgRequest->getText( 'wlItemName' );

		if ( strchr( $itemname, '/' ) !== false )
			throw new ErrorPageError( 'badtitle', 'badtitletext' );

		$title = Title::makeTitle( $this->mTitle->getNamespace(),
			$this->mTitle->getText() . '/' . $itemname );

		if ( $itemname == '' || !$title )
			throw new ErrorPageError( 'badtitle', 'badtitletext' );

		if ( $title->exists() )
			throw new ErrorPageError( 'errorpagetitle', 'articleexists' );

		$wgOut->redirect( $title->getFullURL( 'action=edit' ) );
	}

	/**
	 * Load current article wikilog data.
	 */
	private function loadWikilogData() {
		if ( !$this->mWikilogDataLoaded ) {
			$dbr = wfGetDB( DB_SLAVE );
			$data = $this->getWikilogDataFromId( $dbr, $this->getId() );
			if ( $data ) {
				$this->mWikilogSubtitle = unserialize( $data->wlw_subtitle );
				$this->mWikilogIcon = $data->wlw_icon;
				$this->mWikilogLogo = $data->wlw_logo;
				$this->mWikilogUpdated = wfTimestamp( TS_MW, $data->wlw_updated );
				$this->mWikilogAuthors = unserialize( $data->wlw_authors );
				if ( !is_array( $this->mWikilogAuthors ) ) {
					$this->mWikilogAuthors = array();
				}
			}
			$this->mWikilogDataLoaded = true;
		}
	}

	/**
	 * Return wikilog data from the database, matching a set of conditions.
	 */
	public static function getWikilogData( $dbr, $conditions ) {
		$row = $dbr->selectRow(
			'wikilog_wikilogs',
			array(
				'wlw_page',
				'wlw_subtitle',
				'wlw_icon',
				'wlw_logo',
				'wlw_authors',
				'wlw_updated'
			),
			$conditions,
			__METHOD__
		);
		return $row;
	}

	/**
	 * Return wikilog data from the database, matching the given page ID.
	 */
	public static function getWikilogDataFromId( $dbr, $id ) {
		return self::getWikilogData( $dbr, array( 'wlw_page' => $id ) );
	}
}
