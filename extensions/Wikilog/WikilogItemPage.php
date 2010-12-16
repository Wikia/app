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
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

/**
 * @addtogroup Extensions
 * @author Juliano F. Ravasi < dev juliano info >
 */

if ( !defined( 'MEDIAWIKI' ) )
	die();

/**
 * Wikilog article namespace handler class.
 *
 * Displays a wikilog article. Includes a header and a footer, counts the
 * number of comments, provides a link back to the wikilog main page, etc.
 */
class WikilogItemPage
	extends Article
{
	/**
	 * Wikilog article item object.
	 */
	protected $mItem;

	/**
	 * Constructor.
	 * @param $title Article title object.
	 * @param $wi Wikilog info object.
	 */
	function __construct( &$title, &$wi ) {
		parent::__construct( $title );
		wfLoadExtensionMessages( 'Wikilog' );
		$this->mItem = WikilogItem::newFromInfo( $wi );
	}

	/**
	 * View page action handler.
	 */
	function view() {
		global $wgOut, $wgUser, $wgContLang, $wgFeed, $wgWikilogFeedClasses;

		# Get skin
		$skin = $wgUser->getSkin();

		if ( $this->mItem ) {
			$params = $this->mItem->getMsgParams( true );

			# Set page subtitle
			$subtitleTxt = wfMsgExt( 'wikilog-entry-sub',
				array( 'parsemag', 'content' ),
				$params
			);
			if ( !empty( $subtitleTxt ) ) {
				$wgOut->setSubtitle( $wgOut->parse( $subtitleTxt ) );
			}

			# Display draft notice.
			if ( !$this->mItem->getIsPublished() ) {
				$wgOut->wrapWikiMsg( '<div class="mw-warning">$1</div>', array( 'wikilog-reading-draft' ) );
			}

			# Item page header.
			$headerTxt = wfMsgExt( 'wikilog-entry-header',
				array( 'parse', 'content' ),
				$params
			);
			if ( !empty( $headerTxt ) ) {
				$wgOut->addHtml( WikilogUtils::wrapDiv( 'wl-entry-header', $headerTxt ) );
			}

			# Display article.
			parent::view();

			# Override page title.
			# NOTE (MW1.16+): Must come after parent::view().
			$fullPageTitle = wfMsg( 'wikilog-title-item-full',
					$this->mItem->mName,
					$this->mItem->mParentTitle->getPrefixedText()
			);
			$wgOut->setPageTitle( $this->mItem->mName );
			$wgOut->setHTMLTitle( wfMsg( 'pagetitle', $fullPageTitle ) );

			# Item page footer.
			$footerTxt = wfMsgExt( 'wikilog-entry-footer',
				array( 'parse', 'content' ),
				$params
			);
			if ( !empty( $footerTxt ) ) {
				$wgOut->addHtml( WikilogUtils::wrapDiv( 'wl-entry-footer', $footerTxt ) );
			}

			# Add feed links.
			$links = array();
			if ( $wgFeed ) {
				foreach ( $wgWikilogFeedClasses as $format => $class ) {
					$wgOut->addLink( array(
						'rel' => 'alternate',
						'type' => "application/{$format}+xml",
						'title' => wfMsgExt(
							"page-{$format}-feed",
							array( 'content', 'parsemag' ),
							$this->mItem->mParentTitle->getPrefixedText()
						),
						'href' => $this->mItem->mParentTitle->getLocalUrl( "feed={$format}" )
					) );
				}
			}
		} else {
			# Display article.
			parent::view();
		}
	}

	/**
	 * Override for preSaveTransform. Enables quick post publish by signing
	 * the article using the standard --~~~~ marker. This causes the signature
	 * marker to be replaced by a {{wl-publish:...}} parser function call,
	 * that is then saved to the database and causes the post to be published.
	 */
	function preSaveTransform( $text ) {
		global $wgParser, $wgUser;

		$popt = ParserOptions::newFromUser( $wgUser );

		$t = WikilogUtils::getPublishParameters();
		$date = $t['date'];
		$user = $t['user'];

		$sigs = array(
			'/\n?(--)?~~~~~\n?/m' => "\n{{wl-publish: {$date} }}\n",
			'/\n?(--)?~~~~\n?/m' => "\n{{wl-publish: {$date} | {$user} }}\n",
			'/\n?(--)?~~~\n?/m' => "\n{{wl-author: {$user} }}\n"
		);

		if ( !StubObject::isRealObject( $wgParser ) ) {
			$wgParser->_unstub();
		}
		$wgParser->startExternalParse( $this->mTitle, $popt, Parser::OT_WIKI );

		$text = $wgParser->replaceVariables( $text );
		$text = preg_replace( array_keys( $sigs ), array_values( $sigs ), $text );
		$text = $wgParser->mStripState->unstripBoth( $text );

		return parent::preSaveTransform( $text );
	}
}
