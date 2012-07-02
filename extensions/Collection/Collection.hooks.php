<?php
/**
 * Collection Extension for MediaWiki
 *
 * Copyright (C) PediaPress GmbH
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

class CollectionHooks {
	/**
	 * Callback for hook SkinBuildSidebar
	 *
	 * @param $skin Skin
	 * @param $bar
	 *
	 * @return bool
	 */
	static function buildSidebar( $skin, &$bar ) {
		global $wgUser;
		global $wgCollectionPortletForLoggedInUsersOnly;

		if ( !$wgCollectionPortletForLoggedInUsersOnly || $wgUser->isLoggedIn() ) {
			$html = self::getPortlet( $skin );
			if ( $html ) {
				$bar[ 'coll-print_export' ] = $html;
			}
		}
		return true;
	}

	/**
	 * @param $skin Skin
	 * @param $navUrls
	 * @return bool
	 */
	static function buildNavUrls( $skin, &$navUrls ) {
		global $wgUser;
		global $wgCollectionPortletForLoggedInUsersOnly;

		if ( !$wgCollectionPortletForLoggedInUsersOnly || $wgUser->isLoggedIn() ) {
			// We move this guy out to our own box
			$navUrls['print'] = false;
		}
		return true;
	}

	/**
	 * Return HTML-code to be inserted as portlet
	 *
	 * @param $sk Skin
	 *
	 * @return string
	 */
	static function getPortlet( $sk ) {
		global $wgRequest;
		global $wgCollectionArticleNamespaces;
		global $wgCollectionFormats;
		global $wgCollectionPortletFormats;

		$title = $sk->getTitle();

		if ( is_null( $title ) || !$title->exists() ) {
			return;
		}

		$namespace = $title->getNamespace();

		if ( !in_array( $namespace, $wgCollectionArticleNamespaces )
			&& $namespace != NS_CATEGORY ) {
			return false;
		}

		$action = $wgRequest->getVal( 'action', 'view' );
		if ( $action != 'view' && $action != 'purge' ) {
			return false;
		}

		$out = Xml::element( 'ul', array( 'id' => 'collectionPortletList' ), null );

		if ( !CollectionSession::isEnabled() ) {
			$out .= Xml::tags( 'li',
				array( 'id' => 'coll-create_a_book' ),
				Linker::link(
					SpecialPage::getTitleFor( 'Book' ),
					wfMsgHtml( 'coll-create_a_book' ),
					array(
						'rel' => 'nofollow',
						'title' => wfMsg( 'coll-create_a_book_tooltip' )
					),
					array( 'bookcmd' => 'book_creator', 'referer' => $title->getPrefixedText() ),
					array( 'known', 'noclasses' )
				)
			);
		} else {
			$out .= Xml::tags( 'li',
				array( 'id' => 'coll-book_creator_disable' ),
				Linker::link(
					SpecialPage::getTitleFor( 'Book' ),
					wfMsgHtml( 'coll-book_creator_disable' ),
					array(
						'rel' => 'nofollow',
						'title' => wfMsg( 'coll-book_creator_disable_tooltip' )
					),
					array( 'bookcmd' => 'stop_book_creator', 'referer' => $title->getPrefixedText() ),
					array( 'known', 'noclasses' )
				)
			);
		}

		$params = array(
			'bookcmd' => 'render_article',
			'arttitle' => $title->getPrefixedText(),
		);

		$oldid = $wgRequest->getVal( 'oldid' );
		if ( $oldid ) {
			$params['oldid'] = $oldid;
		} else {
			$params['oldid'] = $title->getLatestRevID();
		}

		foreach ( $wgCollectionPortletFormats as $writer ) {
			$params['writer'] = $writer;
			$out .= Xml::tags( 'li',
				array( 'id' => 'coll-download-as-' . $writer ),
				Linker::link(
					SpecialPage::getTitleFor( 'Book' ),
					wfMsgHtml( 'coll-download_as', htmlspecialchars( $wgCollectionFormats[$writer] ) ),
					array(
						'rel' => 'nofollow',
						'title' => wfMsg( 'coll-download_as_tooltip', $wgCollectionFormats[$writer] )
					),
					$params,
					array( 'known', 'noclasses' )
				)
			);
		}

		// Move the 'printable' link into our section for consistency
		if ( $action == 'view' || $action == 'purge' ) {
			global $wgOut;
			if ( !$wgOut->isPrintable() ) {
				$attribs = array(
					'href' => $sk->getTitle()->getLocalUrl( $wgRequest->appendQueryValue( 'printable', 'yes', true ) ),
					'title' => $sk->titleAttrib( 't-print', 'withaccess' ),
					'accesskey' => $sk->accesskey( 't-print' ),
				);
				if ( $attribs['title'] === false ) {
					unset( $attribs['title'] );
				}
				if ( $attribs['accesskey'] === false ) {
					unset( $attribs['accesskey'] );
				}
				$out .= Xml::tags( 'li',
					array( 'id' => 't-print' ),
					Xml::element( 'a', $attribs, wfMsg( 'printableversion' ) ) );
			}
		}

		$out .= Xml::closeElement( 'ul' );

		return $out;
	}

	/**
	 * Callback for hook SiteNoticeAfter
	 */
	static function siteNoticeAfter( &$siteNotice, $skin = null ) {
		global $wgCollectionArticleNamespaces;
		global $wgRequest;

		$action = $wgRequest->getVal( 'action' );
		if ( $action != '' && $action != 'view' && $action != 'purge' ) {
			return true;
		}

		if ( !CollectionSession::hasSession()
			|| !isset( $_SESSION['wsCollection']['enabled'] )
			|| !$_SESSION['wsCollection']['enabled'] ) {
			return true;
		}

		if ( $skin ) {
			$title = $skin->getTitle();
		} else {
			global $wgTitle;
			$title = $wgTitle;
		}

		if ( $title->isSpecial( 'Book' ) ) {
			$cmd = $wgRequest->getVal( 'bookcmd', '' );
			if ( $cmd == 'suggest' ) {
				$siteNotice .= self::renderBookCreatorBox( $title, 'suggest' );
			} elseif ( $cmd == '' ) {
				$siteNotice .= self::renderBookCreatorBox( $title, 'showbook' );
			}
			return true;
		}

		if ( !$title->exists() ) {
			return true;
		}

		$namespace = $title->getNamespace();
		if ( !in_array( $namespace, $wgCollectionArticleNamespaces )
			&& $namespace != NS_CATEGORY ) {
			return true;
		}

		$siteNotice .= self::renderBookCreatorBox( $title );
		return true;
	}

	/**
	 * @param $title Title
	 * @param $skin Skin
	 * @param $mode string
	 * @return string
	 */
	static function renderBookCreatorBox( $title, $mode = '' ) {
		global $wgCollectionStyleVersion;
		global $wgOut;
		global $wgScriptPath;
		global $wgRequest;

		$imagePath = "$wgScriptPath/extensions/Collection/images";
		$ptext = $title->getPrefixedText();
		$oldid = $wgRequest->getVal( 'oldid', 0 );
		if ( $oldid == $title->getLatestRevID() ) {
			$oldid = 0;
		}

		$wgOut->addModules( 'ext.collection.bookcreator' );

		$addRemoveState = $mode;

		$html = Xml::element( 'div',
			array( 'class' => 'collection-creatorbox' ),
			null
		);

		$html .= Xml::element( 'img',
			array(
				'src' => "$imagePath/Open_book.png?$wgCollectionStyleVersion",
				'alt' => '',
				'width' => '80',
				'height' => '45',
				'class' => 'collection-creatorbox-book',
			),
			'',
			true
		);

		$html .= Xml::tags( 'div',
			array( 'class' => 'collection-creatorbox-row' ),
			Xml::tags( 'div', null,
				Linker::link(
					Title::newFromText( wfMsg( 'coll-helppage' ) ),
					Xml::element( 'img',
						array(
							'src' => "$imagePath/silk-help.png",
							'alt' => '',
							'width' => '16',
							'height' => '16',
						)
					)
					. '&#160;' . wfMsgHtml( 'coll-help' ),
					array(
						'rel' => 'nofollow',
						'title' => wfMsg( 'coll-help_tooltip' ),
					),
					array(),
					array( 'known', 'noclasses' )
				)
			)
			. Xml::tags( 'span',
				array( 'class' => 'collection-creatorbox-title' ),
				wfMsgHtml( 'coll-book_creator' )
			)
			. ' ('
			. Linker::link(
				SpecialPage::getTitleFor( 'Book' ),
				wfMsgHtml( 'coll-disable' ),
				array(
					'rel' => 'nofollow',
					'title' => wfMsg( 'coll-book_creator_disable_tooltip' ),
				),
				array( 'bookcmd' => 'stop_book_creator', 'referer' => $ptext ),
				array( 'known', 'noclasses' )
			)
			. ')'
		);

		$html .= Xml::tags( 'div',
			array(
				'id' => 'coll-book_creator_box',
				'class' => 'collection-creatorbox-row',
			),
			self::getBookCreatorBoxContent( $title, $addRemoveState, $oldid )
	 	);

		$html .= Xml::closeElement( 'div' );
		return $html;
	}

	static function getBookCreatorBoxContent( $title, $ajaxHint = null, $oldid = null ) {
		global $wgScriptPath;

		$imagePath = "$wgScriptPath/extensions/Collection/images";

		return self::getBookCreatorBoxAddRemoveLink( $imagePath, $ajaxHint, $title, $oldid )
			. self::getBookCreatorBoxShowBookLink( $imagePath, $ajaxHint )
			. self::getBookCreatorBoxSuggestLink( $imagePath, $ajaxHint );
	}

	/**
	 * @param $sk Skin
	 * @param $imagePath
	 * @param $ajaxHint
	 * @param $title Title
	 * @param $oldid
	 * @return string
	 */
	static function getBookCreatorBoxAddRemoveLink( $imagePath, $ajaxHint, $title, $oldid ) {
		$namespace = $title->getNamespace();
		$ptext = $title->getPrefixedText();

		if ( $ajaxHint == 'suggest' || $ajaxHint == 'showbook' ) {
			return Xml::tags( 'span',
				array( 'style' => 'color: #777;' ),
				Xml::element( 'img',
					array(
						'src' => "$imagePath/disabled.png",
						'alt' => '',
						'width' => '16',
						'height' => '16',
						'style' => 'vertical-align: text-bottom',
					)
				)
				. '&#160;' . wfMsgHtml( 'coll-not_addable' )
			);
		}

		if ( $ajaxHint == 'addcategory' || $namespace == NS_CATEGORY ) {
			$id = 'coll-add_category';
			$icon = 'silk-add.png';
			$captionMsg = 'coll-add_category';
			$tooltipMsg = 'coll-add_category_tooltip';
			$query = array( 'bookcmd' => 'add_category', 'cattitle' => $title->getText() );
			$onclick = "collectionCall('AddCategory', ['addcategory', wgTitle]); return false;";
		} else {
			if ( $ajaxHint == 'addarticle'
				|| ( $ajaxHint == '' && CollectionSession::findArticle( $ptext, $oldid ) == - 1 ) ) {
				$id = 'coll-add_article';
				$icon = 'silk-add.png';
				$captionMsg = 'coll-add_this_page';
				$tooltipMsg = 'coll-add_page_tooltip';
				$query = array( 'bookcmd' => 'add_article', 'arttitle' => $ptext, 'oldid' => $oldid );
				$onclick = "collectionCall('AddArticle', ['removearticle', wgNamespaceNumber, wgTitle, " .
					Xml::encodeJsVar( $oldid ) . "]); return false;";
			} else {
				$id = 'coll-remove_article';
				$icon = 'silk-remove.png';
				$captionMsg = 'coll-remove_this_page';
				$tooltipMsg = 'coll-remove_page_tooltip';
				$query = array( 'bookcmd' => 'remove_article', 'arttitle' => $ptext, 'oldid' => $oldid );
				$onclick = "collectionCall('RemoveArticle', ['addarticle', wgNamespaceNumber, wgTitle, " .
					Xml::encodeJsVar( $oldid ) . "]); return false;";
			}
		}

		return Linker::link(
			SpecialPage::getTitleFor( 'Book' ),
			Xml::element( 'img',
				array(
					'src' => "$imagePath/$icon",
					'alt' => '',
					'width' => '16',
					'height' => '16',
				)
			)
			. '&#160;' . wfMsgHtml( $captionMsg ),
			array(
				'id' => $id,
				'rel' => 'nofollow',
				'title' => wfMsg( $tooltipMsg ),
				'onclick' => $onclick,
			),
			$query,
			array( 'known', 'noclasses' )
		);

	}

	static function getBookCreatorBoxShowBookLink( $imagePath, $ajaxHint ) {
		$numArticles = CollectionSession::countArticles();

		if ( $ajaxHint == 'showbook' ) {
			return Xml::tags( 'strong',
				array(
					'class' => 'collection-creatorbox-iconlink',
				),
				Xml::element( 'img',
					array(
						'src' => "$imagePath/silk-book_open.png",
						'alt' => '',
						'width' => '16',
						'height' => '16',
					)
				)
				. '&#160;' . wfMsgHtml( 'coll-show_collection' )
				. ' (' . wfMsgExt( 'coll-n_pages', array( 'parsemag', 'escape' ), $numArticles ) . ')'
			);
		} else {
			return Linker::link(
				SpecialPage::getTitleFor( 'Book' ),
				Xml::element( 'img',
					array(
						'src' => "$imagePath/silk-book_open.png",
						'alt' => '',
						'width' => '16',
						'height' => '16',
					)
				)
				. '&#160;' . wfMsgHtml( 'coll-show_collection' )
					. ' (' . wfMsgExt( 'coll-n_pages', array( 'parsemag', 'escape' ), $numArticles ) . ')',
				array(
					'rel' => 'nofollow',
					'title' => wfMsg( 'coll-show_collection_tooltip' ),
					'class' => 'collection-creatorbox-iconlink',
				),
				array(),
				array( 'known', 'noclasses' )
			);
		}
	}

	static function getBookCreatorBoxSuggestLink( $imagePath, $ajaxHint ) {
		if ( wfMsg( 'coll-suggest_enabled' ) != '1' ) {
			return '';
		}

		if ( $ajaxHint == 'suggest' ) {
			return Xml::tags( 'strong',
				array(
					'class' => 'collection-creatorbox-iconlink',
				),
				Xml::element( 'img',
					array(
						'src' => "$imagePath/silk-wand.png",
						'alt' => '',
						'width' => '16',
						'height' => '16',
						'style' => 'vertical-align: text-bottom',
					)
				)
				. '&#160;' . wfMsgHtml( 'coll-make_suggestions' )
			);
		} else {
			return Linker::link(
				SpecialPage::getTitleFor( 'Book' ),
				Xml::element( 'img',
					array(
						'src' => "$imagePath/silk-wand.png",
						'alt' => '',
						'width' => '16',
						'height' => '16',
						'style' => 'vertical-align: text-bottom',
					)
				)
				. '&#160;' . wfMsgHtml( 'coll-make_suggestions' ),
				array(
					'rel' => 'nofollow',
					'title' => wfMsg( 'coll-make_suggestions_tooltip' ),
					'class' => 'collection-creatorbox-iconlink',
				),
				array( 'bookcmd' => 'suggest', ),
				array( 'known', 'noclasses' )
			);
		}
	}

	/**
	* OutputPageCheckLastModified hook
	*/
	static function checkLastModified( $modifiedTimes ) {
		if ( CollectionSession::hasSession() ) {
			$modifiedTimes['collection'] = $_SESSION['wsCollection']['timestamp'];
		}
		return true;
	}

	/**
	 * ResourceLoaderGetConfigVars hook
	 */
	static function resourceLoaderGetConfigVars( &$vars ) {
		$vars['wgCollectionVersion'] = $GLOBALS['wgCollectionVersion'];
		return true;
	}
}
